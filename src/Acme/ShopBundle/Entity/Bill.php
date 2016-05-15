<?php
namespace Acme\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Bill
 * @ORM\Table(name="bill",
 *  uniqueConstraints={@ORM\UniqueConstraint(name="SESSION", columns={"session"})}))
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
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="users")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(name="session", type="string", length=50, nullable=true)
     */
    private $session;

    /**
     * @ORM\OneToMany(
     *  targetEntity = "ValueProduct", 
     *  mappedBy     = "bill", 
     *  cascade      = {"persist", "remove"})
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
    /**
     * @ORM\PrePersist
     */
    public function prePersist () 
    {
        if ($this->getCreated() === null) {
            $this->setCreated(new \DateTime('now'));
        }
    }

    /**
     * @ Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if (!$this->getUser() and !$this->getSession()) {
            $context->buildViolation('Bill should have owner.')
                    ->addViolation();
        }
    }


    public function toArray()
    {
        $valueProducts = array();

        foreach ($this->getValueProducts() as $valueProduct) {
            $valueProducts[] = $valueProduct->toArray();
        }

        return array(
            'id'             => $this->getId(),
            'user_id'        => $this->getUserId(),
            'user_name'      => $this->getUser() ? $this->getUser()->getName() : '',
            'valueProducts'  => $valueProducts,
            'created'        => $this->getCreated()->format('d-m-Y H:i:s')
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
        $valueProducts->setBill($this);
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
     */
    private function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    private function getCreated()
    {
        return $this->created;
    }

    /**
     * Set session
     *
     * @param string $session
     * @return Bill
     */
    public function setSession($session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return string 
     */
    public function getSession()
    {
        return $this->session;
    }
}
