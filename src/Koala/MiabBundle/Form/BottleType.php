<?php

namespace Koala\MiabBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BottleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', 'textarea', array( 'label' => 'Message '))
            ->add('periodicity', 'integer', array('label' => 'Next apparition in'))
            ->add('visibilite', 'choice', array(
    'choices' => array('0' => 'Public', '1' => 'Private')))
            ->add('bottleChoice')
            ->add('parcheminChoice', 'choice', array(
    'choices' => array('1' => 'mar', '2' => 'gr', '3' => 'tr'), 
             'attr' => array("onchange" =>"javascript:changeParchemin(this.value);")))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Koala\MiabBundle\Entity\Bottle'
        ));
    }

    public function getName()
    {
        return 'koala_miabbundle_bottletype';
    }
}
