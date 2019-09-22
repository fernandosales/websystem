<?php

namespace AccountancyBundle\Form\Type;

use Oro\Bundle\FormBundle\Form\Type\OroEntitySelectOrCreateInlineType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorySelectType extends AbstractType
{
    const NAME =            'fnz_accountancy_category_select_type';
    const DATA_CLASS =      'AccountancyBundle\Entity\Category';
    const DATA_PARAMETERS = 'data_parameters';

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                self::DATA_PARAMETERS => [],
                'autocomplete_alias' => 'fnz_categories',
                'create_form_route'  => 'fnz.category.category_widget_create',
                'configs'            => [
                                            'placeholder'  => 'accountancy.category.parent_category.placeholder',
                                        ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return OroEntitySelectOrCreateInlineType::class;
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
        return $this->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->options = $options;
    }
}
