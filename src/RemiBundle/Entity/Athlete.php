<?php
namespace RemiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="athlete")
 */

class Athlete {

	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="nom", type="string", length=100, nullable=false)
     * @Assert\Length(
     *      min = 5,
     *      max = 20,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $nom;

    /**
    * @ORM\Column(name="prenom", type="string", length=100, nullable=false)
    */
    private $prenom;

    /**
    * @ORM\Column(name="date_naissance", type="date", length=100, nullable=true)
    */
    private $dateNaissance;

    /**
    * @ORM\ManyToOne(targetEntity="RemiBundle\Entity\Pays")
    * @ORM\JoinColumn(name="pays", referencedColumnName="id")
    */
    private $pays;

    /**
    * @ORM\ManyToOne(targetEntity="RemiBundle\Entity\Discipline")
    * @ORM\JoinColumn(name="discipline", referencedColumnName="id")
    */
    private $discipline;

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
     * @return Athlete
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Athlete
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set dateNaissance
     *
     * @param string $dateNaissance
     *
     * @return Athlete
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return string
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set pays
     *
     * @param \RemiBundle\Entity\Pays $pays
     *
     * @return Athlete
     */
    public function setPays(\RemiBundle\Entity\Pays $pays = null)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return \RemiBundle\Entity\Pays
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set discipline
     *
     * @param \RemiBundle\Entity\Discipline $discipline
     *
     * @return Athlete
     */
    public function setDiscipline(\RemiBundle\Entity\Discipline $discipline = null)
    {
        $this->discipline = $discipline;

        return $this;
    }

    /**
     * Get discipline
     *
     * @return \RemiBundle\Entity\Discipline
     */
    public function getDiscipline()
    {
        return $this->discipline;
    }
}
