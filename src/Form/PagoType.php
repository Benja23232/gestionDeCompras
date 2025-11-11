<?php

namespace App\Form;

use App\Entity\Pago;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Security\Core\User\UserInterface;

class PagoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var UserInterface $usuarioActual */
        $usuarioActual = $options['usuarioActual'];

        $builder
            ->add('monto', MoneyType::class, [
                'currency' => 'ARS',
                'label' => 'Monto del pago',
            ])
            ->add('fecha', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Fecha del pago',
            ])
            ->add('receptor', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'label' => '¿A quién le estás pagando?',
                'placeholder' => 'Seleccioná un hermano',
                'query_builder' => function (UserRepository $repo) use ($usuarioActual) {
                    return $repo->createQueryBuilder('u')
                        ->where('u != :actual')
                        ->setParameter('actual', $usuarioActual);
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pago::class,
            'usuarioActual' => null,
        ]);
    }
}
