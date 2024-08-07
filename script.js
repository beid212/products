$(document).ready(function(){
    $(".hidden").click(function(){
        let tr = $(this).closest("tr");
        let product_id = Number(tr.find('.product_id').text());
        
        $.ajax({
            url:"productsAction.php",
            method:"post",
            data:{
                product_id:product_id,
                action:"unbisible"
            }
        }).done(()=>{
            tr.remove();
        })
    });
    $(".plus").click(function(){
        let tr = $(this).closest("tr");
        let product_id = Number(tr.find('.product_id').text());
        let productQuantity = Number(tr.find(".product_quantity").text());
       $.ajax({
            url:"productsAction.php",
            method:"post",
            data:{
                product_id:product_id,
                action:"plus_product",
                quantity:1
            }
       }).done(()=>{
            tr.find(".product_quantity").text(productQuantity+1);
       });
    });

    $(".minus").click(function(){
        let tr = $(this).closest("tr");
        let product_id = Number(tr.find('.product_id').text());
        let productQuantity = Number(tr.find(".product_quantity").text());
        if(productQuantity-1<0)
        {
            alert("Ошибка! Нельзя поставить отрицательное кол-во продуктов!");
            return;
        }
        $.ajax({
            url:"productsAction.php",
            method:"post",
            data:{
                product_id:product_id,
                action:"minus_product",
                quantity:1
            }
        }).done(()=>{
            tr.find(".product_quantity").text(productQuantity-1);
        });
    });
});