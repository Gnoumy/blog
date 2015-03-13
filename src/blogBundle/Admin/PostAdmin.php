<?php
namespace blogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\HttpFoundation\Session\Session;
use blogBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostAdmin extends Admin
{
    protected $baseRouteName = 'blog'; 
    protected $baseRoutePattern = 'blog';

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        // $val= new User();
        // $get = $val->getIdByName();
        // $user = $this->container->get('security.context')->getToken()->getUser();
        
        //var_dump($user = $this->getUser()->getId());

        //$machin = getUserId($_SESSION['_sf2_attributes']['_security.last_username']);
        //$session = $this->container->get('session');
        dump($this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser());


        //var_dump($this->get("security.context"));
        //die();

        $formMapper
            ->add('title', 'text', array('label' => 'Post Title'))
            //->add('auteur', 'entity', array('class' => 'blogBundle\Entity\User'))
            ->add('auteur', 'text', array('label' => 'Author name'))
            //->add('body') //if no type is specified, SonataAdminBundle tries to guess it
            ->add('body', 'textarea', array('attr' => array('class' => 'tinymce', 'tinymce'=>'{"theme":"advanced"}')))
            ->add('isPublished', 'choice', array(
                'choices' => array('1' => 'Yes', '0' => 'No')
            ))
            ->add('date', 'date')
            //->add('user')
            ->add('category');
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            //->add('author')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            //->add('slug')
            //->add('author')
        ;
    }

    public function prePersist($post)
    {
        $post->setUser($this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser());
    }
}