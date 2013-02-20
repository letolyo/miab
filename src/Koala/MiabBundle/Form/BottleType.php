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
            ->add('periodicity', 'integer', array('label' => 'Next apparition in', 'data'=>'30'))
            ->add('visibilite', 'choice', array(
                  'label'=>'Visibility', 
                  'choices' => array('0' => 'Public', '1' => 'Private')))
            ->add('bottleChoice', 'choice', array(
                  'label'=>'Chose a bottle',
                  'choices' => array('1'=>'Classic', '2'=>'Psy', '3'=>'Purple', '4'=>'Wine', '5'=>'Poison'),
                  'attr' => array("onchange" => "javascript:changeBottle(this.value);")))
            ->add('parcheminChoice', 'choice', array(
                  'label' => 'Chose a parchment',
                  'choices' => array('1' => 'Classic brown', '2' => 'Classic grey', '3' => 'Vertical grey'), 
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
