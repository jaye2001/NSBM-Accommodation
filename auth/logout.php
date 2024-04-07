<?php
  include_once '../php/utils/constants.php';
  $web_constants = new Constants();

  session_start();
  if(isset($_SESSION['user_id'])){
    session_unset();
  }
  header("Location: ".$web_constants->get_link('home'));
?>