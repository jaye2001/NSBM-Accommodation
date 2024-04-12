<?php

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit(404);
if (!isset($_GET['id'])) exit(404);
if (!isset($_SESSION['user_id'])) {
  header('Location: '.$web_constants->get_link('login'));
  exit(404);
}

include_once 'php/utils/db.php';
include_once 'php/utils/constants.php';



?>