<?php
function name_validator($name) {
    $pattern = '/^[a-zA-Z ]+$/';

    if (preg_match($pattern, $name)) {
        return true;
    } else {
        return false;
    }
}
?>