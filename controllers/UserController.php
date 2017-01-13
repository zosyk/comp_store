<?php


class UserController
{

    public function actionLogin()
    {
        $email = '';
        $password = '';

        if (isset($_POST['submit'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!User::checkPassword($password))
                $errors[] = "Your password must be more than 6 digits";

            if (!User::checkEmail($email))
                $errors[] = "Invalid email, check it and try again";

            $userId = User::checkUserData($email, $password);

            if ($userId == false) {
                $errors[] = 'Invalid credentials';
            } else {
                User::auth($userId);

                //Redirect user to the hidden part of the cabinet
                header("Location: /cabinet/");
            }
        }

        require_once(ROOT . '/views/user/login.php');

        return true;

    }

    public function actionLogout() {
        unset($_SESSION['user']);

        header("Location: /");
    }

    public function actionRegister()
    {

        $name = '';
        $email = '';
        $password = '';
        $errors = array();
        $result = false;

        if (isset($_POST['submit'])) {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!User::checkName($name))
                $errors[] = 'Your name must be more than 2 digits';

            if (!User::checkPassword($password))
                $errors[] = "Your password must be more than 6 digits";

            if (!User::checkEmail($email))
                $errors[] = "Invalid email, check it and try again";

            if (User::checkEmailExists($email))
                $errors[] = 'This email is already used';

            if ($errors == false) {
                $result = User::register($name, $email, $password);
                echo 'result : ' . $result;
            }
        }


        require_once(ROOT . '/views/user/register.php');

        return true;
    }

}