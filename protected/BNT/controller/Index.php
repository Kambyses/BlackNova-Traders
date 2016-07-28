<?php

namespace BNT\controller;

class Index
{

  public function __construct ()
  {
    header('location: main.php');
    exit;
  }

}
