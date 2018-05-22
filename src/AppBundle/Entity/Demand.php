<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Demand
 *
 * @ORM\Table(name="demand")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandRepository")
 */
class Demand
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TypeAttestation", cascade={"ALL"})
     */
    private $typeAttestation;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee", cascade={"ALL"})
     */
    private $employee;

	/**
	 * @var string
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", cascade={"ALL"})
	 */
	private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

	/**
	 * @ORM\Column(type="boolean", nullable=false)
	 */
    private  $state = false;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private  $ok ;

    public function __construct()
    {
    	$this->date = new \DateTime();
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
	 * Set typeAttestation.
	 *
	 * @param TypeAttestation $typeAttestation
	 *
	 * @return Demand
	 */
    public function setTypeAttestation( TypeAttestation $typeAttestation)
    {
        $this->typeAttestation = $typeAttestation;

        return $this;
    }

    /**
     * Get typeAttestation.
     *
     * @return string
     */
    public function getTypeAttestation()
    {
        return $this->typeAttestation;
    }

	/**
	 * Set employee.
	 *
	 * @param Employee $employee
	 *
	 * @return Demand
	 */
    public function setEmployee(Employee $employee)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Get employee.
     *
     * @return string
     */
    public function getEmployee()
    {
        return $this->employee;
    }

	/**
	 * @return string
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @param User $user
	 */
	public function setUser( User $user ) {
		$this->user = $user;
	}



    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

	/**
	 * @return mixed
	 */
	public function getState() {
		return $this->state;
	}

	/**
	 * @param mixed $state
	 */
	public function setState(  $state ) {
		$this->state = $state;
	}

	/**
	 * @return mixed
	 */
	public function getOk() {
		return $this->ok;
	}

	/**
	 */
	public function setOk() {
		$zone = new \DateTimeZone('Africa/Tunis');
		$this->ok = new \DateTime('now', $zone);
	}


}
