<?php
namespace Acme\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Acme\ShopBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message="Name is required.")
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @Assert\NotBlank(message="Price is required.")
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @Assert\NotBlank(message="CategoryId is required.")
     * @ORM\Column(name="category_id", type="integer")
     */
    private $categoryId;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="ValueProduct", mappedBy="product")
     */
    private $valueProducts;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->valueProducts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function toArray()
    {
        return array('id'           => $this->getId(), 
                     'name'         => $this->getName(),
                     'price'        => $this->getPrice(),
                     'description'  => $this->getDescription(),
                     'category_name' => $this->getCategory()->getName(),
                     'category_id'  => $this->getCategoryId(),
                     // 'valueProducts'=> $this->getValueProducts(),
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
     * Set name
     *
     * @param string $name
     * @return Product
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
     * Set price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     * @return Product
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set category
     *
     * @param \Acme\ShopBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\Acme\ShopBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Acme\ShopBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add valueProducts
     *
     * @param \Acme\ShopBundle\Entity\ValueProduct $valueProducts
     * @return Product
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
}
