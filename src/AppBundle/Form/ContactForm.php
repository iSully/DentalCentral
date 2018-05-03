<?php
/**
 * Created by PhpStorm.
 * User: Sully
 * Date: 5/2/18
 * Time: 11:04 PM
 */

namespace AppBundle\Form;

use AppBundle\Entity\ContactFormSubmission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['attr' => ['class' => 'form-control', 'placeholder' => 'Name']])
            ->add('email', EmailType::class, ['attr' => ['class' => 'form-control', 'placeholder' => 'Email']])
            ->add('title', TextType::class, ['attr' => ['class' => 'form-control', 'placeholder' => 'Title']])
            ->add(
                'message',
                TextareaType::class,
                [
                    'empty_data' => 'Enter Your Message Here',
                    'required' => true,
                    'attr' => ['class' => 'form-control', 'rows' => 8],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => ContactFormSubmission::class,
            ]
        );
    }
}