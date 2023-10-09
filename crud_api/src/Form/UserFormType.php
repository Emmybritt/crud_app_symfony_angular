<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['max' => 255]),
                ],
            ])
            ->add('surname', null, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['max' => 60]),
                ],
            ])
            ->add('dateOfBirth', null, [
                'constraints' => [],
            ])
            ->add('gender', null, [
                'constraints' => [
                    new Assert\Choice(['choices' => ['male', 'female', 'other']]),
                ],
            ])
            ->add('status', null, [
                'constraints' => [
                    new Assert\Choice(['choices' => ['low', 'high']]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
