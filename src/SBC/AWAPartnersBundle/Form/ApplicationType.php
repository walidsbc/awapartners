<?php

namespace SBC\AWAPartnersBundle\Form;

use SBC\AWAPartnersBundle\Entity\Application;
use SBC\AWAPartnersBundle\Entity\Skill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('requestType', ChoiceType::class, array(
                    'choices' => array(
                        'Demande d\'emploi' => 'Demande d\'emploi',
                        'Demande de stage' => 'Demande de stage',
                    ),
                    'placeholder' => '',
                    'empty_data' => null,
                    'required' => true,
                    'attr' => array(
                        'required' => true,
                        'style' => 'width:100%; border: black solid 1px',

                    )
                )
            )
            ->add('applicationType', ChoiceType::class, array(
                    'choices' => array(
                        'Candidature spontanée' => 'Candidature spontanée',
                        'Suite à une offre publiée' => 'Suite à une offre publiée',
                    ),
                    'placeholder' => '',
                    'empty_data' => null,
                    'required' => true,
                    'attr' => array(

                        'style' => 'width:100%; border: black solid 1px',
                        'onchange' => 'hideshowreference()',
                        'required' => true
                    )
                )
            )

            ->add('skills', EntityType::class, array(
                    'class' => Skill::class,
                    'expanded' => false,
                    'multiple' => true,
                    'placeholder' => '',
                    'required' => false,
                    'attr' => array(
                        'style' => 'width:100%; border: black solid 1px; height:100px',
                        'required' => false
                    )
                )
            )
            ->add('fullName')
            ->add('email')
            ->add('referenceOffre')
            ->add('note')
            ->add('cvFile', \Symfony\Component\Form\Extension\Core\Type\FileType::class, array(
                'required' => true,
                'attr' => array(
                    'class' => 'jfilestyle',
                    'data-input' => 'false'
                )
            ))
            ->add('motivationFile', \Symfony\Component\Form\Extension\Core\Type\FileType::class, array(
                'required' => false,
                'attr' => array(
                    'class' => 'jfilestyle',
                    'data-input' => 'false'
                )
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Application::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbc_awapartnersbundle_application';
    }


}
