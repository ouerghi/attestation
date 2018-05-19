<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity("username", message="the username is already exist")

 */
class User extends Employee implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TypeAttestation", cascade={"ALL"})
	 */
    private $typeAttestation;

	/**
	 * @return mixed
	 */
	public function getTypeAttestation() {
		return $this->typeAttestation;
	}

	/**
	 * @param mixed $typeAttestation
	 */
	public function setTypeAttestation( $typeAttestation ) {
		$this->typeAttestation = $typeAttestation;
	}

	/**
	 * @var string
	 *
	 * @ORM\Column(name="email", type="string", length=255, unique=true)
	 */
	private $email;

	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail( $email ) {
		$this->email = $email;
	}

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;



    /**
     * @ORM\Column(type="json_array")
     */
      private $roles = ['ROLE_AGENT'];

	/**
	 * User constructor.
	 */
	public function __construct()
      {
        parent::__construct();
      }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * Set username.
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }


	/**
	 * Returns the roles granted to the user.
	 *
	 * <code>
	 * public function getRoles()
	 * {
	 *     return array('ROLE_USER');
	 * }
	 * </code>
	 *
	 * Alternatively, the roles might be stored on a ``roles`` property,
	 * and populated in any number of different ways when the user object
	 * is created.
	 *
	 * @return array (Role|string)[] The user roles
	 */
    public function getRoles()
    {
        $roles = $this->roles;
        return $roles;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return mixed
     * @see  \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize( array(
            $this->id,
            $this->username,
            $this->password
            )
        );
    }

    /**
     * @param string $serialized
     * @return mixed
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->password,
            $this->username
            ) = unserialize($serialized);
    }




}
