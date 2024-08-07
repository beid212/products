<?php 
require_once "connectionProducts.php";


$products = $obProductsTable->sort("date_create","desc")->get("obj");
?>

<table>
    <thead>
        <tr>
            <th>ID продукта</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Артикул</th>
            <th>Количество</th>
            <th>Дата создания</th>
        </tr>
    </thead>

    <tbody class="table-body">
        <?php foreach($products as $product):
                if(!(bool)$product->visible)
                {
                    continue;
                }
            ?>
            <tr>
                <th class="product_id"><?= $product->product_id;?></th>
                <th><?= $product->product_name;?></th>
                <th><?= $product->product_price;?> р.</th>
                <th><?= $product->product_article;?></th>
                <th>
                    <button class="plus">+</button> 
                    <span class="product_quantity"><?= $product->product_quantity;?></span> 
                    <button class="minus">-</button></th>
                <th><?= $product->date_create;?></th>
                <th><button class="hidden">Скрыть</button></th>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>

<script src="jquery.js"></script>
<script src="script.js"></script>