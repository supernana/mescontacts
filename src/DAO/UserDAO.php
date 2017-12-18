<?php
/**
 * User: Naeva
 * Date: 18/12/2017
 */

namespace MesContacts\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use MesContacts\Domain\User;

class UserDAO extends DAO implements UserProviderInterface
{
    /**
     * Retourne l'utilisateur qui correspond à l'id
     *
     * @param integer $id
     *
     * @return \MesContacts\Domain\User
     * @throws \Exception an exception if no matching user is found
     */
    public function cherche($id) {
        $sql = "select * from t_user where usr_id=?";
        $tuple = $this->getDb()->fetchAssoc($sql, array($id));

        if ($tuple) {
            return $this->construiteObjetDomain($tuple);
        }
        else {
            throw new \Exception("Aucun utilisateur ne correspond à l'id " . $id);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        $sql = "select * from t_user where usr_name=?";
        $tuple = $this->getDb()->fetchAssoc($sql, array($username));

        if ($tuple) {
            return $this->construiteObjetDomain($tuple);
        }
        else {
            throw new UsernameNotFoundException(sprintf('User "%s" non trouvé.', $username));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('L\'instance de l\'utilisateur "%s" n\'est pas supporté.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return 'MesContacts\Domain\User' === $class;
    }

    /**
     * Crée un objet Contact à partir d'un tuple de base de donnée
     *
     * @param array $tuple Le tuple qui contient les données d'un contact
     * @return \MesContacts\Domain\User
     */
    protected function construiteObjetDomain(array $tuple) {
        $user = new User();
        $user->setId($tuple['usr_id']);
        $user->setUsername($tuple['usr_name']);
        $user->setPassword($tuple['usr_password']);
        $user->setSalt($tuple['usr_salt']);
        $user->setRole($tuple['usr_role']);
        return $user;
    }
}