<?php
/**
 * User: Naeva
 * Date: 18/12/2017
 */

namespace MesContacts\DAO;

use MesContacts\DAO\DAO;
use MesContacts\Domain\Adresse;

/**
 * Class AdresseDAO
 * @package MesContacts\DAO
 */
class AdresseDAO extends DAO
{
    /**
     * @var \MesContacts\DAO\ContactDAO
     */
    private $contactDAO;

    /**
     * @param ContactDAO $contactDAO
     */
    public function setContactDAO(ContactDAO $contactDAO) {
        $this->contactDAO = $contactDAO;
    }

    /**
     * @param $contactId
     * @return array
     */
    public function chercherToutParContact($contactId) {
        // Le contact associé n'est récupéré qu'une seule fois
        $contact = $this->contactDAO->chercher($contactId);

        // con_id n'est pas sélectionné par la requête SQL
        // Le contact ne sera pas récupéré lors de la construction d'un objet de domaine
        $sql = "select adr_id, adr_rue, adr_code_postal, adr_ville from t_adresse where con_id=? order by adr_id";
        $resultat = $this->getDb()->fetchAll($sql, array($contactId));

        // Converti le résultat de la requète en un tableau d'objets
        $adresses = array();
        foreach ($resultat as $tuple) {
            $adrId = $tuple['adr_id'];
            $adresse = $this->construireObjetDomain($tuple);
            // The associated article is defined for the constructed comment
            // Le contact associé est défini pour l'adresse construite
            $adresse->setContact($contact);
            $adresses[$adrId] = $adresse;
        }
        return $adresses;
    }

    /**
     * Crée un objet Adresse à partir d'un tuple de base de donnée
     *
     * @param array $tuple Le tuple qui contient les données d'un contact
     * @return \MesContacts\Domain\Contact
     */
    protected function construireObjetDomain(array $tuple) {
        $adresse = new Adresse();
        $adresse->setId($tuple['adr_id']);
        $adresse->setRue($tuple['adr_rue']);
        $adresse->setCodePostal($tuple['adr_code_postal']);
        $adresse->setVille($tuple['adr_ville']);

        if (array_key_exists('con_id', $tuple)) {
            // Cherche et initialise le contact associé
            $contactId = $tuple['con_id'];
            $contact = $this->contactDAO->chercher($contactId);
            $adresse->setContact($contact);
        }

        return $adresse;
    }

    /**
     * Retourne une adresse correspondant à l'identifiant fourni
     *
     * @param integer $id
     * @return \MesContacts\Domain\Adresse
     * @throws \Exception si aucune adresse correspondant à $id n'est trouvé
     */
    public function chercher($id){
        $sql = 'select * from t_adresse where adr_id=?';
        $tuple = $this->getDb()->fetchAssoc($sql,array($id));

        if ($tuple) {
            return $this->construireObjetDomain($tuple);
        }
        else {
            throw new \Exception('Aucune adresse ne correspond à l\'id '. $id);
        }
    }

    /**
     * Enregistre une adresse en base de données
     *
     * @param \MesContacts\Domain\Adresse $adresse L'adresse à enregistrée
     */
    public function enregistrer(Adresse $adresse) {
        $adresseData = array(
            'con_id' => $adresse->getContact()->getId(),
            'adr_rue' => $adresse->getRue(),
            'adr_code_postal' => $adresse->getCodePostal(),
            'adr_ville' => $adresse->getVille()
        );

        if ($adresse->getId()) {
            // L'adresse existe déjà : mise à jour
            $this->getDb()->update('t_adresse', $adresseData, array('adr_id' => $adresse->getId()));
        } else {
            // L'adresse n'existe pas : création
            $this->getDb()->insert('t_adresse', $adresseData);
            // Récupère l'id de l'adresse créé et le défini dans l'entité $adresse
            $id = $this->getDb()->lastInsertId();
            $adresse->setId($id);
        }
    }

    /**
     * Supprime une adresse de la base de données
     *
     * @param integer $id L'id de l'adresse
     */
    public function supprimer($id) {
        // Supprime l'adresse
        $this->getDb()->delete('t_adresse', array('adr_id' => $id));
    }

    /**
     * Supprime toutes les adresses d'un contact
     *
     * @param $contactId l'id du contact
     */
    public function supprimerToutParContact($contactId) {
        $this->getDb()->delete('t_adresse', array('con_id' => $contactId));
    }

}