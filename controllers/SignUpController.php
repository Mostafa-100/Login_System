<?php

require dirname(__DIR__) . "/models/UserModel.php";
require dirname(__DIR__) . "/helpers/helpers.php";

class SignUpController
{
    private $user_model;

    public function __construct()
    {
        $this->user_model = new UserModel();
    }

    public function register()
    {
        $data = [
            "fullname" => trim($_POST["full-name"]),
            "email" => trim($_POST["email"]),
            "username" => trim($_POST["username"]),
            "password" => trim($_POST["password"]),
            "re_password" => trim($_POST["re-password"])
        ];

        if (empty($data["fullname"]) || empty($data["email"]) || empty($data["username"]) || empty($data["password"]) || empty($data["re_password"])) {
            flash("register", "Please fill out all inputs");
            redirect("../signup.php");
        }

        if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
            flash("register", "Invalid email");
            redirect("../signup.php");
        }

        if (!preg_match("/^[a-zA-Z0-9]*$/", $data["username"])) {
            flash("register", "Invalid username");
            redirect("../signup.php");
        }

        if (strlen($data["password"]) < 6) {
            flash("register", "Invalid password");
            redirect("../signup.php");
        } elseif ($data["password"] != $data["re_password"]) {
            flash("register", "Passwords doesn't match");
            redirect("../signup.php");
        }

        $data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);

        $this->user_model->addUser($data["fullname"], $data["email"], $data["username"], $data["password"]);

        header("location: ../login.php");
    }
}

$init = new SignUpController;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $init->register();
}
