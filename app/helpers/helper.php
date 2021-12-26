<?php
if (!isset($_SESSION)) {
    session_start();
}

function showError($name = "", $msg = "", $class = "form-message, bg-danger text-white p-4 justify-content-center")
{
    if (!empty($name)) {
        if (!empty($msg) && empty($_SESSION[$name])) {
            $_SESSION[$name] = $msg;
            $_SESSION[$name . "_class"] = $class;
        } else if (empty($msg) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . "_class"]) ?  $_SESSION[$name . "_class"]  : $class;
            echo "<div class ='>". $class ."'>" . $_SESSION[$name]. "</div>";
            unset($_SESSION[$name]);
            unset($_SESSION[$name . "_class"]);
        }
    }
}
function showPicturesOnHome($name,$data)
{
    foreach ($data as $pic) {
        print_r($pic);
    }

}
