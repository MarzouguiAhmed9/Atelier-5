<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Auther;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ref')
            ->add('title')
            ->add('category',ChoiceType::class,['choices' => ['sf'=>'sf','ms'=>'ms','bibliography'=>'bibliography']])
            ->add('publicationDate')
            ->add('published')
            ->add('Auther',EntityType::class,['class'=>Auther::class])
            ->add('submit',SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
