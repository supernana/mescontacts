<?php
/**
 * User: Naeva
 * Date: 18/12/2017
 */

namespace MesContacts\Domain;


/**
 * Class Adresse
 * @package MesContacts\Domain
 */
class Adresse
{
    /**
     * Adresse id
     *
     * @var integer
     */
    private $id;

    /**
     * Adresse rue
     *
     * @var string
     */
    private $rue;

    /**
     * Adresse code postal
     *
     * @var string
     */
    private $code_postal;

    /**
     * Adresse ville
     * @var string
     */
    private $ville;

    /**
     * Contact associé
     *
     * @var \MesContacts\Domain\Contact
     */
    private $contact;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getRue(): string
    {
        return $this->rue;
    }

    /**
     * @param string $rue
     */
    public function setRue(string $rue): void
    {
        $this->rue = $rue;
    }

    /**
     * @return string
     */
    public function getCodePostal(): string
    {
        return $this->code_postal;
    }

    /**
     * @param string $code_postal
     */
    public function setCodePostal(string $code_postal): void
    {
        $this->code_postal = $code_postal;
    }

    /**
     * @return string
     */
    public function getVille(): string
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille(string $ville): void
    {
        $this->ville = $ville;
    }

    /**
     * @return Contact
     */
    public function getContact(): Contact
    {
        return $this->contact;
    }

    /**
     * @param Contact $contact
     */
    public function setContact(Contact $contact): void
    {
        $this->contact = $contact;
    }
}