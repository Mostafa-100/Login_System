<?php

require("../models/UserModel.php");
require("../helpers/helpers.php");

class LoginController
{
    private $user_model;

    public function __construct()
    {
        $this->user_model = new UserModel;
    }

    public function login()
    {
        $data = [
            "email" => trim($_POST["email"]),
            "password" => trim($_POST["password"])
        ];

        if (empty($data["email"]) || empty($data["password"])) {
            flash("login", "Please fill out all inputs");
            redirect("../login.php");
        }

        if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
            if (!preg_match("/^[a-zA-Z0-9]*$/", $data["email"])) {
                flash("login", "invalid email or username");
                redirect("../login.php");
            }
        }

        if (strlen($data["password"]) < 6) {
            flash("login", "invalid password");
            redirect("../login.php");
        }

        if ($this->user_model->isUserExists($data["email"], $data["password"])) {
            session_start();

            $_SESSION["name"] = $this->user_model->getfullname($data["email"]);

            header("location: ../index.php");
            exit;
        } else {
            flash("login", "User not exist");
            redirect("../login.php");
        }
    }
}

$init = new LoginController;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $init->login();
}
