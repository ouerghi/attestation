<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Certificate
 *
 * @ORM\Table(name="certificate")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CertificateRepository")
 */
class Certificate
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
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee" ,cascade={"persist", "remove"})
	 */
    private $employee;
	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", cascade={"persist", "remove"})
	 */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

 public function __construct() {
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
	public function getEmployee() {
		return $this->employee;
	}

	/**
	 * @param mixed $employee
	 */
	public function setEmployee( Employee $employee ) {
		$this->employee = $employee;
	}

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

}
