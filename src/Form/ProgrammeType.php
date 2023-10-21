<?php
namespace App\Form;

use App\Entity\Programme;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgrammeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('libelle', null, array(
            'required' => true,
            'label' => 'Libelle',
            //'mapped' => false,
            'attr' => ['placeholder' => 'Enter Label'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Programme::class,
            //'allow_extra_fields' => true,
            'csrf_protection' => false
        ));

        //$resolver->setRequired('container');
        //$resolver->setRequired('entity_manager');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }
}