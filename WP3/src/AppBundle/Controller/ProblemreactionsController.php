<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProblemreactionsController extends Controller
{
    /**
    *  @Route("/problemreactions")
    */
    public function locationsAction() {
        $stuff = json_decode(file_get_contents("http://192.168.33.11/problemreactions"));
        return $this->render('AppBundle:Problemreactions:problemreactions.html.twig', array("problemreactions" => $stuff));
    }
}
