<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HelloController {

  /**
   * Undocumented function
   *@Route("/hello/{firstname?World}", name="hello")
   */
  public function hello($firstname = "World", Environment $twig) {
    
    $html = $twig->render("hello.html.twig", [
      "prenom" => $firstname,
      "age" => 33,
      "prenoms" => [
        "Kévina",
        "Anais",
        "Brigitte",
        "Amélie",
        "Cédric"
      ]
    ]);
    
    return new Response($html);
  }
}