<?php

namespace EyesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * utilisateurs
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="EyesBundle\Entity\articleRepository")
 */
class article
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


      /**
     * @var string
     * @Assert\Image(
     *     maxSize = "2500000",
     *     mimeTypes = {"image/png", "image/jpg", "image/jpeg"}
     * )
     *
     */
    public $fichier;


    /**
     * @var string
     * @Assert\NotBlank(message="Attention vous devez saisir un nom")
     * @Assert\NotBlank(groups={"registration"},message="Attention vous devez saisir un nom")
     * @ORM\Column(name="nom", type="string", length=150)
     */
    private $nom;

    /**
     * @var string
     * @Assert\NotBlank(message="Attention vous devez saisir une description")
     * @Assert\NotBlank(groups={"registration"}, message="Attention vous devez saisir une description")
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer
     * 
     * @ORM\Column(name="prix", type="integer")
     */
    private $prix;

    /**
     * @var string
     * @Assert\NotBlank(groups={"registration"},message="Attention vous devez saisir un pseudo")
     * @ORM\Column(name="pseudo", type="string", length=100)
     */
    private $pseudo;

    /**
     * @var string
     * @Assert\NotBlank(groups={"registrationbis"},message="Attention vous devez saisir une image")
     * @Assert\NotBlank(groups={"registration"},message="Attention vous devez saisir une image")
     * @ORM\Column(name="image", type="string", length=150)
     */
    private $image;

 /**
     * @var string
     * @Assert\NotBlank(groups={"registrationbis"},message="Attention vous devez saisir un email")
     * @Assert\NotBlank(groups={"registration"},message="Attention vous devez saisir un email")
     * @ORM\Column(name="email", type="string", length=150)
     */
    private $email;
    

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
     * Set login
     *
     * @param string $login
     * @return utilisateurs
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return utilisateurs
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set connected
     *
     * @param integer $connected
     * @return utilisateurs
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get connected
     *
     * @return integer 
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return utilisateurs
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }


    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Set pays
     *
     * @param string $pays
     * @return utilisateurs
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    public function getFichier()
    {
        return $this->fichier;
    }

    public function setFichier($fichier=null)
    {
        $this->fichier = $fichier;

        return $this;
    }



    public function upload()
    {
        $nomImage = uniqid()."_".$this->image->getClientOriginalName();

        if ($this->image === null)
        {   //die("ko image");
            return;
        }

        $this->image->move(__DIR__."/../../../../web/images",$nomImage);

        $this->image = $nomImage;
        //var_dump( $this->image);

       // die("jp");

       // $this->image = null;
    }
    
}
