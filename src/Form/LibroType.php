<?php

namespace App\Form;

use App\Entity\Biblioteca;
use App\Entity\Libro;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LibroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('biblioteca', EntityType::class,[
                'class' => Biblioteca::class,
                'choice_label' => 'nombre ',
                'query_builder' => function(EntityRepository $er){
                return $er->createQueryBuilder('b')
                    ->andWhere('1=1');
                },
                'label' => 'Biblioteca'
            ])
            ->add('titulo')
            ->add('autor')
            ->add('tipo')
            ->add('fecha_publicacion')
            ->add('ejemplares')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Libro::class,
        ]);
    }
}
