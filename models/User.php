<?php


class User
{

    public static function register($name, $email, $password)
    {

        $db = Db::getConnection();

        $sql = 'INSERT INTO user (name, email, password) '
            . 'VALUES (:name, :email, :password)';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function checkName($name)
    {
        return strlen($name) >= 2;
    }

    public static function checkPhone($userPhone)
    {
        return strlen($userPhone) >=9;
    }

    public static function checkEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function checkPassword($password)
    {
        return strlen($password) >= 6;
    }

    public static function checkEmailExists($email)
    {
        $db = Db::getConnection();

        $result = $db->prepare("SELECT count(id) FROM user WHERE email = :email");
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        return $result->fetchColumn();
    }

    public static function checkUserData($email, $password)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM user WHERE email = :email AND password = :password';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch();

        if ($user) {
            return $user['id'];
        }

        return false;
    }

    public static function auth($userId)
    {
        $_SESSION['user'] = $userId;
    }

    public static function checkLogged()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /user/login");
    }

    public static function getUserById($userId)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM user WHERE id = :id ';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $userId, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetch();

    }


    public static function isGuest() {

        return !isset($_SESSION['user']);
    }

    public static function edit($userId, $name, $password)
    {
        $db = Db::getConnection();

        $sql = 'UPDATE user SET name = :name, password = :password '
            . 'WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $userId, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        return $result->execute();

    }
}