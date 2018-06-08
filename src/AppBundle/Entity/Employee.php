<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Employee
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="type", type="string")
 * @DiscriminatorMap({"user" = "User", "employee" = "Employee"})
 * @ORM\Table(name="employee")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmployeeRepository")
 */
 class Employee
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
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", cascade={"remove"})
	 * @ORM\JoinColumn(onDelete="SET NULL")
	 */
	private $user;

	/**
	 * @return mixed
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @param mixed $user
	 */
	public function setUser( User $user ) {
		$this->user = $user;
	}

	 /**
	  * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Service")
	  * @Assert\NotBlank()
	  */
	 protected $service;

	 /**
	  * @return mixed
	  */
	 public function getService() {
		 return $this->service;
	 }

	 /**
	  * @param mixed $service
	  */
	 public function setService( $service ) {
		 $this->service = $service;
	 }

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Grade")
	 * @ORM\JoinColumn(name="grade_id", referencedColumnName="id")
	 * @Assert\NotBlank()
	 */
    protected $grade;

	/**
	 * @return mixed
	 */
	public function getGrade() {
		return $this->grade;
	}

	/**
	 * @param mixed $grade
	 */
	public function setGrade( Grade $grade ) {
		$this->grade = $grade;
	}

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="matricule", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(min="8", max="8", exactMessage="la longueur du matricule doit etre égale à 8")
     */
    protected $matricule;

    /**
     * @var string
     *
     * @ORM\Column(name="cin", type="integer", length=255, unique=true)
     *  @Assert\NotBlank()
     * @Assert\Length(min="8", max="8", exactMessage="la longueur du cin doit etre égale à 8")
     */
    protected $cin;

    /**
     * @var string
     *
     * @ORM\Column(name="nationality", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $nationality;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50)
     * @Assert\NotBlank()
     */
    protected $status;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $address;
	 /**
	  * @var string
	  *
	  * @ORM\Column(name="mission", type="string", length=255)
	  */
	 protected $mission;

	 /**
	  * @var string
	  *
	  * @ORM\Column(name="numberOfChildren", type="integer", length=2)
	  */
     protected $numberOfChildren;

	 /**
	  * @var string
	  *
	  * @ORM\Column(name="revenuImposable", type="float")
	  */
      protected $revenuImposable;
	 /**
	  * @var string
	  *
	  * @ORM\Column(name="privilege", type="float")
	  */
	 protected $privilege;

    /**
     * @var int|null
     *
     * @ORM\Column(name="workingDuration", type="integer", nullable=true)
     */
    protected $workingDuration;


    protected $totalRevenuBrut;

	 /**
	  * @var string
	  *
	  * @ORM\Column(name="dateCreation", type="datetime")
	  */
	 protected $dateCreation;


	 /**
	  * Employee constructor.
	  */
	 public function __construct() {
	 	$this->dateCreation = new \DateTime();
	 }

	 /**
     * Get id.
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }




    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Employee
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return Employee
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set matricule.
     *
     * @param string $matricule
     *
     * @return Employee
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule.
     *
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set cin.
     *
     * @param string $cin
     *
     * @return Employee
     */
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin.
     *
     * @return string
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set nationality.
     *
     * @param string $nationality
     *
     * @return Employee
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Get nationality.
     *
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return Employee
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

	 /**
	  * Set address.
	  *
	  * @param $address
	  *
	  * @return Employee
	  */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set workingDuration.
     *
     * @param int|null $workingDuration
     *
     * @return Employee
     */
    public function setWorkingDuration($workingDuration = null)
    {
        $this->workingDuration = $workingDuration;

        return $this;
    }

    /**
     * Get workingDuration.
     *
     * @return int|null
     */
    public function getWorkingDuration()
    {
        return $this->workingDuration;
    }

	 /**
	  * @return string
	  */
	 public function getMission() {
		 return $this->mission;
	 }

	 /**
	  * @param string $mission
	  */
	 public function setMission( $mission ) {
		 $this->mission = $mission;
	 }

	 /**
	  * @return string
	  */
	 public function getNumberOfChildren() {
		 return $this->numberOfChildren;
	 }

	 /**
	  * @param string $numberOfChildren
	  */
	 public function setNumberOfChildren( $numberOfChildren ) {
		 $this->numberOfChildren = $numberOfChildren;
	 }

	 /**
	  * @return string
	  */
	 public function getRevenuImposable() {
		 return $this->revenuImposable;
	 }

	 /**
	  * @param string $revenuImposable
	  */
	 public function setRevenuImposable( $revenuImposable ) {
		 $this->revenuImposable = $revenuImposable;
	 }

	 /**
	  * @return string
	  */
	 public function getPrivilege() {
		 return $this->privilege;
	 }

	 /**
	  * @param string $privilege
	  */
	 public function setPrivilege( $privilege ) {
		 $this->privilege = $privilege;
	 }

	 /**
	  * @return int|null
	  */
	 public function getTotalRevenuBrut() {
		 return $this->totalRevenuBrut;
	 }

	 /**
	  * @param int|null $totalRevenuBrut
	  */
	 public function setTotalRevenuBrut( $totalRevenuBrut ) {
		 $this->totalRevenuBrut = $totalRevenuBrut;
	 }

	 /**
	  * @return string
	  */
	 public function getDateCreation() {
		 return $this->dateCreation;
	 }



}
