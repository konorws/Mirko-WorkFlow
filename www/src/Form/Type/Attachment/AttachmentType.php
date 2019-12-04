<?php

namespace App\Form\Type\Attachment;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Class AttachmentType
 * @package App\Form\Type\Attachment
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class AttachmentType extends AbstractType
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
        $builder->add("file", FileType::class, [
            'multiple' => false,
        ])
            ->add("save", SubmitType::class);
    }
}
