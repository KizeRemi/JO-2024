<?php
namespace RemiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="discipline")
 */

class Discipline {

	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="nom", type="string", length=60, nullable=false)
     * @Assert\NotBlank(
     *      message = "form.error.notblank"
     * )
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="Athlete", mappedBy="discipline", orphanRemoval=true)
     */
    private $athletes;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Discipline
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->athletes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add athlete
     *
     * @param \RemiBundle\Entity\Athlete $athlete
     *
     * @return Discipline
     */
    public function addAthlete(\RemiBundle\Entity\Athlete $athlete)
    {
        $this->athletes[] = $athlete;

        return $this;
    }

    /**
     * Remove athlete
     *
     * @param \RemiBundle\Entity\Athlete $athlete
     */
    public function removeAthlete(\RemiBundle\Entity\Athlete $athlete)
    {
        $this->athletes->removeElement($athlete);
    }

    /**
     * Get athletes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAthletes()
    {
        return $this->athletes;
    }
}
