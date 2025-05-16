<?php

/**
* The UserRepository is a Doctrine repository class that manages database operations for User entities in the La Boot'ique e-commerce platform. 
* 
* It extends ServiceEntityRepository and implements PasswordUpgraderInterface to provide password management functionality. 
* The repository includes a method for securely upgrading user passwords, which validates the user type, updates the password hash, and persists the changes to the database. 
* 
* This component is essential for the application's user authentication system, enabling secure password management within the Symfony security framework.
*/

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    /**
    * Constructor for the User repository that initializes the repository with the Doctrine registry and specifies User as the entity class to manage.
    * 
    * @param ManagerRegistry registry The Doctrine registry that provides access to entity managers
    */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
    * Updates a user's password in the database. This method is part of Symfony's password upgrading system and is called when a user's password needs to be changed.
    * 
    * @param PasswordAuthenticatedUserInterface user The user whose password needs to be upgraded
    * @param string newHashedPassword The new password hash that will replace the user's current password
    * 
    * @return void
    * 
    * @throws UnsupportedUserException when the provided user is not an instance of the User class
    */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

}
