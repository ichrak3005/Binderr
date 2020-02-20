<?php

namespace classBundle\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class updateTimeTableType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('classe',EntityType::class,array(
                'class'=>'classBundle:classe',
                'choice_label'=>'nom',
                'multiple'=>false,

                'expanded' => false,))
            /*->add('content',\Symfony\Component\Form\Extension\Core\Type\TextType::class
            )*/
            ->add('content',FileType::class,array('label'=>'content',
                'data_class' => null,

                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])]))
            ->add('update',SubmitType::class,[
                'attr' => ['formnovalidate ' => 'formnovalidate']
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'classBundle\Entity\timetable'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'classbundle_timetable';
    }


}
