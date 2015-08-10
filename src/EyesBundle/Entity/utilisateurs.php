<?php

namespace EyesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * utilisateurs
 *
 * @ORM\Table(name="utilisateurs")
 * @ORM\Entity(repositoryClass="EyesBundle\Entity\utilisateursRepository")
 */
class utilisateurs
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
     * @Assert\NotBlank(message="Attention vous devez saisir un login")
     * @Assert\NotBlank(groups={"registration"},message="Attention vous devez saisir un login")
     * @ORM\Column(name="login", type="string", length=50)
     */
    private $login;

    /**
     * @var string
     * @Assert\NotBlank(message="Attention vous devez saisir un password")
     * @Assert\NotBlank(groups={"registration"}, message="Attention vous devez saisir un mot de password")
     * @ORM\Column(name="password", type="string", length=50)
     */
    private $password;

    /**
     * @var integer
     * 
     * @ORM\Column(name="connected", type="integer")
     */
    private $connected;

    /**
     * @var string
     * @Assert\NotBlank(groups={"registration"},message="Attention vous devez saisir un email")
     * @ORM\Column(name="email", type="string", length=50)
     */
    private $email;

    /**
     * @var string
     * @Assert\NotBlank(groups={"registrationbis"},message="Attention vous devez saisir un pays")
     * @Assert\NotBlank(groups={"registration"},message="Attention vous devez saisir un pays")
     * @ORM\Column(name="pays", type="string", length=50)
     */
    private $pays;

    /**
     * @var string
     * @Assert\NotBlank(groups={"registrationbis"},message="Attention vous devez saisir une region")
     * @Assert\NotBlank(groups={"registration"}, message="Attention vous devez saisir une region")
     * @ORM\Column(name="region", type="string", length=50)
     */
    private $region;

    /**
     * @var string
     * @Assert\NotBlank(groups={"registrationbis"},message="Attention vous devez saisir une ville")
     * @Assert\NotBlank(groups={"registration"}, message="Attention vous devez saisir une ville")
     * @ORM\Column(name="ville", type="string", length=50)
     */
    private $ville;

    /**
     * @var string
     * @Assert\NotBlank(groups={"registration"}, message="Attention vous devez saisir un code postal")
     * @ORM\Column(name="codepostal", type="string", length=50)
     */
    private $codepostal;

    /**
     * @var string
     * @Assert\NotBlank(groups={"registrationbis"},message="Attention vous devez saisir un age")
     * @Assert\NotBlank(groups={"registration"}, message="Attention vous devez saisir un  age")
     * @ORM\Column(name="age", type="string", length=150)
     */
    private $age;



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
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return utilisateurs
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set connected
     *
     * @param integer $connected
     * @return utilisateurs
     */
    public function setConnected($connected)
    {
        $this->connected = $connected;

        return $this;
    }

    /**
     * Get connected
     *
     * @return integer 
     */
    public function getConnected()
    {
        return $this->connected;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return utilisateurs
     */
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
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string 
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return utilisateurs
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return utilisateurs
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set codepostal
     *
     * @param string $codepostal
     * @return utilisateurs
     */
    public function setCodepostal($codepostal)
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    /**
     * Get codepostal
     *
     * @return string 
     */
    public function getCodepostal()
    {
        return $this->codepostal;
    }

     /**
     * Set age
     *
     * @param string $pays
     * @return utilisateurs
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return string 
     */
    public function getAge()
    {
        return $this->age;
    }

}
