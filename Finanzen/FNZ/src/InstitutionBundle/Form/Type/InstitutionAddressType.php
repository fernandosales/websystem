<?php

namespace InstitutionBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Oro\Bundle\AddressBundle\Form\Type\AddressType;

class InstitutionAddressType extends AddressType
{
    const NAME = 'institution_institution_address_type';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->remove('namePrefix')
            ->remove('firstName')
            ->remove('middleName')
            ->remove('lastName')
            ->remove('nameSuffix')
            ->remove('organization')
            ->remove('street2')
        ;

    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return self::NAME;
    }
}
