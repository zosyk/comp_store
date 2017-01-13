<?php

include_once ROOT.'/models/Category.php';
include_once ROOT.'/models/Product.php';

class ProductController
{

    public function actionView($productId)
    {

        $categories = array();
        $categories = Category::getCategoriesList();

        $product = Product::getProductById($productId);

        require_once ROOT.'/views/product/view.php';

        return true;
    }

    public function actionAddAjax() {


        if(isset($_POST['id'])) {
            $id = $_POST['id'];
            $count = $_POST['count'];

            Cart::addProductByCount($id, $count);
            echo '(' . Cart::getCountItems() . ')';
        }

        return true;
    }


}