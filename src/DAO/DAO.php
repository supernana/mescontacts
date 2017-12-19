<?php
/**
 * User: Naeva
 * Date: 18/12/2017
 */

namespace MesContacts\DAO;

use Doctrine\DBAL\Connection;

/**
 * Abstract Class DAO
 * @package MesContacts\DAO
 */
abstract class DAO
{
    /**
     * Connexion à la base de données
     *
     * @var \Doctrine\DBAL\Connection
     */
    private $db;

    /**
     * Constructeur
     *
     * @param \Doctrine\DBAL\Connection l'objet de connexion à la base de données
     */
    public function __construct(Connection $db) {
        $this->db = $db;
    }

    /**
     * Autorise l'accès à l'objet de connexion à la base de données
     *
     * @return \Doctrine\DBAL\Connection l'objet de connexion à la base de données
     */
    protected function getDb() {
        return $this->db;
    }

    /**
     * Génère un objet du domaine à partir d'un tuple
     * Doit être surchargé par les classes enfants.
     *
     * @param array $tuple
     */
    protected abstract function construireObjetDomain(array $tuple);
}