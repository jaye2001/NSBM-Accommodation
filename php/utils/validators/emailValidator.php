<?php
function email_validator($email){
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return false;
  }
  list($username, $domain) = explode('@', $email);

  if (!checkdnsrr($domain, 'MX')) {
      return false;
  }
  return true;
}
?>