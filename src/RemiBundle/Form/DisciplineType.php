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
        $builder ->add('nom', TextType::class, array(
                                        'label' => 'Nom'
                    ))
                 ->add('save', SubmitType::class);
    }

    public function getName()
    {
        return 'discipline';
    }
}