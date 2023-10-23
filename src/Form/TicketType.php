<?php
namespace App\Form;

use App\Entity\StatusUser;
use App\Entity\Country;
use App\Entity\Handicap;
use App\Entity\Location;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\RequiredReply;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityRepository;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntites;

class TicketType extends AbstractType
{
    private $container;
    private $entityManager;

    public function __construct(EntityManagerInterface $em, ContainerInterface $container)
    {
        $this->entityManager = $em;
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $container = $this->container;
        $entityManager = $this->entityManager;

        if(!is_object($container->get('user.service')->getSessionUser()) || $container->get('user.service')->getSessionUser() == 'anon.') {

            $builder->add('name', null, [
                'required' => true,
                'label' => 'Your Name',
                'attr' => array('placeholder' => 'Entrer Votre Nom'),
                'mapped' => false,
            ]);

            $builder->add('from', EmailType::class, array(
                'required' => true,
                'label' => 'Your Email',
                'mapped' => false,
                'attr' => array('placeholder' => 'Entrer Votre Email'),
            ));
        }

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

        $builder->add('type', EntityType::class, array(
            'class' => CoreEntites\TicketType::class,
            'choice_label' => 'description',
            'multiple' => false,
            'mapped' => false,
            'attr' => array(
                    'data-role' => 'tagsinput',
                    'data-live-search' => true,
                    'class' => 'selectpicker'
            ),
            'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('type')
                                ->andwhere('type.isActive = :isActive')->setParameter('isActive', true)
                                ->orderBy('type.description', 'ASC');
            },
            'placeholder' => 'Choose query type',
            'empty_data'  => null
        ));

        $builder->add('subject', null, array(
            'required' => true,
            'label' => 'Subject',
            'mapped' => false,
            'attr' => ['placeholder' => 'Enter Subject'],
        ));

        $builder->add('reply', TextareaType::class, array(
            'label' => 'Message',
            'mapped' => false,
            'attr' => array(
                'placeholder' => 'Brief Description about your query',
                'data-iconlibrary' => "fa",
                'data-height' => "250",
            ),
        ));
        $builder->add('attachments', FileType::class, array(
            'label' => '+ Attach File',
            'mapped' => false,
            'multiple' => true,
            'attr' => array(
                'mainLabel' => false,
                'infoLabel' => 'right',
                'infoLabelText' => '+ Attach File',
                'decorateFile' => true,
                'decorateCss' => 'attach-file',
                'enableRemoveOption' => true
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CoreEntites\Ticket::class,
            'allow_extra_fields' => true,
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