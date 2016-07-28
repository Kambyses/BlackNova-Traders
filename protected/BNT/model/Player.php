<?php

namespace BNT\model;

class Player
{

  private $isLogged = false;
  public  $ship_id  = 0;
  private $email    = '';
  private $language = 'english';

  public function __construct ()
  {
    $this->checkLogin();
  }

  public function checkLogin ()
  {
    if ($this->isLogged) {
      return true;
    }
    if (!$session = $this->getSession()) {
      return false;
    }
    $this->isLogged = true;
    $this->ship_id  = $session['ship_id'];
    $this->email    = $session['email'];
    $this->language = $session['language'];
    return true;
  }

  public function login ($username = "", $password = "")
  {
    global $db, $db_logging;

    if (!$this->validateUsername($username)) {
      return false;
    }
    if (!$this->validatePassword($password)) {
      return false;
    }
    $res = $db->Execute(
      "SELECT `ship_id`, `email`, `password`, `lang` FROM {$db->prefix}ships WHERE email = ? AND password = ? LIMIT 1",
      array( $username, $this->passwordHash($password) )
    );
    db_op_result ($db, $res, __LINE__, __FILE__, $db_logging);
    if (!$res) {
      return false;
    }
    $this->setSession($res->fields);
    return true;
  }

  public function logout ()
  {
    $this->isLogged = false;
    $this->ship_id  = 0;
    $this->email    = '';
    $this->unsetSession();
  }

  private function getSession ()
  {
    return !empty($_SESSION['bnt']) ? $_SESSION['bnt'] : null;
  }

  public function setSession ($playerinfo)
  {
    global $gamepath, $gamedomain;

    $_SESSION['bnt']['ship_id']  = (int)$playerinfo['ship_id'];
    $_SESSION['bnt']['email']    = $playerinfo['email'];
    $_SESSION['bnt']['language'] = $playerinfo['lang'];

    $userpass = $playerinfo['email'] . '+' . $playerinfo['password'];
    setcookie("userpass", $userpass, time() + (3600 * 24) * 365, $gamepath, $gamedomain);
  }

  public function unsetSession ()
  {
    global $gamepath, $gamedomain;

    $_SESSION['bnt'] = null;
    unset($_SESSION['bnt']);

    setcookie ("userpass", "", 0, $gamepath, $gamedomain);
    setcookie ("userpass", "", 0);
    $_SESSION['logged_in'] = false;
    $_SESSION = array();
    setcookie("PHPSESSID", "", 0, "/");
    session_destroy();
  }

  public function validateUsername ($username)
  {
    if (is_string($username) && strlen($username) > 5 && strlen($username) < 100) {
      return true;
    }
    return false;
  }

  public function validatePassword ($password)
  {
    if (is_string($password) && strlen($password) > 5 && strlen($password) < 100) {
      return true;
    }
    return false;
  }

  public static function passwordHash ($password = "")
  {
    global $crypt_salt;
    return crypt($password, $crypt_salt);
  }

}
