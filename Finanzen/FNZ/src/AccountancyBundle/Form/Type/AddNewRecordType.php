<?php

namespace AccountancyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Oro\Bundle\FormBundle\Form\Type\OroRichTextType;
use Oro\Bundle\FormBundle\Form\Type\OroDateType;
use Oro\Bundle\FormBundle\Form\Type\Select2EntityType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddNewRecordType extends AbstractType
{
    const NAME =       'fnz_accountancy_add_new_record_type';
    const DATA_CLASS = 'AccountancyBundle\Entity\Record';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('memo',
                OroRichTextType::class,
                [
                    'label'           => 'accountancy.record.memo.label',
                    'required'        => true,
                    'wysiwyg_options' => [
                        'statusbar'     => true,
                        'resize'        => true,
                        'menu'          => true,
                    ],
                ]
            )
            ->add('date',
                OroDateType::class,
                [
                    'label'          => 'accountancy.record.date.label',
                    'placeholder'    => 'accountancy.record.date.placeholder',
                ]
            )
            ->add('amount',
                MoneyType::class,
                [
                    'label'     => 'accountancy.record.amount.label',
                    'currency'  => false,
                    'grouping'  => true,
                ]
            )
            ->add('amount',
                MoneyType::class,
                [
                    'label'     => 'accountancy.record.amount.label',
                    'currency'  => false,
                    'grouping'  => true,
                ]
            )
            ->add('category',
                CategorySelectType::class,
                [
                    'label'                 => 'accountancy.record.category.label',
                    'required'              => false,
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
