<?php

namespace InstitutionBundle\Form\Type;

use Oro\Bundle\CurrencyBundle\Form\Type\CurrencyType;
use Oro\Bundle\FormBundle\Form\Type\OroDateType;
use Oro\Bundle\FormBundle\Form\Type\OroMoneyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AccountType extends AbstractType
{
    const NAME =       'institution_account_type';
    const DATA_CLASS = 'InstitutionBundle\Entity\Account';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',
                  TextType::class,
                  [
                      'label' => 'account.name.label',
                  ]
            )
            ->add('number',
                  TextType::class,
                  [
                      'label' => 'account.number.label',
                  ]
            )
            ->add('currency',
                  CurrencyType::class,
                  [
                      'label' => 'account.currency.label',
                  ]
            )
            ->add('openingBalance',
                  OroMoneyType::class,
                  [
                      'label'    => 'account.opening_balance.label',
                      'required' => false,
                  ]
              )
            ->add('minimumBalanceToNotify',
                  OroMoneyType::class,
                  [
                    'label'    => 'account.minimum_balance_to_notify.label',
                    'currency' => false,
                  ]
            )
            ->add('openingDate',
                  OroDateType::class,
                  [
                    'label' => 'account.opening_date.label',
                  ]
            )
            ->add('favorite',
                  CheckboxType::class,
                  [
                    'label' => 'account.favorite.label',
                  ]
            )
            ->add('accountingType',
                  ChoiceType::class,
                  [
                    'label'         => 'account.accounting_type.label',
                    'placeholder'   => 'account.accounting_type.choice.label',
                    'choices'       => [
                                          'account.accounting_type.choice.liability.label' => 0,
                                          'account.accounting_type.choice.asset.label' => 1,
                                        ],
                  ]
            )
            ->add('type',
                  ChoiceType::class,
                  [
                    'label'         => 'account.type.label',
                    'placeholder'   => 'account.type.choice.label',
                    'choices'       => [
                                          'account.type.choice.wallet.label'          => 1,
                                          'account.type.choice.credit_card.label'     => 2,
                                          'account.type.choice.current_account.label' => 3,
                                          'account.type.choice.savings_account.label' => 4,
                                        ],
                  ]
            )
            ->add('institution',
                  InstitutionSelectType::class,
                  [
                      'label' => 'institution.entity_label',
                      'required' => true,
                      'create_enabled' => false,
                      'disabled' => false,
                      'data_parameters' => [],
                  ]
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => self::DATA_CLASS,
        ]);
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
