<?php
namespace RemiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AthleteType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder ->add('nom', TextType::class, array(
                                        'label' => 'Nom'
                    ))
                 ->add('prenom', TextType::class, array(
                                        'label' => 'Prenom'
                    ))
                 ->add('dateNaissance', DateType::class, array(
                                        'label' => 'Date de Naissance'
                    ))
                 ->add('pays', EntityType::class, array(
                                        'class' => 'RemiBundle:Pays',
                                        'multiple' => false,
                                        'choice_label' => 'nom',
                                        'expanded' => false))
                 ->add('discipline', EntityType::class, array(
                                        'class' => 'RemiBundle:Discipline',
                                        'multiple' => false,
                                        'choice_label' => 'nom',
                                        'expanded' => false))
                 ->add('save', SubmitType::class);
    }

    public function getName()
    {
        return 'athlete';
    }
}