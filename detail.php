<?php

// Maark nieuwe functie getProduuct ipv tetProducts

/*=============================================================================
    function showProductVervallen($id){
        // var_dump($id);
        require_once('webshop.php');
        // GW : Alle producten ophalen uit database terwijl je er maar 1 nodig hebt?
        $products=getProducts();
        // var_dump($items);
        // GW : Waarom? Je geeft $id al mee als parameter!
        // $id=$_GET['id'];

        // var_dump($id);
        $product=$products[$id];
        var_dump($product);
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
==========================================================================================*/

function showProduct($id){
    // var_dump($id);
    $product=getProduct($id);
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

function getProduct($id){
    $servername = "localhost";
    $username = "gebruiker";
    $password = "OIT.fxhgeTO6(reM";
    $dbname = "marck_webshop";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT id, name, price, stock, picture, details FROM products where id=$id";
    $result = mysqli_query($conn, $sql);
    $product = array();

    if (mysqli_num_rows($result) > 0) {
    // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $product=array(
            'id'=>$row['id'],
            'name'=>$row['name'],
            'price'=>$row['price'],
            'stock'=>$row['stock'],
            'picture'=>$row['picture'],
            'details'=>$row['details'],
            );
        // var_dump($products);
        // echo '</br>';
            }
    } else {
    echo "0 results";
    }
    return $product;
    mysqli_close($conn);    
}

/*========================================================================================
    function addToCartVervallen(){//hier zat de fout mbt de id en lege array
        // function addToCart($id){
        require_once('webshop.php');
        $products=getProducts();
        var_dump( $_GET);
        // GW : geef het gewenste id mee als parameter aan deze functie!
        // Zorg dat je aan de aanroepende kant controleert of het id in de post wel geldig is!	
    // ML: Bijvoorbeeld is aantal groter dan nul??
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

    function addToCartVervallen2($id){//$id wordt bij processrequest meegegeven
        // var_dump($id);
        require_once('webshop.php');
        $product=getProduct($id);
        $productToAdd=$product;//product uit de array van database
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
===========================================================================*/


    function addToCart($id){//$id wordt bij processrequest meegegeven
        if(isset($_SESSION['cart_products'][$id]['number'])){
            $numberOfProducts=$_SESSION['cart_products'][$id]['number'];
            $numberOfProducts=$numberOfProducts+1;
            $_SESSION['cart_products'][$id]['number']=$numberOfProducts;
        }else{
            $_SESSION['cart_products'][$id]['id']=$id;
            $_SESSION['cart_products'][$id]['number']=1;                     
        }
        }
?>