<?php
namespace Acme\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Value
 * @ORM\Table(name="value_product")
 * @ORM\Entity(repositoryClass="Acme\ShopBundle\Repository\ValueRepository")
 */
class ValueProduct
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
     * @Assert\NotBlank(message="Bill_id is required.")
     * @ORM\Column(name="bill_id", type="integer")
     */
    private $billId;

    /**
     * @ORM\ManyToOne(targetEntity="Bill", inversedBy="bills")
     * @ORM\JoinColumn(name="bill_id", referencedColumnName="id")
     */
    private $bill;

    /**
     * @ORM\Column(name="product_id", type="integer")
     */
    private $productId;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="products")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @Assert\NotBlank(message="Value is required.")
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    public function toArray()
    {
        return array('id'           => $this->getId(), 
                     'bill_id'      => $this->getBillId(),
                     'product_id'   => $this->getProductId(),
                     'product_name' => $this->getProduct()->getName(),
                     'value'        => $this->getValue(),
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
     * Set productId
     *
     * @param integer $productId
     * @return ValueProduct
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get productId
     *
     * @return integer 
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return ValueProduct
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set product
     *
     * @param \Acme\ShopBundle\Entity\Product $product
     * @return ValueProduct
     */
    public function setProduct(\Acme\ShopBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Acme\ShopBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set billId
     *
     * @param integer $billId
     * @return ValueProduct
     */
    public function setBillId($billId)
    {
        $this->billId = $billId;

        return $this;
    }

    /**
     * Get billId
     *
     * @return integer 
     */
    public function getBillId()
    {
        return $this->billId;
    }

    /**
     * Set bill
     *
     * @param \Acme\ShopBundle\Entity\Bill $bill
     * @return ValueProduct
     */
    public function setBill(\Acme\ShopBundle\Entity\Bill $bill = null)
    {
        $this->bill = $bill;

        return $this;
    }

    /**
     * Get bill
     *
     * @return \Acme\ShopBundle\Entity\Bill 
     */
    public function getBill()
    {
        return $this->bill;
    }
}
