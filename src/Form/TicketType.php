<?php


namespace App\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'Titre'
            ))
            ->add('description', TextType::class, array(
                'label' => 'Description'
            ))
            ->add('ticketType', EntityType::class, [
                'label' => 'Type',
                'class' => 'App\Entity\TicketType',
                'choice_label' => 'label',
            ])

            ->add('priority', ChoiceType::class, [
                'label' => 'Priorité',
                'choices'  => [
                    'Faible' => 0,
                    'Moyenne' => 1,
                    'Elevée' => 2,
                ],
            ])
            ->add('Enregistrer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-outline-primary']
            ])
        ;
    }
}