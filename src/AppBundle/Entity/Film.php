<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Utils\Slug as Slug;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Film
 *
 * @ORM\Table(name="film")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FilmRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Film {

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
     * @ORM\Column(name="titre", type="string", length=100)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="titre_slug", type="string", length=255)
     */
    private $titreSlug;

    /**
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumn(name="categorie_id", referencedColumnName="id")
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     *
     * @var string
     * @ORM\Column(name="image", type="string", nullable=true)
     */
    private $media;
    
    /**
     * @Assert\File(maxSize="500K")
     */
    public $file; 

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ajout", type="datetime")
     */
    private $dateAjout;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="updated_at",type="datetime", nullable=true) 
     */
    private $updateAt;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Film
     */
    public function setTitre($titre) {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre() {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Film
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription($length = null) 
    {
        if (false === is_null($length) && $length > 0){
            return substr($this->description, 0, $length);
        }else{
            return $this->description;
        }
    }
    
    /**
     * Get media
     * 
     * @return string
     */
    function getMedia() {
        return $this->media;
    }
    
    /**
     * Set media
     * 
     * @param string $media
     * 
     * @return Film
     */
    function setMedia($media) {
        $this->media = $media;
    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    
    public function getUploadDir(){
        return 'images';
    }
    
    public function getWebPath()
    {
        return null===$this->media ? null : $this->getUploadDir().'/'.$this->media;
    }
   
    public function uploadImage()
    {
        chmod($this->getUploadRootDir(), 0777);
        $this->file->move($this->getUploadRootDir(),$this->file->getClientOriginalName());
        $this->media = $this->file->getClientOriginalName();
        $this->file = null;
    }

    /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     *
     * @return Film
     */
    public function setDateAjout($dateAjout) {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    /**
     * Get dateAjout
     *
     * @return \DateTime
     */
    public function getDateAjout() {
        return $this->dateAjout;
    }

    /**
     * Set titreSlug
     *
     * @param string $titreSlug
     *
     * @return Film
     */
    public function setTitreSlug($titreSlug) {
        $this->titreSlug = $titreSlug;

        return $this;
    }

    /**
     * Get titreSlug
     *
     * @return string
     */
    public function getTitreSlug() {
        return $this->titreSlug;
    }

    /**
     * Set categorie
     *
     * @param \AppBundle\Entity\Categorie $categorie
     *
     * @return Film
     */
    public function setCategorie(\AppBundle\Entity\Categorie $categorie = null) {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \AppBundle\Entity\Categorie
     */
    public function getCategorie() {
        return $this->categorie;
    }

    /**
     * @ORM\PostLoad()
     * @ORM\PrePersist()
     */
    public function postLoad() {
        $this->updateAt = new \DateTime();
    }
    
    /**
     * @ORM\prePersist()
     */
    public function setSlugValue() 
    {
        $this->titreSlug = Slug::slugify($this->getTitre());
    }
    
    /**
     * @ORM\prePersist()
     */
    public function preSetValueDateAjout() 
    {
        $this->setDateAjout(new \DateTime());
    }
}
