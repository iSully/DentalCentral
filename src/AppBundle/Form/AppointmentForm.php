<?php
/**
 * Created by PhpStorm.
 * User: Sully
 * Date: 3/16/18
 * Time: 8:42 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\Appointment;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, array(
                'class' => 'AppBundle\Entity\User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'required' => true
            ))
            ->add('title', TextType::class)
            ->add('start', DateType::class)
            ->add('type', ChoiceType::class, array('choices'=>['Cleaning' => 'cleaning', 'Filling' => 'filling', 'Tooth Removal'=> 'tooth_removal', 'Surgery'=>'surgery']))
            ->add('end', DateType::class);
            //TODO: Add Staff Selections, create separate entities for Dentist and Hygienist's

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Appointment::class
        ));
    }
}