<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('store', 'document', array(
                    'class' => 'AppBundle\Document\Store',
                    'property'     => 'name',
                    'multiple'     => false,
                    'label'=>'Store',
                    'required'=>false,
                    'empty_value' => 'Select a store',
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Document\Product'
        ));
    }

    public function getName()
    {
        return 'appbundle_producttype';
    }
}
