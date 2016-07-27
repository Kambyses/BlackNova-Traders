<?php

include_once 'config.default.php';

if ($_SERVER['HTTP_HOST'] === 'localhost') {
  include_once 'config.localhost.php';
}
