<?php

namespace App\Form;

use App\Entity\Compra;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\ProductoType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CompraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('fecha', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'label' => 'Fecha de la compra',
            ])
            ->add('productos', CollectionType::class, [
                'entry_type' => ProductoType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Compra::class,
        ]);
    }
}
