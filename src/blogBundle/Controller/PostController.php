<?php

namespace blogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use blogBundle\Entity\Post;
use blogBundle\Entity\Commentary;

class PostController extends Controller
{
  public function indexAction()
  {

    $em = $this->getDoctrine()->getEntityManager();
    $entities = $em->getRepository('blogBundle:Post')->findAll();

    // Ici, on récupérera la liste des annonces, puis on la passera au template

    // Mais pour l'instant, on ne fait qu'appeler le template
    return $this->render('blogBundle:LayoutPost:index.html.twig',array(
    	'listAdverts'=>$entities
      ));
  }

  public function viewAction($id)
  {

    $em = $this->getDoctrine()->getEntityManager();
    $entities = $em->getRepository('blogBundle:Post')->find($id);
    return $this->render('blogBundle:LayoutPost:view.html.twig', array(
      'advert' => $entities
    ));
  }



  public function confirmAction($titre,$contenu)
  {
      return $this->render('blogBundle:LayoutPost:confirm.html.twig', array(
          'titre' => $titre,
          'contenu' => $contenu
    ));
  }

public function menuAction()
  {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $em = $this->getDoctrine()->getEntityManager();
    $entities = $em->getRepository('blogBundle:User')->findAll();
    return $this->render('blogBundle:LayoutPost:menu.html.twig', array(
      // Tout l'intérêt est ici : le contrôleur passe
      // les variables nécessaires au template !
      'listAdverts' => $entities
    ));
  }


  public function addAction(Request $request)
  {


    //FORMULAIRE
    $post = new Post();
    $formBuilder = $this->get('form.factory')->createBuilder('form', $post);
    $formBuilder
      ->add('date',      'date')
      ->add('title',     'text')
      ->add('body',   'textarea')
      ->add('auteur',    'text')
      ->add('isPublished', 'checkbox')
      ->add('save',      'submit')
            //->add('category',  'checkbox')
    ;
    $form = $formBuilder->getForm();

    $form->handleRequest($request);

    if ($request->isMethod('POST')) {
      if($form->isValid()){
          //INSERTION DANS LA BASE        
          return $this->redirect($this->generateUrl('blog_post_confirm', array(
            'titre' => 'd\'ajout',
            'contenu' => 'Votre post a bien été sauvegardé.')));
      }


    }

    

    /* FILTRE ANTI SPAM
    $antispam = $this->container->get('blog.antispam');
    $text = '...';
    if ($antispam->isSpamPost($text)) {
      throw new \Exception('Votre message a été détecté comme spam !');
    }
    */


    //AFFICHAGE
    return $this->render('blogBundle:LayoutPost:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }

  public function editAction($id, Request $request)
  {
    // Ici, on récupérera l'annonce correspondante à $id

    // Même mécanisme que pour l'ajout
    if ($request->isMethod('POST')) {

      return $this->redirect($this->generateUrl('blog_post_view', array('id' => 5)));
    }

    return $this->render('blogBundle:LayoutPost:edit.html.twig');
  }

  public function deleteAction($id)
  {
    // Ici, on récupérera l'annonce correspondant à $id

    // Ici, on gérera la suppression de l'annonce en question

    return $this->render('blogBundle:LayoutPost:delete.html.twig');
  }




  public function commentAction(Request $request,$id)
  {
    //FORMULAIRE
    $comment = new Commentary();
    $formBuilder = $this->get('form.factory')->createBuilder('form', $comment);
    $formBuilder
      ->add('date',      'date')
      ->add('contenu',   'textarea')
      ->add('save',      'submit')
    ;
    $form = $formBuilder->getForm();

    $form->handleRequest($request);

    if ($request->isMethod('POST')) {
      if($form->isValid()){
          //INSERTION DANS LA BASE        
          return $this->redirect($this->generateUrl('blog_post_confirm', array(
            'titre' => 'd\'ajout de commentaire',
            'contenu' => 'Votre commentaire a bien été posté.')));
      }
    }

    //AFFICHAGE
    return $this->render('blogBundle:LayoutPost:comment.html.twig', array(
      'form' => $form->createView(),
    ));

}
}
