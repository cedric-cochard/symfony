<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class HelloController extends AbstractController {

  /**
   *@Route("/hello/{firstname?World}", name="hello")
   */
  public function hello($firstname = "World") {
    
    return $this->render("hello.html.twig", [
      "prenom" => $firstname
    ]);
  }
  /**
  
   *@route("/example", name="example")
   */
  public function exemple() {

    return $this->render("example.html.twig", [
      "age" => 33
    ]);
  }
}