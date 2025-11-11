<?php

namespace App\Form;

use App\Entity\Compra;
use App\Entity\Producto;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('precio')
            ->add('tieneDescuento', CheckboxType::class, [
                'label' => '¿Tiene descuento?',
                'required' => false,
                'mapped' => true,
            ])
            ->add('descuento', NumberType::class, [
                'label' => 'Descuento (%)',
                'required' => false,
                'scale' => 2,
                'attr' => ['min' => 0, 'max' => 100],
            ])
            ->add('consumidores', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
        ]);
    }
}
