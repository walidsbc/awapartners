<?php

namespace SBC\AWAPartnersBundle\Form;

use SBC\AWAPartnersBundle\Entity\Project;
use SBC\UtilsBundle\Utils\DateTransformer;
use SBC\UtilsBundle\Utils\MoneyTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note', TextareaType::class, array(
                    'attr' => array(
                        'class' => 'md-input selecize_init',
                        'rows' => '8'
                    )
                )
            )
            ->add('conceptionPeriode', TextType::class, array(
                    'attr' => array(
                        'class' => 'md-input'
                    ),
                    'required' => false
                )
            )
            ->add(
                $builder
                    ->create('conceptionBeginDate', TextType::class, array(
                            'attr' => array(
                                'data-uk-datepicker' => '{format:\'DD/MM/YYYY\'}',
                                'class' => 'md-input',
                            ),
                            'required' => false
                        )
                    )
                    ->addModelTransformer(new DateTransformer('d/m/Y')
                    )
            )
            ->add(
                $builder
                    ->create('conceptionFinishDate', TextType::class, array(
                            'attr' => array(
                                'data-uk-datepicker' => '{format:\'DD/MM/YYYY\'}',
                                'class' => 'md-input',

                            ),
                            'required' => false
                        )
                    )
                    ->addModelTransformer(new DateTransformer('d/m/Y')
                    )
            )

            ->add('constructionPeriode', TextType::class, array(
                    'attr' => array(
                        'class' => 'md-input'
                    ),
                    'required' => false
                )
            )
            ->add(
                $builder
                    ->create('constructionBeginDate', TextType::class, array(
                            'attr' => array(
                                'data-uk-datepicker' => '{format:\'DD/MM/YYYY\'}',
                                'class' => 'md-input',

                            ),
                            'required' => false
                        )
                    )
                    ->addModelTransformer(new DateTransformer('d/m/Y')
                    )
            )
            ->add(
                $builder
                    ->create('constructionFinishDate', TextType::class, array(
                            'attr' => array(
                                'data-uk-datepicker' => '{format:\'DD/MM/YYYY\'}',
                                'class' => 'md-input',

                            ),
                            'required' => false
                        )
                    )
                    ->addModelTransformer(new DateTransformer('d/m/Y')
                    )
            )
            ->add('title', TextType::class, array(
                    'attr' => array(
                        'class' => 'md-input',
                        'data-parsley-title' => ''
                    )
                )
            )

            ->add('surfaceTerrain', TextType::class, array(
                    'attr' => array(
                        'class' => 'md-input'
                    ),
                    'required' => false
                )
            )

            ->add('surfaceCouverte', TextType::class, array(
                    'attr' => array(
                        'class' => 'md-input'
                    ),
                    'required' => false
                )
            )

            ->add('conceptionTeam', TextType::class, array(
                    'attr' => array(
                        'class' => 'md-input'
                    ),
                    'required' => false
                )
            )

            ->add('composante', TextType::class, array(
                    'attr' => array(
                        'class' => 'md-input'
                    ),
                    'required' => false
                )
            )

            ->add('company', TextType::class, array(
                    'attr' => array(
                        'class' => 'md-input'
                    ),
                    'required' => false
                )
            )

            ->add('tache', TextType::class, array(
                    'attr' => array(
                        'class' => 'md-input'
                    ),
                    'required' => false
                )
            )

            ->add('mission', TextType::class, array(
                    'attr' => array(
                        'class' => 'md-input'
                    ),
                    'required' => false
                )
            )

            ->add('maitreOuvrage', TextType::class, array(
                    'attr' => array(
                        'class' => 'md-input'
                    ),
                    'required' => false
                )
            )

            ->add('description',TextType::class, array(
                'attr' => array(
                    'class' => 'md-input',
                    'data-name' => 'description'
                )
            ))


            ->add('location', TextType::class, array(
                'attr' => array(
                    'class' => 'md-input'
                ),
                'required' => false
            ))
            ->add('client', EntityType::class, array(
                'class' => \SBC\AWAPartnersBundle\Entity\Client::class,
                'placeholder' => '',
                'attr' => array(
                    'class' => 'kendoComboBox select',
                    'style' => 'width:100%'
                )
            ))
            ->add('cout', TextType::class, array(
                    'attr' => array(
                        'class' => 'md-input'
                    ),
                    'required' => false
                )
            )

            ->add('projecType', EntityType::class, array(
                'class' => \SBC\AWAPartnersBundle\Entity\ProjectType::class,
                'placeholder' => '',
                'attr' => array(
                    'class' => 'kendoComboBox select',
                    'style' => 'width:100%'
                )
            ))
            ->add('pictures', CollectionType::class, array(
                    'entry_type' => ProjectPictureType::class,
                    'allow_add' => true,
                    'by_reference' => false,
                )
            )
            ->add('mainPictureFile', \Symfony\Component\Form\Extension\Core\Type\FileType::class, array(
                    'required' => false
                )
            )

        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => Project::class
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbc_awapartnersbundle_project';
    }


}
