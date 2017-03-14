<?php

namespace AppBundle\Form;

use AppBundle\Entity\Proyecto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProyectoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class)
            ->add('descripcion',TextType::class)
            ->add('categoria', TextType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'=> Proyecto::class
            ]
        );
    }

    public function getName()
    {
        return 'app_bundle_proyecto_type';
    }
}
