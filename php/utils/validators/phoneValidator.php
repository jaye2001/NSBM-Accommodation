<?php
function phone_number_validator($phone_number){
  $phone_number = preg_replace('/[^0-9]/', '', $phone_number);

  if (strlen($phone_number) != 10) {
      return false;
  }
  if (substr($phone_number, 0, 2) !== '07') {
      return false;
  }
  return true;
}
?>