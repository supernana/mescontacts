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
    public function cherche($id){
        $sql = 'select * from t_contact where con_id=?';
        $tuple = $this->getDb()->fetchAssoc($sql,array($id));

        if ($tuple) {
            return $this->construiteObjetDomain($tuple);
        }
        else {
            throw new \Exception('Aucun contact ne correspond à l\'id '. $id);
        }
    }

    /**
     * Retourne la liste de tous les contacts, trié par id (le plus recent en premier)
     *
     * @return array La liste des contacts
     */
    //public function chercheToutParUser($userId){
    public function chercheTout(){
        $userId = 1;
        $sql = 'select * from t_contact where use_id=? order by con_id desc';
        $resultat = $this->getDb()->fetchAll($sql, array($userId));

        // Converti le résultat de la requète en un tableau d'objets
        $contacts= array();
        foreach ($resultat as $tuple) {
            $contactId = $tuple['con_id'];
            $contacts[$contactId] = $this->construiteObjetDomain($tuple);
        }
        return $contacts;
    }

    /**
     * Crée un objet Contact à partir d'un tuple de base de donnée
     *
     * @param array $tuple Le tuple qui contient les données d'un contact
     * @return \MesContacts\Domain\Contact
     */
    protected function construiteObjetDomain(array $tuple) {
        $contact = new Contact();
        $contact->setId($tuple['con_id']);
        $contact->setNom($tuple['con_nom']);
        $contact->setPrenom($tuple['con_prenom']);
        $contact->setEmail($tuple['con_email']);

        if (array_key_exists('use_id', $tuple)) {
            // Cherche et initialise l'utilisateur associé
            $userId = $tuple['use_id'];
            $user = $this->userDAO->cherche($userId);
            $contact->setUser($user);
        }

        return $contact;
    }

}