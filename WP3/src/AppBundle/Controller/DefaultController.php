<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        /*return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);*/
        return $this->render('default/home.html.twig');
    }
    
    /**
     * @Route("/form", name="form")
     */
    public function formAction(Request $request)
    {
        $data = array();
        
        $form = $this->createFormBuilder($data)
            ->setAction('/technicians/add/go')
            ->add('username', TextType::class, array('required' => 'true', 'name' => 'username'))
            ->add('add', SubmitType::class, array('label' => 'ADD'))
            ->getForm();
        
        return $this->render('default/form.html.twig', array("form" => $form->createView()));
    }
}
