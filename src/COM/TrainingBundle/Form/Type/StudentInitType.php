<?php
namespace COM\TrainingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StudentInitType extends AbstractType
{
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class)
                ->add('firstname', TextType::class)
                ->add('sex', TextType::class)
                ->add('birthdate', TextType::class)
                ->add('birthlocation', TextType::class)
                ->add('cin', TextType::class)
                ->add('cindate', TextType::class)
                ->add('cinlocation', TextType::class)
                ->add('address', TextType::class)
                ->add('phone', TextType::class)
                ->add('email', TextType::class)
                ->add('matricule', TextType::class)
				->add('save',      SubmitType::class);
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'COM\TrainingBundle\Form\Type\StudentInit',
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}

