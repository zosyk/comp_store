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

    /**
     * Возвращает путь к изображению
     * @param integer $id
     * @return string <p>Путь к изображению</p>
     */
    public static function getImage($id)
    {
        // Название изображения-пустышки
        $noImage = 'no-image.jpg';

        // Путь к папке с товарами
        $path = '/upload/images/products/';

        // Путь к изображению товара
        $pathToProductImage = $path . $id . '.jpg';

        if (file_exists($_SERVER['DOCUMENT_ROOT'].$pathToProductImage)) {
            // Если изображение для товара существует
            // Возвращаем путь изображения товара
            return $pathToProductImage;
        }

        // Возвращаем путь изображения-пустышки
        return $path . $noImage;
    }

    public static function getRecommendedProducts()
    {
        $products = array();

        $db = Db::getConnection();


        $sql = "SELECT id, code, name, price, is_new FROM product WHERE status='1' AND is_recommended = '1'";

        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $products[$i]['is_new'] = $row['is_new'];

            $i++;
        }

        return $products;
    }

    public static function getProductsList()
    {
        $db = Db::getConnection();

        $productList = array();

        $result = $db->query("SELECT id, name, price, is_new, code FROM product "
            . "ORDER BY id DESC "
        );
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        while ($row = $result->fetch()) {
            $productList[$i]['id'] = $row['id'];
            $productList[$i]['name'] = $row['name'];
            $productList[$i]['price'] = $row['price'];
            $productList[$i]['is_new'] = $row['is_new'];
            $productList[$i]['code'] = $row['code'];

            $i++;
        }

        return $productList;
    }

    public static function deleteProductById($id)
    {
        $db = Db::getConnection();

        $sql = 'DELETE FROM product WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        return $result->execute();

    }

    public static function createProduct($options)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO product(name, code, price, category_id, brand,'
            . ' availability, description, is_new, is_recommended, status) VALUES('
            . ':name, :code, :price, :category_id, :brand, :availability, :description,'
            . ':is_new, :is_recommended, :status)';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_INT);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);

        if ($result->execute()) {
            // Если запрос выполенен успешно, возвращаем id добавленной записи
            return $db->lastInsertId();
        }
        // Иначе возвращаем 0
        return 0;
    }

    public static function updateProductById($options, $id)
    {
        $db = Db::getConnection();

        $sql = "UPDATE product SET name = :name, code = :code, price = :price,"
            ." category_id = :category_id, brand = :brand, availability = :availability,"
            ." description = :description, is_new = :is_new, is_recommended = :is_recommended,"
            ." status = :status WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_INT);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);

        return $result->execute();
    }

}