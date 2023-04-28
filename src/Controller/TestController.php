<?php 

namespace App\Controller;

use App\Taxes\Calculator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class TestController {

  protected $calculator;

  public function __construct(Calculator $calculator)
  {
    $this->calculator = $calculator;
  }
  /**
   *@Route("/", name="index")
   *
   */
  public function index(Environment $twig) {
    dump($twig);
    $tva = $this->calculator->calcul(200);
    dump($tva);
    dd("ca fonctionne !");
  }
  /**
   * @Route("/test/{age<\d+>?0}", name="test", methods={"GET", "POST"})
   *
   */
  public function test(Request $request, $age) {
    // $request = Request::createFromGlobals();
    // $age = $request->attributes->get("age");
    return new Response("Vous avez $age ans !");
  }
}

