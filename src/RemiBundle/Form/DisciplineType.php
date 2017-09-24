<?php
namespace RemiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DisciplineType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, array(
                                        'label' => 'form.label.name'
                ))
                ->add('save', SubmitType::class, array(
                                        'label'        => 'form.label.save'
                ));
    }

    public function getName()
    {
        return 'discipline';
    }
}