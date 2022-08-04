<?php

function totalPrice(){
  $productsInCart= $_SESSION['cart_products'];
  if ($productsInCart !==NULL){
    $totalPrice=0;
      foreach ($productsInCart as $product){
        $totalPrice=$totalPrice+$product['price']*$product['number'];
      } 
      return $totalPrice;   
  }
}

function createOrderNr(){
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
  // $sql = "SELECT id FROM orders";
  $sql = "SELECT max(id) FROM orders";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
  // output data of each row
  $row = mysqli_fetch_assoc($result);
  $id=$row['max(id)']+1;           
  } else {
  $id=1;
  }
  mysqli_close($conn);
  return $id;
}

function showCart(){  
  if (isset($_SESSION['cart_products'])){
  $productsInCart= $_SESSION['cart_products'];
  $_SESSION['orderNumber'] = createOrderNr();
  // var_dump($productsInCart);  
  var_dump($_SESSION);  
  echo ' <table>
    <tr>
    <th>id</th>
    <th>Afbeelding</th> 
    <th>Naam</th>    
    <th>Prijs</th>
    <th>Aantal</th> 
    <th>Subtotaal</th>  
    </tr>';

    foreach ($productsInCart as $product)
    
    {
      echo'
      <tr>
    <td>'.$product['id'] .'</td>
    <td><img src="/opdracht_3.1_opzet/images/'.$product['picture'].'.jpg" style="width:50px;height:50px;"></td>
    <td>'.$product['name'] .'</td>
    <td>'.$product['price'].'</td>
    <td>'.$product['number'].'</td>
    <td>'.$product['price']*$product['number'].'</td>     
    </tr>';    
    }
  echo'</table> ';
  echo 'Totaalprijs is €'.totalPrice();
  require_once('showForm.php');
  openForm('cart','');
  // echo '<input type = "hidden" name="id"value ="'.$product['id'].'">';
  closeForm("Afrekenen");    

  }else{
  echo'Uw winkelwagen is leeg.';
  }
}

function writeToOrders(){
  $servername = "localhost";
  $username = "gebruiker";
  $password = "OIT.fxhgeTO6(reM";
  $dbname = "marck_webshop";

  $orderNumber=$_SESSION['orderNumber'];
  $userId=$_SESSION['userId'];
  // $userId='100';//dit is een testwaarde
  // var_dump($orderNumber);
  // var_dump($userId);
  // Create connection
  $conn = mysqli_connect($servername, $username, $password,$dbname);
  // Check connection
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
      }
  echo "Connected successfully";
  $sql = "INSERT INTO orders(id, user_id)
  VALUES (".$orderNumber.",".$userId.")";
  if (mysqli_query($conn, $sql)) {
  // $last_id = mysqli_insert_id($conn);
  // echo "New record created successfully. Last inserted ID is: " . $last_id;
  } else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
  mysqli_close($conn); 
}

function writeToOrderDetails(){

  $servername = "localhost";
  $username = "gebruiker";
  $password = "OIT.fxhgeTO6(reM";
  $dbname = "marck_webshop";

  $orderNumber=$_SESSION['orderNumber'];
  $products=$_SESSION['cart_products'];

  $conn = mysqli_connect($servername, $username, $password,$dbname);
  // Check connection
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
      }
  echo "Connected successfully";

  foreach ($products as $product)
  {
    $sql = "INSERT INTO order_details(order_id, product_id, amount)
    VALUES (".$orderNumber.",".$product['id'].",".$product['number'].")"; 
    if (mysqli_query($conn, $sql)) {
    // $last_id = mysqli_insert_id($conn);
    // echo "New record created successfully. Last inserted ID is: " . $last_id;
    } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  }
  mysqli_close($conn); 

}

function updateProductInventory(){

  $servername = "localhost";
  $username = "gebruiker";
  $password = "OIT.fxhgeTO6(reM";
  $dbname = "marck_webshop";

  $products=$_SESSION['cart_products'];

  $conn = mysqli_connect($servername, $username, $password,$dbname);
  // Check connection
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
      }
  echo "Connected successfully";
    
  foreach ($products as $product)
  {
    $id=$product['id'];
    // $product['number'];
    $productStock=$product['stock']-$product['number'];
  
    $sql = "UPDATE products SET stock=$productStock WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
  }else{
  echo "Error updating record: " . mysqli_error($conn);
  }
  }
}
?>