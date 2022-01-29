<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Positive;
class HistoriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quartz', NumberType::class, [
                'constraints' => [
                    new Positive(['message' => 'Le nombre de SQ doit être supérieur a 0']),
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Image de couverture',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Format de fichier non valide, veuillez selectionner une image avec l\'extension .png/.jpg/.jpeg',
                    ])
                ]
            ])
            ->add('typeOCR', ChoiceType::class, array(
                'placeholder' => 'Sélectionnez un OCR',
                'required' => true,
                'choices' => [
                    'TesseractOCR' => 'TesseractOCR',
                    'OCR.SPACE' => 'OCR.SPACE',
                ]
            ))
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
