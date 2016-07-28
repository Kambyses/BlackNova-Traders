<?php

namespace BNT\controller;

class Login
{

  public function __construct ()
  {
    global $player, $db, $l, $default_lang, $title, $body_class, $lang, $link;

    if (isset($_POST['email']) && isset($_POST['pass'])) {
      if ($player->login($_POST['email'], $_POST['pass'])) {
        header('location: ' . $_SERVER['REQUEST_URI']);
        exit;
      }
    }

    $index_page = true;

    if (!empty($_GET['lang'])) {
      $lang = $_GET['lang'];
      $link = "?lang=" . $lang;
    } else {
      $_GET['lang'] = null;
      $lang = $default_lang;
      $link = '';
    }

    $result = $db->Execute("SELECT name, value FROM {$db->prefix}languages WHERE category=? AND language=?;", array('common', $lang));
    if (!$result) {
      header("Location: create_universe.php");
      exit;
    }

    $title = $l->get('l_welcome_bnt');
    $body_class = 'index';

    include_once __TEMPLATES__ . 'login.php';
  }

}
