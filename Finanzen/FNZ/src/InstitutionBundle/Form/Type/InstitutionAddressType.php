<?php

namespace InstitutionBundle\Form\Type;

use Oro\Bundle\AddressBundle\Form\EventListener\AddressCountryAndRegionSubscriber;
use Oro\Bundle\AddressBundle\Form\EventListener\AddressIdentifierSubscriber;
use Oro\Bundle\AddressBundle\Form\Type\CountryType;
use Oro\Bundle\AddressBundle\Form\Type\RegionType;
use Oro\Bundle\FormBundle\Form\Extension\StripTagsExtension;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstitutionAddressType extends AbstractType
{
    const DATA_CLASS = 'InstitutionBundle\Entity\Address';
    const NAME =       'institution_institution_address_type';

    /**
     * @var AddressCountryAndRegionSubscriber
     */
    private $countryAndRegionSubscriber;
    /**
     * @var AddressIdentifierSubscriber
     */
    private $addressIdentifierSubscriber;

    /**
     * @param AddressCountryAndRegionSubscriber $eventListener
     * @param AddressIdentifierSubscriber $addressIdentifierSubscriber
     */
    public function __construct(
        AddressCountryAndRegionSubscriber $eventListener,
        AddressIdentifierSubscriber $addressIdentifierSubscriber
    ) {
        $this->countryAndRegionSubscriber = $eventListener;
        $this->addressIdentifierSubscriber = $addressIdentifierSubscriber;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder->addEventSubscriber($this->countryAndRegionSubscriber);
      $builder->addEventSubscriber($this->addressIdentifierSubscriber);
      $builder
          ->add('id',
                HiddenType::class,
                [
                    'mapped' => false,
                ]
          )
          ->add('country',
                CountryType::class,
                [
                    'required' => true,
                    'label' => 'oro.address.country.label',
                ]
          )
          ->add('street',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'oro.address.street.label',
                    StripTagsExtension::OPTION_NAME => true,
                ]
          )
          ->add('city',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'oro.address.city.label',
                    StripTagsExtension::OPTION_NAME => true,
                ]
          )
          ->add('region',
                RegionType::class,
                [
                    'required' => false,
                    'label' => 'oro.address.region.label',
                ]
          )
          ->add('region_text',
                HiddenType::class,
                [
                    'required' => false,
                    'random_id' => true,
                    'label' => 'oro.address.region_text.label',
                ]
          )
          ->add('postalCode',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'oro.address.postal_code.label',
                    StripTagsExtension::OPTION_NAME => true,
                ]
          )
      ;

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'    => self::DATA_CLASS,
                'csrf_token_id' => 'address',
                'single_form'   => true,
                'region_route'  => 'oro_api_country_get_regions'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (!empty($options['region_route'])) {
            $view->vars['region_route'] = $options['region_route'];
        }
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
