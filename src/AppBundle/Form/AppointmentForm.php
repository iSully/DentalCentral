<?php
/**
 * Created by PhpStorm.
 * User: Sully
 * Date: 3/16/18
 * Time: 8:42 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\Appointment;
use AppBundle\Form\Type\LocalDateTimeType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'user',
                EntityType::class,
                [
                    'class' => 'AppBundle\Entity\User',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->where('c.roles NOT LIKE :hygienist')
                            ->andWhere('c.roles NOT LIKE :dentist')
                            ->setParameter('dentist', '%"ROLE_DENTIST"%')
                            ->setParameter('hygienist', '%"ROLE_HYGIENIST"%');
                    },
                    'required' => true,
                    'label' => 'Topkek',
                ]
            )
            ->add(
                'dentist',
                EntityType::class,
                [
                    'class' => 'AppBundle\Entity\User',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->where('c.roles LIKE :roles')
                            ->setParameter('roles', '%"ROLE_DENTIST"%');
                    },
                    'required' => true,
                ]
            )
            ->add(
                'hygienist',
                EntityType::class,
                [
                    'class' => 'AppBundle\Entity\User',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->where('c.roles LIKE :roles')
                            ->setParameter('roles', '%"ROLE_HYGIENIST"%');
                    },
                    'required' => true,
                ]
            )
            ->add('start', LocalDateTimeType::class, ['widget' => 'single_text'])
            ->add(
                'type',
                ChoiceType::class,
                [
                    'choices' => [
                        'Cleaning' => 'cleaning',
                        'Filling' => 'filling',
                        'Tooth Removal' => 'tooth_removal',
                        'Surgery' => 'surgery',
                    ],
                ]
            )
            ->add('end', LocalDateTimeType::class, ['widget' => 'single_text']);



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Appointment::class,
            ]
        );
    }
}