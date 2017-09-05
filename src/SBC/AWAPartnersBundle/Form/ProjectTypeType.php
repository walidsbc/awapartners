<?php

namespace SBC\AWAPartnersBundle\Form;

use SBC\AWAPartnersBundle\Entity\ProjectType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectTypeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'attr' => array(
                    'class' => 'md-input',
                    'data-parsley-title' => ''
                )
            ))
            ->add('save', SubmitType::class, array(
                'attr' => array(
                    'class' => 'md-btn md-btn-primary'
                )
            ))
        ;}

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ProjectType::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbc_awapartnersbundle_projecttype';
    }


}
