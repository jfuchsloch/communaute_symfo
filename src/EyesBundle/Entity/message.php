<?php

namespace EyesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="EyesBundle\Entity\messageRepository")
 */
class message
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_auteur", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_auteur;


      /**
     * @var string
     * @ORM\Column(name="auteur", type="string", length=150)
     */
    public $auteur;


    /**
     * @var string
     * @Assert\NotBlank(message="Attention vous devez saisir un contenu")
     * @Assert\NotBlank(groups={"registration"},message="Attention vous devez saisir un contenu")
     * @ORM\Column(name="contenu", type="string", length=150)
     */
    private $contenu;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="date_message", type="string")
     */
    private $date_message;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId_auteur()
    {
        return $this->id_auteur;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return utilisateurs
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return utilisateurs
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set connected
     *
     * @param integer $connected
     * @return utilisateurs
     */
    public function setDate_message($date_message)
    {
        $this->date_message = $date_message;

        return $this;
    }

    /**
     * Get connected
     *
     * @return integer 
     */
    public function getDate_message()
    {
        return $this->date_message;
    }


 
    
}
