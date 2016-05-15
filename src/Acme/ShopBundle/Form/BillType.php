<?php

namespace Acme\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Acme\ShopBundle\Form\ValueProductType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BillType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('valueProducts', CollectionType::class, array(
            'entry_type'         => ValueProductType::class,
            'allow_add'          => true,
            'by_reference'       => false,
        ));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => 'Acme\ShopBundle\Entity\Bill',
            'csrf_protection' => false,
        ));
    }
}
