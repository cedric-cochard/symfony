<?php

namespace App\Controller;

use App\Taxes\Calculator;
use Cocur\Slugify\Slugify;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HelloController {

private $logger;
private $calculator;
private $twig;

public function __construct(LoggerInterface $logger, Calculator $calculator, Environment $twig)
{
  $this->logger = $logger;
  $this->calculator = $calculator;
  $this->twig = $twig;
  
}
  /**
   * Undocumented function
   *@Route("/hello/{firstname}", name="hello")
   */
  public function hello($firstname = "World" ) {
    dump($this->twig);
    $slugify = new Slugify();
    dump($slugify->slugify("Hello World"));
    $this->logger->error("Mon message de log !");
    $tva = $this->calculator->calcul(1800);
    dd($tva);

    
    return new Response("Hello $firstname");
  }
}