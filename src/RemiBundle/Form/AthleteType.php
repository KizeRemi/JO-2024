<?php
namespace RemiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AthleteType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, array(
                                        'label' => 'form.label.lastname'
                ))
                ->add('prenom', TextType::class, array(
                                        'label' => 'form.label.firstname'
                ))
                ->add('dateNaissance', DateType::class, array(
                                        'label' => 'form.label.birthdate',
                                        'years' => range(1950,2017)
                ))
                ->add('pays', EntityType::class, array(
                                        'label'        => 'form.label.country',
                                        'class'        => 'RemiBundle:Pays',
                                        'multiple'     => false,
                                        'choice_label' => 'nom',
                                        'expanded'     => false,
                                        'placeholder'  => "form.placeholder.country"
                ))
                ->add('discipline', EntityType::class, array(
                                        'label'        => 'form.label.discipline',
                                        'class'        => 'RemiBundle:Discipline',
                                        'multiple'     => false,
                                        'choice_label' => 'nom',
                                        'expanded'     => false,
                                        'placeholder'  => "form.placeholder.discipline"
                ))
                ->add('photo', FileType::class, array(
                                        'label'      => 'form.label.picture',
                                        'data_class' => null
                ))
                ->add('save', SubmitType::class, array(
                                        'label'        => 'form.label.save'
                ));
    }

    public function getName()
    {
        return 'athlete';
    }
}
