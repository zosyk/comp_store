<?php


class CartController
{

    public function actionAdd($id)
    {
        Cart::addProduct($id);

        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }

    public function actionAddAjax($id)
    {
        Cart::addProduct($id);
        echo '(' . Cart::getCountItems() . ')';

        return true;
    }

    public function actionIndex()
    {

        $categories = Category::getCategoriesList();

        $productsInCart = false;

        $productsInCart = Cart::getProducts();

        if ($productsInCart) {
            $productsIds = array_keys($productsInCart);
            $products = Product::getProductsByIds($productsIds);

            $totalPrice = Cart::getTotalPrice($products);
        }

        require_once ROOT . '/views/cart/index.php';

        return true;
    }

    public function actionCheckout()
    {

        $categories = Category::getCategoriesList();

        $result = false;

        $totalPrice = '';
        $userName = '';
        $userPhone = '';
        $userComment = '';
        $productsInCards = Cart::getProducts();

        if (isset($_POST['submit'])) {
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];

            // fields validation
            $errors = false;

            if (!User::checkName(trim($userName)))
                $errors[] = 'Invalid name';
            if (!User::checkPhone(trim($userPhone)))
                $errors[] = 'Invalid phone';

            if ($errors == false) {
                // here we now that form filled correctly


                if (User::isGuest()) {
                    $userId = false;
                } else {
                    $userId = User::checkLogged();
                }

                //save order in db

                $result = Order::save($userName, $userPhone, $userComment, $userId, $productsInCards);

                if ($result) {

                    //send order to administrator email
                    $adminEmail = 'alekcandrzosyk@gmail.com';
                    $message = 'your.site.com/admin/orders';
                    $subject = 'New order';
                    mail($adminEmail, $subject, $message);

                    Cart::clear();
                }

            } else {
                //form has some errors

                $productsIds = array_keys($productsInCards);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::getCountItems();
            }

        } else {

            //did form send? no

            if (!$productsInCards) {

                header("Location: /");
            } else {

                if (!User::isGuest()) {
                    $userId = User::checkLogged();
                    $user = User::getUserById($userId);

                    $userName = $user['name'];
                }

                $productsIds = array_keys($productsInCards);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::getCountItems();
            }
        }


        require_once ROOT . '/views/cart/checkout.php';

        return true;
    }

    public function actionDelete($id)
    {
        $products = Cart::getProducts();

        if ($products) {

            foreach ($products as $key => $value) {
                if ($key == $id) {
                    unset($products[$key]);
                    break;
                }
            }

            Cart::setProducts($products);
        }
        header("Location : /cart/");
    }
}