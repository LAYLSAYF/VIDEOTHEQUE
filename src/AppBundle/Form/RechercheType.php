<?php


namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class RechercheType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $choices = [ "action" =>"action", "horreur"=>"horreur"];
        $builder
            ->add('titre', TextType::class, array(
                "label" => 'Titre',
                "required" => false
            ))
             ->add("categorie", EntityType::class, array(
                "class" => "AppBundle\Entity\Categorie",
                "choice_label" => "titre",
                "choice_value" => "slug",
                "query_builder" => function (EntityRepository $er) {
                    return $er->createQueryBuilder("c");
                },
                "placeholder" => "Choisir une catégorie",
                "required" => false
            ))
            ->add('createdAt', DateType::class, [
               'label' => 'Date de création',
               'input' => 'string',
               'format' => 'dd/MM/yyyy',
               'widget' => 'single_text',
               'required' => false,
               'attr' => [
                   'class' => 'datepicker'
               ]
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_film_search';
    }


}
