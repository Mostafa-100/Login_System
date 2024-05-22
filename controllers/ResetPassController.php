<?php

require("../models/ResetPassModel.php");
require("../helpers/helpers.php");
require("../models/UserModel.php");

require("../PHPMailer/src/PHPMailer.php");
require("../PHPMailer/src/Exception.php");
require("../PHPMailer/src/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;

class ResetPassController
{
    private $reset_model;
    private $user_model;
    private $mail;

    public function __construct()
    {
        $this->reset_model = new ResetPassModel;
        $this->user_model = new UserModel;
        $this->mail = $this->setupMailer();
    }

    private function setupMailer()
    {
        $this->mail = new PHPMailer();
        $this->mail->isSMTP();
        $this->mail->Host = 'sandbox.smtp.mailtrap.io';
        $this->mail->SMTPAuth = true;
        $this->mail->Port = 2525;
        $this->mail->Username = '1ad2ff42c0cf2c';
        $this->mail->Password = '99201ba19ab513';

        return $this->mail;
    }

    private function validateEmail($email)
    {
        $email = trim($email);

        if (empty($email)) {
            flash("reset", "Please insert your email");
            redirect("../reset.php");
        }

        if (filter_var(INPUT_POST, FILTER_VALIDATE_EMAIL)) {
            flash("reset", "Invalid email");
            redirect("../reset.php");
        }

        if (!$this->user_model->isEmailTaken($email)) {
            flash("reset", "Email not exist");
            redirect("../reset.php");
        }

        return $email;
    }

    private function generateSelectorAndToken()
    {
        $selector = bin2hex(random_bytes(9));
        $token = random_bytes(32);

        return ["selector" => $selector, "token" => $token];
    }

    private function generateURL($selector, $token)
    {
        $url = "http://127.0.0.1/Login_System/create_new_password.php?selector=$selector&token=" . bin2hex($token);

        return $url;
    }

    private function saveToken()
    {
        $urlData = $this->generateSelectorAndToken();

        $selector = $urlData["selector"];
        $token = $urlData["token"];
        $email = $this->validateEmail($_POST["email"]);
        $expire = date("U") + 1800;

        $hashToken = password_hash($token, PASSWORD_BCRYPT);

        $this->reset_model->deleteEmail($email);

        $this->reset_model->insertToken($email, $selector, $hashToken, $expire);

        return [
            "selector" => $selector,
            "token" => $token,
            "email" => $email,
        ];
    }

    public function sendEmail()
    {
        $data = $this->saveToken();
        $subject = "Reset your password";
        $url = $this->generateURL($data["selector"], $data["token"]);

        $message = <<<"HTML"
            <p>We recieved a password reset request.</p>
            <p>Here is your password reset link: </p>
            <a href="$url">$url</a>
        HTML;

        $this->mail->setFrom("no-reply@example.com");
        $this->mail->isHTML(true);
        $this->mail->Subject = $subject;
        $this->mail->Body = $message;
        $this->mail->addAddress($data["email"]);

        $this->mail->send();

        flash("reset", "Check your email", "alert alert-success");
        redirect("../reset.php");
    }
}

$init = new ResetPassController;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $init->sendEmail();
}
