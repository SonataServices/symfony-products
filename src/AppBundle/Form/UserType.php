<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password')
            //->add('enabled')
            //->add('accountNonExpired')
            //->add('credentialsNonExpired')
            //->add('accountNonLocked')
            //->add('roles')
            //->add('salt')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Document\User'
        ));
    }

    public function getName()
    {
        return 'appbundle_usertype';
    }
}
