<?php include ROOT . '/views/layouts/header.php' ?>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Каталог</h2>
                        <div class="panel-group category-products">
                            <?php foreach ($categories as $categoryItem) : ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a href="/category/<?php echo $categoryItem['id']; ?>"
                                               class="<?php if ($categoryId == $categoryItem['id']) echo 'active'; ?>">
                                                <?php echo $categoryItem['name'] ?>
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="product-details"><!--product-details-->
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="view-product">
                                    <img src="images/product-details/1.jpg" alt=""/>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="product-information"><!--/product-information-->
                                    <img src="images/product-details/new.jpg" class="newarrival" alt=""/>
                                    <h2><?php echo $product['name']; ?></h2>
                                    <p>Код товара: <?php echo $product['code']; ?></p>
                                    <span>
                                            <span>US $<?php echo $product['price']; ?></span>
                                            <label>Количество:</label>
                                            <input type="text" id="count" value="1"/>
                                            <button type="button" data-id="<?php echo $product['id']; ?>" id="product-add" class="btn btn-fefault cart ">
                                                <i class="fa fa-shopping-cart"></i>
                                                В корзину
                                            </button>
                                        </span>
                                    <p><b>Наличие:</b>
                                        <?php
                                        if ($product['availability'] == 1) echo 'На складе';
                                        else echo 'Нет в наличии';
                                        ?>
                                    </p>
                                    <p><b>Состояние:</b>
                                        <?php
                                        if ($product['is_new'] == 1) echo 'Новое';
                                        else echo 'б/у';
                                        ?>
                                    </p>
                                    <p><b>Производитель:</b> <?php echo $product['brand']; ?></p>
                                </div><!--/product-information-->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <h5>Описание товара</h5>
                                <p>
                                    <?php echo $product['description'];?>
                                </p>

                            </div>
                        </div>
                    </div><!--/product-details-->

                </div>
            </div>
        </div>
    </section>


    <br/>
    <br/>

<?php include ROOT . '/views/layouts/footer.php' ?>
<script>
    $(document).ready(function () {
        $("#product-add").click(function () {
            var id = $(this).attr("data-id");
            var count = $("#count").val();

            var resp = {
                id :id,
                count : count
            };

            $.post("/product/addAjax", resp, function (data) {
                $("#cart-count").html(data);
            });
            return false;
        })
    });
</script>
