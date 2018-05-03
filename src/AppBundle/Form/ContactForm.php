<?php
/**
 * Created by PhpStorm.
 * User: Sully
 * Date: 5/2/18
 * Time: 11:04 PM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'message', TextareaType::class, [
                'empty_data' => 'Enter Your Message Here',
                'required' => true
            ]
        );
    }
}