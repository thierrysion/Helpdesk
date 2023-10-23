<?php

namespace App\Form;

use App\Entity\StatusUser;
use App\Entity\Country;
use App\Entity\Handicap;
use App\Entity\Location;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Webkul\UVDesk\CoreFrameworkBundle\DataProxies\CreateTicketDataClass;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CreateTicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Customer Name
        $builder->add('name', TextType::class, [
            'required' => true,
            'label' => 'Customer Name',
            'attr' => [
                'placeholder' => 'Enter Name'
            ],
        ]);

        // Customer Email
        $builder->add('from', EmailType::class, [
            'required' => true,
            'label' => 'Your Email',
            'attr' => [
                'placeholder' => 'Enter Your Email'
            ],
        ]);

        $builder->add('sex', ChoiceType::class, [
            'choices'  => [
                'Homme' => 'H',
                'Femme' => 'F',
            ],
            'required' => true,
            'label' => 'Your Gender',
            'mapped' => false,
        ]);

        $builder->add('age', null, [
                'required' => true,
                'label' => 'Your Age',
                'attr' => array('placeholder' => 'Entrer votre age'),
                'mapped' => false,
            ]);

        $builder->add('village', null, [
            'required' => false,
            'label' => 'Your Village',
            'attr' => array('placeholder' => 'Entrer votre Village'),
            'mapped' => false,
        ]);

        $builder->add('quartier', null, [
            'required' => false,
            'label' => 'Your Quartier',
            'attr' => array('placeholder' => 'Entrer votre Quartier'),
            'mapped' => false,
        ]);

        $builder->add('telephone', null, [
            'required' => false,
            'label' => 'Your Phone number',
            'attr' => array('placeholder' => 'Entrer votre Numero de téléphone'),
            'mapped' => false,
        ]);

        $builder->add('statusUser', EntityType::class, array(
            'class' => StatusUser::class,
            'choice_label' => 'status',
            'multiple' => false,
            'mapped' => false,
            'attr' => array(
                    'data-role' => 'tagsinput',
                    'data-live-search' => true,
                    'class' => 'selectpicker'
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('status')
                            //->andwhere('status.isActive = :isActive')->setParameter('isActive', true)
                            ->orderBy('status.libelle', 'ASC');
            },
            'placeholder' => 'Choose user status',
            'empty_data'  => null
        ));

        $builder->add('handicap', EntityType::class, array(
            'class' => Handicap::class,
            'choice_label' => 'handicap',
            'multiple' => false,
            'mapped' => false,
            'attr' => array(
                    'data-role' => 'tagsinput',
                    'data-live-search' => true,
                    'class' => 'selectpicker'
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('h')
                            //->andwhere('status.isActive = :isActive')->setParameter('isActive', true)
                            ->orderBy('h.libelle', 'ASC');
            },
            'placeholder' => 'Handicap',
            'empty_data'  => null,
            'required' => false
        ));

        $builder->add('nationalite', EntityType::class, array(
            'class' => Country::class,
            'choice_label' => 'Nationalite',
            'multiple' => false,
            'mapped' => false,
            'attr' => array(
                    'data-role' => 'tagsinput',
                    'data-live-search' => true,
                    'class' => 'selectpicker'
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                            ->andwhere('c.active = :isActive')->setParameter('isActive', true)
                            ->orderBy('c.libelle', 'ASC');
            },
            'placeholder' => 'Choisir votre nationalite',
            //'empty_data'  => null
        ));

        $builder->add('region', EntityType::class, array(
            'class' => Location::class,
            'choice_label' => 'Region',
            'multiple' => false,
            'mapped' => false,
            'attr' => array(
                    'data-role' => 'tagsinput',
                    'data-live-search' => true,
                    'class' => 'selectpicker'
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('l')
                            ->innerJoin('l.typeLocation','tl')
                            ->andWhere('tl.libelle = :typeLocation')->setParameter('typeLocation', 'Region')
                            ->orderBy('l.libelle', 'ASC');
            },
            'placeholder' => 'Choose your Region',
            'empty_data'  => null
        ));

        $builder->add('departement', EntityType::class, array(
            'class' => Location::class,
            'choice_label' => 'Region',
            'multiple' => false,
            'mapped' => false,
            'attr' => array(
                    'data-role' => 'tagsinput',
                    'data-live-search' => true,
                    'class' => 'selectpicker'
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('l')
                            ->innerJoin('l.typeLocation','tl')
                            ->andWhere('tl.libelle = :typeLocation')->setParameter('typeLocation', 'Departement')
                            ->orderBy('l.libelle', 'ASC');
            },
            'placeholder' => 'Choose your Departement',
            'empty_data'  => null
        ));

        $builder->add('commune', EntityType::class, array(
            'class' => Location::class,
            'choice_label' => 'Region',
            'multiple' => false,
            'mapped' => false,
            'attr' => array(
                    'data-role' => 'tagsinput',
                    'data-live-search' => true,
                    'class' => 'selectpicker'
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('l')
                            ->innerJoin('l.typeLocation','tl')
                            ->andWhere('tl.libelle = :typeLocation')->setParameter('typeLocation', 'Commune')
                            ->orderBy('l.libelle', 'ASC');
            },
            'placeholder' => 'Choose your Commune',
            'empty_data'  => null
        ));

        // Ticket Type
        $builder->add('type', EntityType::class, [
            'class' => TicketType::class,
            'choice_name' => 'description',
            'multiple' => false,
            'attr' => [
                'data-role' => 'tagsinput',
                'class' => 'selectpicker form-control'
            ],
            'query_builder' => function (EntityRepository $ticketTypeRepository) {
                return $ticketTypeRepository->createQueryBuilder('ticketType')->where('ticketType.isActive = 1');
            },
            'placeholder' => 'Choose query type',
        ]);

        // Ticket Subject
        $builder->add('subject', TextType::class, [
            'required' => true,
            'label' => 'Subject',
            'attr' => [
                'placeholder' => 'Enter Subject'
            ],
        ]);

        // Ticket Query Message
        $builder->add('reply', TextareaType::class, [
            'label' => 'Message',
            'attr' => [
                'placeholder' => 'Brief Description about your query',
                'data-iconlibrary' => "fa",
                'data-height' => "250",
            ],
        ]);

        // // Ticket Attachments
        // $builder->add('attachments', 'file', [
        //     'label' => '+ Attach File',
        //     'required' => false,
        //     'multiple' => true,
        //     'attr' => [
        //         'mainLabel' => false,
        //         'infoLabel' => 'right',
        //         'infoLabelText' => '+ Attach File',
        //         'decorateFile' => true,
        //         'decorateCss' => 'attach-file',
        //         'enableRemoveOption' => true
        //     ],
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreateTicketDataClass::class,
            'cascade_validation' => true,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }

    public function getName()
    {
        return '';
    }
}