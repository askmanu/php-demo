<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    /**
     * Builds an address form with fields for personal information, address details, and contact information. The form includes fields for name, first name, last name, company (optional), postal address, postal code, city, country, phone number, and a submit button.
     *
     * @param FormBuilderInterface builder The form builder used to create the form
     * @param array options An array of options for configuring the form
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'adresse',
                'attr' => [
                    'placeholder' => 'ex: Domicile'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                'label' =>'Nom de famille'
            ])
            ->add('company', TextType::class, [
                'label' => 'Société (facultatif)',
                'required' => false,
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse postale',
                'attr' => [
                    'placeholder' => 'ex: 8 rue de Lasoif'
                ]
            ])
            ->add('postal', TextType::class, [
                'label' => 'Code postal'
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville'
            ])
            ->add('country', CountryType::class, [
                'label' => 'Pays'
            ])
            ->add('phone', TelType::class, [
                'label' => 'Téléphone'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer adresse', 
                'attr' => [
                    'class' => 'btn btn-info btn-block mt-2'
                ]
                
            ])
        ;
    }

    /**
     * Configures the options for this form type by setting the data_class default to Address.
     *
     * @param OptionsResolver resolver The resolver for the options
     * 
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
