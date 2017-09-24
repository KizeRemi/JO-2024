<?php
namespace RemiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="pays")
 */

class Pays {

	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="nom", type="string", length=45, nullable=false)
     * @Assert\NotBlank(
     *      message = "form.error.notblank"
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(
     *     message="form.error.notblank"
     *  )
     * @Assert\File(
     *     maxSize = "1024k",
     *     mimeTypes = {"image/png"},
     *     mimeTypesMessage = "form.error.filepng"
     * )
     */
    private $drapeau;

    /**
     * @ORM\OneToMany(targetEntity="Athlete", mappedBy="pays", orphanRemoval=true)
     */
    private $athletes;

    public function getDrapeau()
    {
        return $this->drapeau;
    }

    public function setDrapeau($drapeau)
    {
        $this->drapeau = $drapeau;

        return $this;
    }

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
     * @return Pays
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
}
