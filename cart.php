<?php
function showCart(){
  $productsInCart= $_SESSION['cart_product'];
  var_dump($productsInCart);  
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
}
?>