<?php

namespace App\Taxes;

class Detector {

  protected $limit;
  public function __construct($limit) {
    $this->limit = $limit;
  }

  public function dectect(float $amount) : bool {
    if($amount < $this->limit) {
      return false;
    } else {
      return true;
    }
  }
}