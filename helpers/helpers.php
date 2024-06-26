<?php
if (!isset($_SESSION)) {
    session_start();
}

function flash($name, $message = '', $class = 'alert alert-danger')
{
    if (!empty($message)) {
        $_SESSION[$name] = $message;
        $_SESSION[$name . '_class'] = $class;
    } else if (!empty($_SESSION[$name])) {
        $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : $class;
        echo '<div class="' . $class . '" >' . $_SESSION[$name] . '</div>';
        unset($_SESSION[$name]);
        unset($_SESSION[$name . '_class']);
    }
}

function redirect($location)
{
    header("location: $location");
    exit;
}
