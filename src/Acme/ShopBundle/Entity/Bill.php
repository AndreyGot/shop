<?php
namespace Acme\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Bill
 * @ORM\Table(name="bill")
 * @ORM\Entity(repositoryClass="Acme\ShopBundle\Repository\BillRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Bill
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
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="users")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="ValueProduct", mappedBy="bill")
     */
    private $valueProducts;

    /**
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->valueProducts = new ArrayCollection();
    }

    //* @ORM\PrePersist
    
    // private function prePersist () 
    // {
    //     if ($this->getCreated() === null) {
    //         $this->setCreated(new \DateTime('now'));
    //     }
    // }
    public function normalDateFormat()
    {
        $date = $this->getCreated()->getTimestamp();
        return date('d-m-Y H:i:s', $timestamp = $date);
    }

        public function toArray()
    {
        return array(
            'id'   => $this->getId(),
            'user_id' => $this->getUserId(),
            'created' => $this->normalDateFormat()
            // get_class_methods($this->getCreated())
            );
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
     * Set userId
     *
     * @param integer $userId
     * @return Bill
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set user
     *
     * @param \Acme\ShopBundle\Entity\User $user
     * @return Bill
     */
    public function setUser(\Acme\ShopBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Acme\ShopBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add valueProducts
     *
     * @param \Acme\ShopBundle\Entity\ValueProduct $valueProducts
     * @return Bill
     */
    public function addValueProduct(\Acme\ShopBundle\Entity\ValueProduct $valueProducts)
    {
        $this->valueProducts[] = $valueProducts;

        return $this;
    }

    /**
     * Remove valueProducts
     *
     * @param \Acme\ShopBundle\Entity\ValueProduct $valueProducts
     */
    public function removeValueProduct(\Acme\ShopBundle\Entity\ValueProduct $valueProducts)
    {
        $this->valueProducts->removeElement($valueProducts);
    }

    /**
     * Get valueProducts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getValueProducts()
    {
        return $this->valueProducts;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Post
     * @ORM\PrePersist
     */
    public function setCreated()
    {
        $this->created = new \DateTime('now');

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }
}
