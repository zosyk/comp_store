<?php


class Cart
{
    public static function addProduct($id)
    {

        $id = intval($id);

        $productsInCart = array();

        if (isset($_SESSION['products'])) {
            $productsInCart = $_SESSION['products'];
        }

        if (array_key_exists($id, $productsInCart)) {
            $productsInCart[$id]++;
        } else {
            $productsInCart[$id] = 1;
        }

        $_SESSION['products'] = $productsInCart;

    }

    public static function addProductByCount($id, $count)
    {

        $id = intval($id);

        $productsInCart = array();

        if (isset($_SESSION['products'])) {
            $productsInCart = $_SESSION['products'];
        }

        if (array_key_exists($id, $productsInCart)) {
            $productsInCart[$id] += $count;
        } else {
            $productsInCart[$id] = 1;
        }

        $_SESSION['products'] = $productsInCart;

    }

    public static function getCountItems()
    {
        if (isset($_SESSION['products'])) {
            $count = 0;

            foreach ($_SESSION['products'] as $quentity) {
                $count += $quentity;
            }
            return $count;
        } else {
            return 0;
        }
    }

    public static function getProducts()
    {
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }

    public static function deleteProduct($id)
    {
        $productsInCart = self::getProducts();

        unset($productsInCart[$id]);

        self::setProducts($productsInCart);
    }

    public static function setProducts($products)
    {
        $_SESSION['products'] = $products;
    }

    public static function getTotalPrice($products)
    {
        $productsInCart = Cart::getProducts();
        $total = 0;

        if ($productsInCart) {
            foreach ($products as $product) {
                $total += $product['price'] * $productsInCart[$product['id']];
            }
        }

        return $total;
    }

    public static function clear()
    {
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
        }
    }

}