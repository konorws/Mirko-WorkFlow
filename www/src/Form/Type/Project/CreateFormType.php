<?php

namespace App\Form\Type\Project;

use App\Form\Type\Attachment\AttachmentType;
use App\ObjectValue\General\CurrencyObjectValue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class CreateType
 * @package App\Form\Type\Project
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class CreateFormType extends AbstractType
{
    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return '';
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name",TextType::class)
            ->add('description', TextareaType::class, [
                "required" => false
            ])->add("currency", ChoiceType::class, [
                'choices' => CurrencyObjectValue::getAllValues()
            ])->add("rate", NumberType::class, [
                'html5' => true
            ])
            ->add("public", CheckboxType::class, [
                "value" => 1,
                "required" => false
            ])
            ->add("save", SubmitType::class, [
                "label" => "Save project"
            ]);
    }
}
