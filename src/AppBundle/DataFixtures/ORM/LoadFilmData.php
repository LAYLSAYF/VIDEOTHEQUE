<?php
namespace AppBundle\DataFixtures\ORM;
 
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\Film;
use AppBundle\Utils\Slug;
 
class LoadFilmData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $em)
  {
    for($i=0;  $i<=30; $i++)
    {
        $film = new Film();
        $film->setTitre('titreFilm'.$i);
        $film->setTitreSlug(Slug::slugify('titre-film'));
        $film->setDescription('description'.$i);
        $film->setCategorie($em->merge($this->getReference('category-action')));
        $film->setMedia('action.jpg');
        $film->setDateAjout(new \DateTime());
        $em->persist($film);
    }
    
    for($i=0;  $i<=30; $i++)
    {
        $film = new Film();
        $film->setTitre('titreFilm'.$i);
        $film->setTitreSlug(Slug::slugify('titre-film'));
        $film->setDescription('description comedie'.$i);
        $film->setCategorie($em->merge($this->getReference('category-comedie')));
        $film->setMedia('chti.jpg');
        $film->setDateAjout(new \DateTime());
        $em->persist($film);
    }
    
    for($i=0;  $i<=30; $i++)
    {
        $film = new Film();
        $film->setTitre('titreFilm'.$i);
        $film->setTitreSlug(Slug::slugify('titre-film'));
        $film->setDescription('description action'.$i);
        $film->setCategorie($em->merge($this->getReference('category-action')));
        $film->setMedia('requin.jpg');
        $film->setDateAjout(new \DateTime());
        $em->persist($film);
    }
    
    for($i=0;  $i<=30; $i++)
    {
        $film = new Film();
        $film->setTitre('titreFilm'.$i);
        $film->setTitreSlug(Slug::slugify('titre-film'));
        $film->setDescription('description doc'.$i);
        $film->setCategorie($em->merge($this->getReference('category-documentaire')));
        $film->setMedia('french.jpg');
        $film->setDateAjout(new \DateTime());
        $em->persist($film);
    }
 
    $em->flush();
  }
 
  public function getOrder()
  {
    return 2; 
  }
}