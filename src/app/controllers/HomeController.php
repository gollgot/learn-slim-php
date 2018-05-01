<?php
namespace App\controllers;



use Slim\Http\Request;
use Slim\Http\Response;

class HomeController extends Controller {

    /**
     * Display the home page
     * @param Request $request
     * @param Response $response
     */
    public function ActionIndex(Request $request, Response $response){
        $this->render($response, "home/index.twig", []);
    }

}