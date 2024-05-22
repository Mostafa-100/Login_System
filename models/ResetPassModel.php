<?php

require_once("Db.php");

class ResetPassModel
{

    private $connect;

    public function __construct()
    {
        $this->connect = Db::getInstance();
    }

    public function insertToken($email, $selector, $token, $expire)
    {
        $query = "INSERT INTO pwdreset VALUES(NULL, :email, :selector, :token, :expire)";
        $statement = $this->connect->prepare($query);

        $statement->bindParam(":email", $email);
        $statement->bindParam(":selector", $selector);
        $statement->bindParam(":token", $token);
        $statement->bindParam(":expire", $expire);

        if ($statement->execute()) {
            return true;
        } else {
            die("Error in insert data");
        }
    }

    public function deleteEmail($email)
    {
        $query = "DELETE FROM pwdreset WHERE pwd_reset_email = :email";
        $statement = $this->connect->prepare($query);
        $statement->bindParam(":email", $email);

        if (!$statement->execute()) {
            die("Failed to delete email");
        }
    }

    public function getToken($selector)
    {
        $query = "SELECT * FROM pwdreset WHERE pwd_reset_selector = :selector AND pwd_reset_expire > :current_date";
        $current_date = date("U");
        $statement = $this->connect->prepare($query);

        $statement->bindParam(":selector", $selector);
        $statement->bindParam(":current_date", $current_date);

        if (!$statement->execute()) {
            die("Error in get token");
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return !empty($row) ? $row : false;
    }

    public function reset_password($password, $email)
    {
        $query = "UPDATE users SET user_password = :password WHERE user_email = :email";

        $statement = $this->connect->prepare($query);

        $statement->bindParam(":password", $password);
        $statement->bindParam(":email", $email);

        if ($statement->execute()) {
            return true;
        } else {
            die("Error in reset password");
        }
    }
}
