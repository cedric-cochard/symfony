<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController {
  /**
   * Undocumented function
   *@Route("/hello/{firstname}", name="hello")
   */
  public function hello($firstname = "World") {
    return new Response("Hello $firstname");
  }
}