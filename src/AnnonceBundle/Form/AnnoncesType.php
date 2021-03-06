<?php

namespace AnnonceBundle\Form;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use  AnnonceBundle\Entity\Gouvernorat;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class AnnoncesType extends AbstractType
{

    public function go()
    {
        $gouv = $this->getDoctrine()->getRepository('AnnonceBundle:Gouvernerat')->find();
        return $gouv ;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AnnonceBundle\Entity\Annonces'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'annoncebundle_annonces';
    }


}
