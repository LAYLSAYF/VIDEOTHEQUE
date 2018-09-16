<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * FilmRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FilmRepository extends EntityRepository
{
   /**
   * Construction du queryBuilder de base pour la liste des films
   *
   * @param array $params
   *
   * @return QueryBuilder
   */
    public function getSearchedFilmsQueryBase($params)
    {
        $qb = $this->createQueryBuilder('f');
        
        if (isset($params['titre'])) {
            $qb->andWhere('f.titre = :titre')
               ->setParameter('titre', $params['titre']);
        }
        if (isset($params['categorie'])) {
            $qb->innerJoin('f.categorie', 'c')
               ->andWhere('c = :categorie')
               ->setParameter('categorie', $params["categorie"]);
        }
        if (isset($params['createdAt']) && !empty($params['createdAt'])) {
            $qb->andWhere('f.dateAjout = :createdAt')
               ->setParameter('createdAt', $params['createdAt']);
        }
        return $qb;
    }
    
    /**
     * Permet de récupèrer les films en fonction de filter
     *
     * @param array $params
     * 
     * @return array
     */
    public function getFilms(array $params = array())
    {
        $query    = $this->getSearchedFilmsQueryBase($params);
        $results  = $query->getQuery()->getResult();
        return $results;
    }
    
    
    /**
     * Permet de compter les films en fonction de filter
     *
     * @param array $params
     *
     * @return mixed
     */
    public function getCountFilms(array $params = array())
    {
        $countResults = $this->getSearchedFilmsQueryBase($params);
        $count        = $countResults->select('count(1)')->getQuery()
                                     ->getSingleScalarResult();
        return $count;
    }
}