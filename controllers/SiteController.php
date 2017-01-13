<?php

class SiteController
{

    public function actionIndex()
    {

        $latestProducts = array();
        $latestProducts = Product::getLatestProducts();

        $categories = array();
        $categories = Category::getCategoriesList();

        $recommendedProducts = array();
        $recommendedProducts = Product::getRecommendedProducts();

        require_once ROOT . '/views/site/index.php';

        return true;
    }

    public function actionContact()
    {
        $userEmail = '';
        $userText = '';
        $result = false;

        if (isset($_POST['submit'])) {

            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];

            $errors = false;

            if(!User::checkEmail($userEmail))
                $errors[] = 'Invalid email';

            if($errors == false) {

                $adminEmail = 'alekcandrzosyk@gmail.com';
                $message = "Text: $userText. From: $userEmail";
                $subject = "Later subject";
                $result = mail($adminEmail, $subject, $message);

                $result = true; //for localhost
            }
        }


        require_once ROOT . '/views/site/contact.php';

        return true;
    }

}