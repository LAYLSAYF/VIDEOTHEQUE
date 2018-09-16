<?php
namespace AppBundle\DataFixtures\ORM;
 
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\Categorie;
use AppBundle\Utils\Slug as Slug;

 
class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $em)
  {
    $c1 = new  Categorie();
    $c1->setTitre('Comédie');
    $c1->setSlug(Slug::slugify('Comédie'));
 
    $c2 = new Categorie();
    $c2->setTitre('Horreur');
    $c2->setSlug(Slug::slugify('Horreur'));
 
 
    $c3 = new  Categorie();
    $c3->setTitre('Documentaire');
    $c3->setSlug(Slug::slugify('Documentaire'));
 
 
    $c4 = new  Categorie();
    $c4->setTitre('Action');
    $c4->setSlug(Slug::slugify('Action'));
 
 
    $em->persist($c1);
    $em->persist($c2);
    $em->persist($c3);
    $em->persist($c4);
 
    $em->flush();
 
    $this->addReference('category-comedie', $c1);
    $this->addReference('category-horreur', $c2);
    $this->addReference('category-documentaire', $c3);
    $this->addReference('category-action', $c4);
  }
 
  public function getOrder()
  {
    return 1; 
  }
}