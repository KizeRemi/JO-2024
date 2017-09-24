<?php
namespace RemiBundle\Form;

use RemiBundle\Entity\Pays;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PaysType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, array(
                                        'label' => 'form.label.name'
                ))
                ->add('drapeau', FileType::class, array(
                                        'label'      => 'form.label.flag',
                                        'data_class' => null
                ))
                ->add('save', SubmitType::class, array(
                                        'label'        => 'form.label.save'
                ));
    }

    public function getName()
    {
        return 'pays';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Pays::class,
        ));
    }
}