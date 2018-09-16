<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Film;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\FilmType;

/**
 * Film controller.
 */
class FilmController extends Controller
{
    /**
     * Lists all film entities.
     *
     * @Route("film/", name="film_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $allFilms = $em->getRepository('AppBundle:Film')->findAll();
        $countFilms = count($allFilms);
        
        $paginator = $this->get('knp_paginator');
        $films = $paginator->paginate(
            $allFilms, 
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('film/index.html.twig', array(
            'films' => $films,
             'countFilms' =>$countFilms
        ));
    }

    /**
     * Creates a new film entity.
     *
     * @Route("film/new", name="film_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $film->uploadImage();
            
            $this->flash()
                ->addSuccess("Le film est ajouté. Un mail de confirmation à été envoyé à l'admnistrateur");

            $em->persist($film);
            $em->flush();
            
            $message = \Swift_Message::newInstance()
             ->setSubject("[Gestion des films'] - Ajout")
             // Get Email adminstrator from Config.
             ->setFrom($this->getParameter('email_admnistrator'))
             // Get Email adminstrator from Config 
             ->setTo($this->getParameter('email_admnistrator'))
             ->setBody($this->renderView('form/email.text.twig', 
                       array('film' => $film)
             ));
            $this->get('mailer')->send($message);
            
            return $this->redirectToRoute('film_show', array(
                'id' => $film->getId(),
                'slugCategorie'   => $film->getCategorie()->getSlug(),
                'slugTitreFilm' => $film->getTitre()
            ));
        }

        return $this->render('film/new.html.twig', array(
            'film' => $film,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a film entity.
     *
     * @Route("/{slugCategorie}/{slugTitreFilm}-{id}", name="film_show")
     * @Method("GET")
     */
    public function showAction(Film $film)
    {
        return $this->render('film/show.html.twig', array(
            'film' => $film,
        ));
    }

    /**
     * Displays a form to edit an existing film entity.
     *
     * @Route("film/{id}/edit", name="film_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Film $film)
    {
        $editForm = $this->createForm('AppBundle\Form\FilmType', $film);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->merge($film);
            $em->flush();
            
            return $this->redirectToRoute('film_edit', 
                    array('id' => $film->getId()));
        }

        return $this->render('film/edit.html.twig', array(
            'film' => $film,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a film entity.
     *
     * @Route("film/{id}/delete", name="film_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $film = $em->getRepository("AppBundle:Film")->find($id);
        $em->remove($film);
        $em->flush();
        $this->flash()->addSuccess("Le film est supprimé. Un mail de confirmation à été envoyé à l'admnistrateur");
                   
        $message = \Swift_Message::newInstance()
             ->setSubject("[Gestion des films'] - Suppression")
             // Get Email adminstrator from Config.
             ->setFrom($this->getParameter('email_admnistrator'))
             // Get Email adminstrator from Config 
             ->setTo($this->getParameter('email_admnistrator'))
             ->setBody($this->renderView('form/email.text.twig', 
                       array('film' => $film)
             ));
            $this->get('mailer')->send($message);

        return $this->redirectToRoute('film_index');
    }
    
    /**
     * @return FlashMessagesService
     */
    private function flash()
    {
        return $this->get('AppBundle\Service\FlashMessagesService');
    }
}
