<?php

namespace App\Controller;

use App\Taxes\Calculator;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController {

private $logger;
private $calculator;

public function __construct(LoggerInterface $logger, Calculator $calculator)
{
  $this->logger = $logger;
  $this->calculator = $calculator;
}
  /**
   * Undocumented function
   *@Route("/hello/{firstname}", name="hello")
   */
  public function hello($firstname = "World") {

    $this->logger->error("Mon message de log !");
    $tva = $this->calculator->calcul(1800);
    dd($tva);

    
    return new Response("Hello $firstname");
  }
}