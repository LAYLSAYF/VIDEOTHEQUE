<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\RechercheType;
use AppBundle\Form\CategorieType;

/**
 * Form controller.
 */
class FormController extends Controller
{
    /**
     * Search film .
     *
     * @Route("/search/", name="film_search")
     * * @Method({"GET", "POST"})
     */
    public function RechercheAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(RechercheType::class);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $params     = $form->getData();
            $allFilms      = $em->getRepository('AppBundle:Film')->getFilms($params);
            //$countFilms = $em->getRepository('AppBundle:Film')->getCountFilms($params);
            $films = $this->knpPagination($request, $allFilms);
            
            return $this->render('film/index.html.twig', array(
                'films' => $films,
             //  'countFilms' =>$countFilms,
            ));
        }
        
        return $this->render('form/search.html.twig', array(
                'form' => $form->createView()
        ));
    }
    
     /**
     * Category film .
     *
     * @Route("/category", name="film_categorie")
     * @Method({"GET", "POST"})
     */
    public function FilmByCategorieAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CategorieType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $params = $form->getData();
            $allFilms = $em->getRepository('AppBundle:Film')
                    ->findBy(array('categorie' => $params));
            
            $films = $this->knpPagination($request, $allFilms);
            
            $countFilms = $em->getRepository('AppBundle:Film')->getCountFilms($params);
            return $this->render('film/index.html.twig', array(
                    'films' => $films,
                    'countFilms' => $countFilms
            ));
        }
        return $this->render('form/sort_by_category.html.twig', array(
                'form' => $form->createView()
        ));
    }
    
    /**
     * recupère la pagination
     * 
     * @param Request $request
     * @param films $f
     * @return Film
     */
    private function knpPagination(Request $request, $f)
    {
        $paginator = $this->get('knp_paginator');
        $films = $paginator->paginate(
            $f, 
            $request->query->getInt('page', 1),
            10);
        
        return $films;
    }
}

