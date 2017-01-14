<?php


class AdminOrderController extends AdminBase
{

    public function actionIndex()
    {
        self::isAdmin();

        $ordersList = Order::getOrdersList();

        require_once ROOT . '/views/admin_order/index.php';

        return true;
    }

    public function actionView($id)
    {
        self::isAdmin();

        $order = Order::getOrderById($id);

        // Получаем массив с идентификаторами и количеством товаров
        $productsQuantity = json_decode($order['products'], true);

        // Получаем массив с индентификаторами товаров
        $productsIds = array_keys($productsQuantity);

        // Получаем список товаров в заказе
        $products = Product::getProductsByIds($productsIds);

        require_once ROOT . '/views/admin_order/view.php';

        return true;

    }

    public function actionUpdate($id)
    {
        self::isAdmin();

        $order = Order::getOrderById($id);

        if (isset($_POST['submit'])) {

            $order['user_name'] = $_POST['userName'];
            $order['user_phone'] = $_POST['userPhone'];
            $order['user_comment'] = $_POST['userComment'];
            $order['status'] = $_POST['status'];

            $errors = false;

            if (!User::checkName($order['user_name'])) {
                $errors[] = 'Invalid name';
            }

            if (!$errors) {

                Order::updateOrder($order);

                header("Location: /admin/order");
            }
        }

        require_once ROOT . '/views/admin_order/update.php';

        return true;

    }

    public function actionDelete($id)
    {
        self::isAdmin();

        if (isset($_POST['submit'])) {

            Order::deleteOrderById($id);

            header("Location: /admin/order");
        }

        require_once ROOT . '/views/admin_order/delete.php';

        return true;
    }

}