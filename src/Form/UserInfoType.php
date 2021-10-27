<?php

namespace App\Form;

use App\Entity\UserInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class)
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                ]
            ])
            ->add('quartz', IntegerType::class)
            ->add('bronzeApple', IntegerType::class)
            ->add('silverApple', IntegerType::class)
            ->add('goldenApple', IntegerType::class)
            ->add('manaPrism', IntegerType::class)
            ->add('playerLevel', IntegerType::class)
            ->add('gameVersion', ChoiceType::class, [
                'choices' => [
                    'JP' => 'JP',
                    'NA' => 'NA', 
                    'KR' => 'KR',
                    'CN' => 'CN',
                ]
            ])
            ->add('ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserInfo::class,
        ]);
    }
}
