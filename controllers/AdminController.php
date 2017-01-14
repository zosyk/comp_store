<?php


class AdminController extends AdminBase
{
    public function actionIndex()
    {

        // check permissions
        self::isAdmin();

        require_once ROOT.'/views/admin/index.php';

        return true;
    }

}