<?php

require_once __DIR__ . "/Db.php";

class UserModel
{
    private $connect;

    public function __construct()
    {
        $this->connect = Db::getInstance();
    }

    public function isEmailTaken($email)
    {
        $query = "SELECT * FROM users WHERE user_email = :email";
        $statement = $this->connect->prepare($query);
        $statement->bindParam(":email", $email);
        $statement->execute();

        $result = $statement->fetchAll();

        return !empty($result);
    }

    public function isUsernameTaken($username)
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $statement = $this->connect->prepare($query);
        $statement->bindParam(":username", $username);
        $statement->execute();

        $result = $statement->fetchAll();

        return !empty($result);
    }

    public function AddUser($fullname, $email, $username, $password)
    {
        $query = "INSERT INTO `users` VALUES(NULL, :fullname, :email, :username, :password)";
        $statement = $this->connect->prepare($query);

        $statement->bindParam("fullname", $fullname);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":username", $username);
        $statement->bindParam(":password", $password);

        $statement->execute();
    }

    public function isUserExists($email, $password)
    {
        $query = "SELECT * FROM `users` WHERE user_email = :email OR username = :email";
        $statement = $this->connect->prepare($query);

        $statement->bindParam(":email", $email);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $result["user_password"])) {
            return true;
        } else {
            return false;
        }
    }

    public function getfullname($email)
    {
        $query = "SELECT * FROM `users` WHERE user_email = :email OR username = :email";
        $statement = $this->connect->prepare($query);

        $statement->bindParam(":email", $email);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result["full_name"];
    }
}
