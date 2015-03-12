<?php

namespace blogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use blogBundle\Entity\Post;
class PostController extends Controller
{
  public function indexAction()
  {

    $listAdverts = array(
      array(
        'title'   => 'Recherche développpeur Symfony2',
        'id'      => 1,
        'author'  => 'Alexandre',
        'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
        'date'    => new \Datetime(),
        'category'=> 'Divers'),

      array(
        'title'   => 'Mission de webmaster',
        'id'      => 2,
        'author'  => 'Hugo',
        'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
        'date'    => new \Datetime(),
        'category'=> 'Enfants'),

      array(
        'title'   => 'Offre de stage webdesigner',
        'id'      => 3,
        'author'  => 'Mathieu',
        'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
        'date'    => new \Datetime(),
        'category'=> 'Religion')

    );


    // Ici, on récupérera la liste des annonces, puis on la passera au template

    // Mais pour l'instant, on ne fait qu'appeler le template
    return $this->render('blogBundle:LayoutPost:index.html.twig',array(
    	'listAdverts'=>$listAdverts
      ));
  }

  public function viewAction($id)
  {
    // ON RECUPERE LES INFOS DE LA BASE
    $advert = array(
      'title'   => 'Recherche développpeur Symfony2',
      'id'      => $id,
      'author'  => 'Alexandre',
      'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
      'date'    => new \Datetime()
    );

    return $this->render('blogBundle:LayoutPost:view.html.twig', array(
      'advert' => $advert
    ));
  }



public function menuAction()
  {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $listAdverts = array(
      array('id' => 2, 'title' => 'Men in black'),
      array('id' => 5, 'title' => 'AC/DC'),
      array('id' => 9, 'title' => 'Bamba triste')
    );

    return $this->render('blogBundle:LayoutPost:menu.html.twig', array(
      // Tout l'intérêt est ici : le contrôleur passe
      // les variables nécessaires au template !
      'listAdverts' => $listAdverts
    ));
  }


  public function addAction(Request $request)
  {
    // La gestion d'un formulaire est particulière, mais l'idée est la suivante :

    // Si la requête est en POST, c'est que le visiteur a soumis le formulaire
    if ($request->isMethod('POST')) {
      // Ici, on s'occupera de la création et de la gestion du formulaire

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

      // Puis on redirige vers la page de visualisation de cettte annonce
      return $this->redirect($this->generateUrl('blog_post_view', array('id' => 5)));
    }
   // On récupère le service
    $antispam = $this->container->get('blog.antispam');

    /* Je pars du principe que $text contient le texte d'un message quelconque
    $text = '...';
    if ($antispam->isSpamPost($text)) {
      throw new \Exception('Votre message a été détecté comme spam !');
    }
    */

    // Si on n'est pas en POST, alors on affiche le formulaire
    // On crée un objet Post
    $post = new Post();
    // On crée le FormBuilder grâce au service form factory
    $formBuilder = $this->get('form.factory')->createBuilder('form', $post);

    // On ajoute les champs de l'entité que l'on veut à notre formulaire
    $formBuilder
      ->add('date',      'date')
      ->add('title',     'text')
      ->add('body',   'textarea')
      ->add('auteur',    'text')
      ->add('isPublished', 'checkbox')
      ->add('save',      'submit')
            //->add('category',  'checkbox')
    ;
    // Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard

    // À partir du formBuilder, on génère le formulaire
    $form = $formBuilder->getForm();

    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('blogBundle:LayoutPost:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }

  public function editAction($id, Request $request)
  {
    // Ici, on récupérera l'annonce correspondante à $id

    // Même mécanisme que pour l'ajout
    if ($request->isMethod('POST')) {
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

      return $this->redirect($this->generateUrl('blog_view', array('id' => 5)));
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
    // La gestion d'un formulaire est particulière, mais l'idée est la suivante :

    // Si la requête est en POST, c'est que le visiteur a soumis le formulaire
    if ($request->isMethod('POST')) {
      // Ici, on s'occupera de la création et de la gestion du formulaire

      $request->getSession()->getFlashBag()->add('notice', 'Commentaire bien enregistrée.');

      // Puis on redirige vers la page de visualisation de cettte annonce
      return $this->redirect($this->generateUrl('blog_view', array('id' => 5)));
    }

    // Si on n'est pas en POST, alors on affiche le formulaire
    return $this->render('blogBundle:LayoutPost:comment.html.twig', array(
      'id' => $id));
  }

}
