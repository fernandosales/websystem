<?php

namespace AccountancyBundle\Form\Type;

use Oro\Bundle\FormBundle\Form\Type\OroEntitySelectOrCreateInlineType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorySelectType extends AbstractType
{
    const NAME =       'fnz_accountancy_category_select_type';
    const DATA_CLASS = 'AccountancyBundle\Entity\Category';

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'autocomplete_alias' => 'fnz_categories',
                'create_form_route'  => 'category_create',
                'configs'            => [
                    'placeholder'             => 'oro.contact.form.choose_contact',
                    'result_template_twig'    => 'OroFormBundle:Autocomplete:fullName/result.html.twig',
                    'selection_template_twig' => 'OroFormBundle:Autocomplete:fullName/selection.html.twig'
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
}
