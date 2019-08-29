<?php

namespace InstitutionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InstitutionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
              ['label' => 'institution.name.label']
            )
            ->add('branchNumber', TextType::class,
              ['label' => 'institution.branch_number.label']
            )
            ->add('iban', TextType::class,
              ['label' => 'institution.iban.label']
            )
            ->add('bic',    TextType::class,
              ['label' => 'institution.bic.label']
            )
            ->add('address', InstitutionAddressType::class,
              ['label' => 'institution.address.label']
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'InstitutionBundle\Entity\Institution',
        ]);
    }

    public function getName()
    {
        return 'institution_institution_type';
    }
}
