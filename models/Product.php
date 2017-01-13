<?php


class Product
{
    const SHOW_BY_DEFAULT = 5;

    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT)
    {
        $count = intval($count);

        $db = Db::getConnection();

        $productList = array();

        $result = $db->query('SELECT id, name, price, is_new FROM product '
            . 'WHERE status = "1" '
            . 'ORDER BY id DESC '
            . 'LIMIT ' . $count . ';');

        $i = 0;
        while ($row = $result->fetch()) {
            $productList[$i]['id'] = $row['id'];
            $productList[$i]['name'] = $row['name'];
            $productList[$i]['price'] = $row['price'];
            $productList[$i]['is_new'] = $row['is_new'];

            $i++;
        }

        return $productList;
    }

    public static function getProductsListByCategory($categoryId, $page)
    {
        $db = Db::getConnection();

        $productList = array();

        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        $result = $db->query("SELECT id, name, price, is_new FROM product "
            . "WHERE status = '1' "
            . "AND category_id = $categoryId "
            . "ORDER BY id DESC "
            . "LIMIT " . self::SHOW_BY_DEFAULT
            . " OFFSET $offset"
        );

        $i = 0;
        while ($row = $result->fetch()) {
            $productList[$i]['id'] = $row['id'];
            $productList[$i]['name'] = $row['name'];
            $productList[$i]['price'] = $row['price'];
            $productList[$i]['is_new'] = $row['is_new'];

            $i++;
        }

        return $productList;
    }

    public static function getProductById($productId)
    {
        $db = Db::getConnection();

        $result = $db->query("SELECT * FROM product WHERE id = $productId");
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetch();
    }

    public static function getTotalProductsInCategory($categoryId)
    {
        $db = Db::getConnection();

        $result = $db->query("SELECT COUNT(id) AS count FROM product WHERE status = '1' AND category_id = $categoryId");
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $row = $result->fetch();

        return $row['count'];
    }

    public static function getProductsByIds($productsIds)
    {
        $products = array();

        $db = Db::getConnection();

        $idsString = implode(',', $productsIds);

        $sql = "SELECT id, code, name, price FROM product WHERE status='1' AND id IN ($idsString)";

        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];

            $i++;
        }

        return $products;
    }

    public static function getRecommendedProducts()
    {
        $products = array();

        $db = Db::getConnection();


        $sql = "SELECT id, code, name, price FROM product WHERE status='1' AND is_recommended = '1'";

        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];

            $i++;
        }

        return $products;
    }

}