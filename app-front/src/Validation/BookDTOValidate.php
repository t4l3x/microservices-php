<?php

namespace App\Validation;

use App\DTO\BookDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;

class BookDTOValidate extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new Length(['max' => 30]),
                ],
            ])
            ->add('author', TextType::class, [
                'constraints' => [
                    new Length(['max' => 30]),
                ],
            ])
            ->add('pages', IntegerType::class, [
                'constraints' => [
                    new Range(['min' => 0, 'max' => 1000]),
                ],
            ])
            ->add('releaseDate', TextType::class, [

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BookDTO::class,
        ]);
    }
}