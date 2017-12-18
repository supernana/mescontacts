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
    public function chercheToutParContact($contactId) {
        // Le contact associé n'est récupéré qu'une seule fois
        $contact = $this->contactDAO->cherche($contactId);

        // con_id n'est pas sélectionné par la requête SQL
        // Le contact ne sera pas récupéré lors de la construction d'un objet de domaine
        $sql = "select adr_id, adr_rue, adr_code_postal, adr_ville from t_adresse where con_id=? order by adr_id";
        $resultat = $this->getDb()->fetchAll($sql, array($contactId));

        // Converti le résultat de la requète en un tableau d'objets
        $adresses = array();
        foreach ($resultat as $tuple) {
            $adrId = $tuple['adr_id'];
            $adresse = $this->construiteObjetDomain($tuple);
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
    protected function construiteObjetDomain(array $tuple) {
        $adresse = new Adresse();
        $adresse->setId($tuple['adr_id']);
        $adresse->setRue($tuple['adr_rue']);
        $adresse->setCodePostal($tuple['adr_code_postal']);
        $adresse->setVille($tuple['adr_ville']);

        if (array_key_exists('con_id', $tuple)) {
            // Cherche et initialise le contact associé
            $contactId = $tuple['con_id'];
            $contact = $this->contactDAO->cherche($contactId);
            $adresse->setContact($contact);
        }

        return $adresse;
    }
}