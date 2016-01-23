<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StoreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('location')
            /*
            ->add('products', 'document', array(
                    'class' => 'AppBundle\Document\Product',
                    'property'     => 'name',
                    'multiple'     => true,
                    'label'=>'Product',
                    'required'=>false,
                    'empty_value' => 'Select a product',
                ))
                */
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Document\Store'
        ));
    }

    public function getName()
    {
        return 'appbundle_storetype';
    }
}
