<?php

function showWebshopHeader(){
    echo"<header><H1>MARCK'S WEBSHOP</H1></header>";


}

function getProducts(){
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

    $sql = "SELECT id, name, price, stock, picture, details FROM products";
    $result = mysqli_query($conn, $sql);
    $products = array();

    if (mysqli_num_rows($result) > 0) {
      // output data of each row
      while($row = mysqli_fetch_assoc($result)) {
        $products[$row['id']]=array(
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
    return $products;
    mysqli_close($conn);    
}

function showProducts(){
    $products=getProducts();
    echo'<div class="products">'.PHP_EOL; 
    foreach ($products as $product)
    // <li><img src="'.$product['picture'].'.jpg" style="width:200px;height:200px;"></li>
    // <a href="https://www.w3schools.com/tags/tag_img.asp">

    //LET OP LOCATIE MAP!
 
    {
        echo'
        <div class = "product">
            <ul>
                <a href="index.php?page=detail&id='
                .$product['id']
                .'">
                <li><img src="/opdracht_3.1_opzet/images/'.$product['picture'].'.jpg" style="width:300px;height:300px;"></li>
                <li>'.$product['name']. '</li>
                <li>€'.$product['price'].'</li>
                <li>Vooraad:'.$product['stock'].'</li>
                </a>
                <li>';
                if(checkSession()){
                  echo '<button type="hidden" name= "id"value="'.$product['id'].'">Klik voor details</button>';
              }else{
                  echo '<a href="index.php?page=login">Log in om te bestellen</a>';
              };
                echo '</li>           
            </ul>     
      </div>';
    }
    echo '</div>'.PHP_EOL;

}

?>