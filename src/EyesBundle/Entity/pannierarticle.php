<?php

namespace EyesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * utilisateurs
 *
 * @ORM\Table(name="panier_article")
 * @ORM\Entity(repositoryClass="EyesBundle\Entity\pannierarticleRepository")
 */
class pannierarticle
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_article", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_article;


   

    /**
     * @var string
     * @Assert\NotBlank(message="Attention vous devez saisir un nom")
     * @Assert\NotBlank(groups={"registration"},message="Attention vous devez saisir un nom")
     * @ORM\Column(name="nom", type="string", length=150)
     */
    private $nom;

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
     * @Assert\NotBlank(groups={"registration"},message="Attention vous devez saisir un pseudo auteur article")
     * @ORM\Column(name="pseudo_auteurArticle", type="string", length=100)
     */
    private $pseudo_auteurArticle;

  

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId_article()
    {
        return $this->id_article;
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


    public function setPseudo_auteurArticle($pseudo_auteurArticle)
    {
        $this->pseudo_auteurArticle = $pseudo_auteurArticle;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getPseudo_auteurArticle()
    {
        return $this->pseudo_auteurArticle;
    }



    
}
