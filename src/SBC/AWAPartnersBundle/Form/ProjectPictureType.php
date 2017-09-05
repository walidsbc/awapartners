<?php

namespace SBC\AWAPartnersBundle\Form;


use SBC\AWAPartnersBundle\Entity\ProjectPicture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectPictureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, array(
                'required' => false,
                'attr' => array(
                    'data-name' => 'picture'
                )

            ))
        ->add('description',TextType::class, array(
            'attr' => array(
                'class' => 'md-input',
                'data-name' => 'description'
            )
        ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ProjectPicture::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbc_awapartnersbundle_projectpicture';
    }


}
