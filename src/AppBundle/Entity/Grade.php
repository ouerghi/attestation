<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Grade
 *
 * @ORM\Table(name="grade")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GradeRepository")
 */
class Grade
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
     * @var int
     *
     * @ORM\Column(name="code_G", type="integer")
     */
    private $codeG;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle_G", type="string", length=255)
     */
    private $libelleG;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User", mappedBy="grade")
     */
    private $users;


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
     * Set codeG.
     *
     * @param int $codeG
     *
     * @return Grade
     */
    public function setCodeG($codeG)
    {
        $this->codeG = $codeG;

        return $this;
    }

    /**
     * Get codeG.
     *
     * @return int
     */
    public function getCodeG()
    {
        return $this->codeG;
    }

    /**
     * Set libelleG.
     *
     * @param string $libelleG
     *
     * @return Grade
     */
    public function setLibelleG($libelleG)
    {
        $this->libelleG = $libelleG;

        return $this;
    }

    /**
     * Get libelleG.
     *
     * @return string
     */
    public function getLibelleG()
    {
        return $this->libelleG;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Grade
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        return $this->users->removeElement($user);
    }

    /**
     * Get users.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
