<?php
/**
 * User: Naeva
 * Date: 18/12/2017
 */

namespace MesContacts\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package MesContacts\Domain
 */
class User implements UserInterface
{
    /**
     * User id
     *
     * @var integer
     */
    private $id;

    /**
     * User name
     *
     * @var string
     */
    private $username;

    /**
     * User password
     *
     * @var string
     */
    private $password;

    /**
     * Salt utilisé pour l'encodage initial du mot de passe.
     *
     * @var string
     */
    private $salt;

    /**
     * Role
     * Valeurs : ROLE_USER ou ROLE_ADMIN
     *
     * @var string
     */
    private $role;


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array($this->getRole());
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
        // Nothing to do here
    }
}