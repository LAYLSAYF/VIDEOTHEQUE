<?php


namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType; 
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class FilmType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, array(
                "label" => 'Titre'
            ))
            ->add('description', TextareaType::class, array(
                "label" => 'Description'
            )) 
            ->add("categorie", EntityType::class, array(
                "class" => "AppBundle\Entity\Categorie",
                "choice_label" => "titre",
                "choice_value" => "slug",
                "query_builder" => function (EntityRepository $er) {
                    return $er->createQueryBuilder("c");
                },
                "placeholder" => "Choisir une catégorie"
            ))
            ->add("file", FileType::class, array(
                "label" => 'Photo'
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Film',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_film';
    }


}
