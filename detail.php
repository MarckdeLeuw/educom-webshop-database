<?php

function showProduct($id){
// var_dump($id);
require_once('webshop.php');
$products=getProducts();
// var_dump($items);
$id=$_GET['id'];
// var_dump($id);
$product=$products[$id];
// var_dump($product);
echo'
<div class = "product">
    <ul>        
        <li><img src="/opdracht_3.1_opzet/images/'.$product['picture'].'.jpg" style="width:300px;height:300px;"></li>
        <li>'.$product['name']. '</li>
        <li>€'.$product['price'].'</li>
        <li>Vooraad:'.$product['stock'].'</li>
        <li>Beschrijving:'.$product['details'].'</li>    
        <li>';
        if(checkSession()){
            require_once('showForm.php');
            openForm('detail','');
            echo '<input type = "hidden" name="id"value ="'.$product['id'].'">';
            closeForm("Voeg toe aan winkelwagen");                    
            // echo '<button type="submit" name= "id" value="'.$product['id'].'">Voeg toe aan winkelwagen</button>';
        }else{
            echo '<a href="index.php?page=login">Log in om te bestellen</a>';
        };
        echo '</li>    
    </ul>     
</div>';
}

// function addToCart(){
//     require_once('webshop.php');
//     $products=getProducts();
//     // var_dump( $_POST);
//     $id=$_POST['id'];
//     // var_dump($id);    
//     $product=$products[$id];
//     // var_dump($product);
//     $_SESSION['cart_product'][$id]=$product;    
// }

function addToCart(){
    require_once('webshop.php');
    $products=getProducts();
    // var_dump( $_POST);
    $id=$_POST['id'];
        // var_dump($id);    
    $productToAdd=$products[$id];//product uit de array van database
    // $numberOfProducts=$_SESSION['cart_product'][$id]['number'];//nu gedefinieerde array voor cart
    if(isset($_SESSION['cart_product'][$id]['number'])){
        $numberOfProducts=$_SESSION['cart_product'][$id]['number'];
        $numberOfProducts=$numberOfProducts+1;
        $_SESSION['cart_product'][$id]['number']=$numberOfProducts;
    }else{
        $productToAdd['number']=1;
        $_SESSION['cart_product'][$id]=$productToAdd;
    }
}

?>