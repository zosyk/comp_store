<?php


class AdminCategoryController extends AdminBase
{

    public function actionIndex()
    {
        self::isAdmin();

        $categoriesList = Category::getCategoriesListAdmin();

        require_once ROOT . '/views/admin_category/index.php';

        return true;

    }

    public function actionDelete($id)
    {
        self::isAdmin();

        if (isset($_POST['submit'])) {

            Category::deleteCategoryById($id);

            header("Location: /admin/category");
        }

        require_once ROOT . '/views/admin_category/delete.php';

        return true;

    }

    public function actionCreate()
    {
        self::isAdmin();

    // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Получаем данные из формы
            $name = $_POST['name'];
            $sortOrder = $_POST['sort_order'];
            $status = $_POST['status'];

            // Флаг ошибок в форме
            $errors = false;

            // При необходимости можно валидировать значения нужным образом
            if (!isset($name) || empty($name)) {
                $errors[] = 'Заполните поля';
            }


            if ($errors == false) {
                // Если ошибок нет
                // Добавляем новую категорию
                Category::createCategory($name, $sortOrder, $status);

                // Перенаправляем пользователя на страницу управлениями категориями
                header("Location: /admin/category");
            }

        }

        require_once ROOT . '/views/admin_category/create.php';

        return true;

    }

    public function actionUpdate($id)
    {
        self::isAdmin();

        $category = Category::getCategoryById($id);

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Получаем данные из формы
            $name = $_POST['name'];
            $sortOrder = $_POST['sort_order'];
            $status = $_POST['status'];

            // Флаг ошибок в форме
            $errors = false;

            // При необходимости можно валидировать значения нужным образом
            if (!isset($name) || empty($name)) {
                $errors[] = 'Заполните поля';
            }


            if ($errors == false) {
                // Если ошибок нет
                // Добавляем новую категорию
                Category::updateCategory($name, $sortOrder, $status, $id);

                // Перенаправляем пользователя на страницу управлениями категориями
                header("Location: /admin/category");
            }

        }

        require_once ROOT . '/views/admin_category/update.php';

        return true;

    }

}