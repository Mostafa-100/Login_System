<?php

require_once("../models/ResetPassModel.php");
require_once("../helpers/helpers.php");

class CreateNewPassController
{

    private $reset_model;

    public function __construct()
    {
        $this->reset_model = new ResetPassModel;
    }

    public function resetPassword()
    {
        $selector = $_POST["selector"];
        $token = $_POST["token"];
        $url = "http://127.0.0.1/Login_System/create_new_password.php?selector=$selector&token=$token";

        if ($this->isTokenExist($selector, $token)) {
            $password = trim($_POST["password"]);
            $re_password = trim($_POST["re_password"]);
            $email = $this->reset_model->getToken($selector)["pwd_reset_email"];

            if (empty($password) || empty($re_password)) {
                flash("reset", "Please fill out the inputs");
                redirect($url);
            }

            if (strlen($password) < 6) {
                flash("reset", "Invalid password");
                redirect($url);
            }

            if ($password != $re_password) {
                flash("reset", "Passwords doesnt match");
                redirect($url);
            }

            $hash_password = password_hash($password, PASSWORD_BCRYPT);

            $this->reset_model->reset_password($hash_password, $email);

            flash("login", "Your password is reseted", "alert alert-success");
            redirect("../login.php");
        } else {
            flash("reset", "This token is invalid");
            redirect("../reset.php");
        }
    }

    private function isTokenExist($selector, $token)
    {
        $row = $this->reset_model->getToken($selector);

        if (!empty($row)) {
            $existToken = $row["pwd_reset_token"];
            $userToken = hex2bin($token);

            if (password_verify($userToken, $existToken)) {
                return true;
            } else {
                return false;
            }

            return false;
        }
    }
}

$init = new CreateNewPassController;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $init->resetPassword();
}
