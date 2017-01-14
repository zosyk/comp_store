<?php


abstract class AdminBase
{

    public function isAdmin()
    {

        $userId = User::checkLogged();

        $user = User::getUserById($userId);

        if($user['role'] == 'admin')
            return true;

        die('Access denied');
    }

}