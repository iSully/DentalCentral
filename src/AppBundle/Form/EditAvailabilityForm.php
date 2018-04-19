<?php
/**
 * Created by PhpStorm.
 * User: Sully
 * Date: 4/10/18
 * Time: 11:49 AM
 */

namespace AppBundle\Form;


use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditAvailabilityForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'availability',
                ChoiceType::class,
                [
                    'multiple' => true,
                    'expanded' => true,
                    'choices' => [
                        'Monday' => '0',
                        'Tuesday' => '1',
                        'Wednesday' => '2',
                        'Thursday' => '3',
                        'Friday' => '4',
                    ],
                ]
            );
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
            ]
        );
    }
}