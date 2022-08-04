<?php

// Maark nieuwe functie getProduuct ipv tetProducts


function showProduct($id){
// var_dump($id);
require_once('webshop.php');
// GW : Alle producten ophalen uit database terwijl je er maar 1 nodig hebt?
$products=getProducts();
// var_dump($items);
// GW : Waarom? Je geeft $id al mee als parameter!
// $id=$_GET['id'];

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

function addToCartOld(){//hier zat de fout mbt de id en lege array
// function addToCart($id){
    require_once('webshop.php');
    $products=getProducts();
    var_dump( $_GET);
// GW : geef het gewenste id mee als parameter aan deze functie!
// Zorg dat je aan de aanroepende kant controleert of het id in de post wel geldig is!	
    $id=$_POST['id'];
    // var_dump($id); 
// GW : Enkel het id en het aantal is nodig in je sessie, alle andere info 
// kun je ophalen wanneer iemand de cart wil bekijken!		   
    $productToAdd=$products[$id];//product uit de array van database
    // $numberOfProducts=$_SESSION['cart_product'][$id]['number'];//nu gedefinieerde array voor cart
    if(isset($_SESSION['cart_products'][$id]['number'])){
        $numberOfProducts=$_SESSION['cart_products'][$id]['number'];
        $numberOfProducts=$numberOfProducts+1;
        $_SESSION['cart_products'][$id]['number']=$numberOfProducts;
    }else{
        $productToAdd['number']=1;
        $_SESSION['cart_products'][$id]=$productToAdd;
    }
}



function addToCart($id){//$id wordt bij processrequest meegegeven
    var_dump($id);
    require_once('webshop.php');
    $products=getProducts();
    $productToAdd=$products[$id];//product uit de array van database
    // $numberOfProducts=$_SESSION['cart_product'][$id]['number'];//nu gedefinieerde array voor cart
    if(isset($_SESSION['cart_products'][$id]['number'])){
        $numberOfProducts=$_SESSION['cart_products'][$id]['number'];
        $numberOfProducts=$numberOfProducts+1;
        $_SESSION['cart_products'][$id]['number']=$numberOfProducts;
    }else{
        $productToAdd['number']=1;
        $_SESSION['cart_products'][$id]=$productToAdd;
    }

    }


?>