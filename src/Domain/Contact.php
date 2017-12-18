<?php
/**
 * User: Naeva
 * Date: 16/12/2017
 * Time: 11:24
 */

namespace MesContacts\Domain;


/**
 * Class Contact
 * @package MesContacts\Domain
 */
class Contact
{
    /**
     * Contact id
     *
     * @var integer
     */
    private $id;

    /**
     * Utilisateur associé
     *
     * @var \MesContacts\Domain\User
     */
    private $user;

    /**
     * Contact nom
     *
     * @var string
     */
    private $nom;

    /**
     * Contact prénom
     *
     * @var string
     */
    private $prenom;

    /**
     * Contact email
     *
     * @var string
     */
    private $email;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Contact
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return Contact
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     * @return Contact
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

}