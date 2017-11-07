<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @Route("/buzz", name="buzztest")
     */
    public function buzzAction()
    {
        $browser = $this->container->get('buzz');
        
        $json = json_encode([
            "name" => "BuzzTest",
            "role" => "0"
        ]);
        
        $headers = ['Content-Type', 'application/json'];
        
        $browser->post('http://192.168.33.11/users/add', $headers, $json);
        
        return $this->render('default/home.html.twig');
    }
}
