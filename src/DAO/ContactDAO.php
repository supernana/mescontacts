<?php
/**
 * User: Naeva
 * Date: 16/12/2017
 * Time: 11:37
 */

namespace MesContacts\DAO;

use MesContacts\Domain\Contact;

/**
 * Class ContactDAO
 * @package MesContacts\DAO
 */
class ContactDAO extends DAO
{
    /**
     * @var \MesContacts\DAO\UserDAO
     */
    private $userDAO;

    /**
     * @param UserDAO $userDAO
     */
    public function setUserDAO(UserDAO $userDAO) {
        $this->userDAO = $userDAO;
    }

    /**
     * Retourne un contact correspondant à l'identifiant fourni
     *
     * @param integer $id
     * @return \MesContacts\Domain\Contact
     * @throws \Exception si aucun contact correspondant à $id n'est trouvé
     */
    public function chercher($id){
        $sql = 'select * from t_contact where con_id=?';
        $tuple = $this->getDb()->fetchAssoc($sql,array($id));

        if ($tuple) {
            return $this->construireObjetDomain($tuple);
        }
        else {
            throw new \Exception('Aucun contact ne correspond à l\'id '. $id);
        }
    }

    /**
     * Enregistre un contact en base de données
     *
     * @param \MesContacts\Domain\Contact $contact Le contact à enregistrer
     */
    public function enregistrer(Contact $contact) {
        $contactData = array(
            'con_nom' => $contact->getNom(),
            'con_prenom' => $contact->getPrenom(),
            'con_email' => $contact->getEmail(),
            'use_id' => $contact->getUser()->getId()
        );

        if ($contact->getId()) {
            // Le contact existe déjà : mise à jour
            $this->getDb()->update('t_contact', $contactData, array('con_id' => $contact->getId()));
        } else {
            // Le contact n'existe pas : création
            $this->getDb()->insert('t_contact', $contactData);
            // Récupère l'id du dernier contact créé et le défini dans l'entité $contact
            $id = $this->getDb()->lastInsertId();
            $contact->setId($id);
        }
    }

    /**
     * Supprime un contact de la base de données
     *
     * @param integer $id L'id du contact
     */
    public function supprimer($id) {
        // Supprime le contact
        $this->getDb()->delete('t_contact', array('con_id' => $id));
    }

    /**
     * Retourne la liste de tous les contacts, trié par id (le plus recent en premier)
     *
     * @return array La liste des contacts
     */
    public function chercherToutParUser($userId){
        //$userId = 1;
        $sql = 'select * from t_contact where use_id=? order by con_id desc';
        $resultat = $this->getDb()->fetchAll($sql, array($userId));

        // Converti le résultat de la requète en un tableau d'objets
        $contacts= array();
        foreach ($resultat as $tuple) {
            $contactId = $tuple['con_id'];
            $contacts[$contactId] = $this->construireObjetDomain($tuple);
        }
        return $contacts;
    }

    /**
     * Crée un objet Contact à partir d'un tuple de base de donnée
     *
     * @param array $tuple Le tuple qui contient les données d'un contact
     * @return \MesContacts\Domain\Contact
     */
    protected function construireObjetDomain(array $tuple) {
        $contact = new Contact();
        $contact->setId($tuple['con_id']);
        $contact->setNom($tuple['con_nom']);
        $contact->setPrenom($tuple['con_prenom']);
        $contact->setEmail($tuple['con_email']);

        if (array_key_exists('use_id', $tuple)) {
            // Cherche et initialise l'utilisateur associé
            $userId = $tuple['use_id'];
            $user = $this->userDAO->chercher($userId);
            $contact->setUser($user);
        }

        return $contact;
    }



}