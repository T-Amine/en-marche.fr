<?php

namespace AppBundle\Form\Jecoute;

use AppBundle\Entity\Jecoute\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextType::class, [
                'filter_emojis' => true,
                'label' => false,
            ])
            ->add('type', QuestionChoiceType::class)
            ->add('choices', CollectionType::class, [
                'entry_type' => ChoiceFormType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'attr' => array(
                    'class' => 'survey-questions-choices-collection',
                ),
                'prototype_name' => '__children_name__',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', Question::class);
    }
}
