<?php

namespace Acme\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 * @ORM\Table(name="user")
 * @UniqueEntity(fields="email", message="Email already taken")
 * @ORM\Entity(repositoryClass="Acme\ShopBundle\Repository\UserRepository")
 */
class User implements UserInterface
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
     * @Assert\Choice(
     *     choices = { "admin", "client" },
     *     message = "Choose a valid user type."
     * )
     * @Assert\NotBlank(message="Type is required.")
     * @ORM\Column(name="type", type="string", length=30)
     */
    private $type;
    
    /**
     * @var string
     *
     * @Assert\NotBlank(message="Name is required.")
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.", checkMX = true)
     * @Assert\NotBlank(message="Email is required.")
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Plain password is required.")
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Phone is required.")
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Address is required.")
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="Bill", mappedBy="user")
     */
    private $bills;

    private $salt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bills = new ArrayCollection();
        $this->salt  = md5(uniqid(null, true));
    }

    public function toArray()
    {
        return array('id'      => $this->getId(), 
                     'type'    => $this->getType(),
                     'name'    => $this->getName(),
                     'phone'   => $this->getPhone(),
                     'address' => $this->getAddress(),
                     'email'   => $this->getEmail(),
                     );

    }

    public function getUsername()
    {
        return $this->getName();
    }

    public function getSalt()
    {
        return null;
        return $this->salt;
    }


    public function getRoles()
    {
        return array();
    }
    public function eraseCredentials()
    {
        return 'eraseCredentials';
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
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
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
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add bills
     *
     * @param \Acme\ShopBundle\Entity\Bill $bills
     * @return User
     */
    public function addBill(\Acme\ShopBundle\Entity\Bill $bills)
    {
        $this->bills[] = $bills;

        return $this;
    }

    /**
     * Remove bills
     *
     * @param \Acme\ShopBundle\Entity\Bill $bills
     */
    public function removeBill(\Acme\ShopBundle\Entity\Bill $bills)
    {
        $this->bills->removeElement($bills);
    }

    /**
     * Get bills
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBills()
    {
        return $this->bills;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
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
     * Set type
     *
     * @param string $type
     * @return User
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set plainPassword
     *
     * @param string $plainPassword
     * @return User
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * Get plainPassword
     *
     * @return string 
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
}
