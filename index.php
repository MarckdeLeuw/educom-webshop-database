<?php
session_start();
$page = getRequestedPage();
$result = processRequest($page);
showResponsePage($result);

function getRequestedPage() 
{     
    $requested_type = $_SERVER['REQUEST_METHOD']; 
    if ($requested_type == 'POST') 
    { 
        $requested_page = getPostVar('page','home'); 
    } 
    else 
    { 
        $requested_page = getUrlVar('page','home'); 
    } 
    return $requested_page; 
} 

function getArrayVal($array, $key, $default='') 
{ 
    return isset($array[$key]) ? $array[$key] : $default; 
} 
function getPostVar($key, $default='') 
{ 
       return getArrayVal($_GET, $key, $default);
} 
function getUrlVar($key, $default='') 
{ 
    return getArrayVal($_GET, $key, $default);
} 


function processRequest($page){
// GW : wanneer je functie een array $result gaat retourneren,
// begin dan met deze variabele te declareren, zodat je ZEKER bent dat er ALTIJD een geld result bestaat!
    switch($page){

        case "login":
            require ('login.php');
            $fields = getLoginFields();
// GW : deze test zie ik op veel plekken terugkomen, dat kan beter!	
            if ($_SERVER['REQUEST_METHOD']=='POST')
            {
                require('validation.php');
//GW : de variabele $result gebruik je voor het resultaat van je functie	
//door hem hier voor een andere functionaliteit te gebruiken creeer je verwarring en mogelijke bugs!	
                $result = checkFields($fields);
                if($result['ok']===true){        
                    doLoginUser($result['extra']);               
                    $page='home';
                }
            }
            $result['fields'] = $fields;            
            break;
        
            case  "logout":
                require('validation.php');
                session_destroy();
                $_SESSION['userName'] = NULL;
                $page = 'home';
            break;


        case "register":
            require_once ('register.php');
            $fields = getRegisterFields();
            if ($_SERVER['REQUEST_METHOD']=='POST')
            {
                require('validation.php');
                $result = checkFields($fields);                
                if($result['ok']===true){
                    addUser($result['extra']);  
                    $page='login';
                }
            }
            $result['fields'] = $fields;           
            break;

        case "contact":
            require('contact.php');
            $fields = getContactFields();
            if ($_SERVER['REQUEST_METHOD']=='POST')
            {
                require('validation.php');
                $result = checkFields($fields);                
                if($result['ok']===true){
                    // var_dump($fields['salutation']);
                    $page='thanks';
                    
                    
                }
            }
// GW door $result voor 2 verschillende dingen te gebruiken krijg je hier wel een
// erg vreemde situatie, door aan result een nieuwe keu post toe te voegen waarin je het hele rsult opnieuw opslaat!!	
            $result['fields'] = $fields; 
            $result['post']=$result;                      
            // var_dump($result);           
            break;

        case "detail":
            require_once('detail.php')        ;
            if ($_SERVER['REQUEST_METHOD']=='POST')
            {
// GW controleer HIER of het meegegeven id wel valid is	alvorens addToCart aan te roepen!	
                $id=$_GET['id'];
                addToCart($id);
                $page = 'cart';
            }
        break;

        case "cart":
            require_once('cart.php')        ;
            if ($_SERVER['REQUEST_METHOD']=='POST')
            {
                writeToOrders();                
                writeToOrderDetails(); 
                updateProductInventory();               
                $_SESSION['cart_products'] = NULL;
                $page = 'cart';
            }
        break;

        default:
        // echo "No process request";

    }
    $result['page']=$page;
    return $result;

}

function showResponsePage($page) 
{ 
   beginDocument(); 
   showHeadSection($page); 
   showBodySection($page); 
   endDocument(); 
}  

function beginDocument() 
{ 
   echo '<!doctype html> 
<html>'; 
} 
//============================================== 
function showHeadSection($page) 
{ 
echo'
<head>
<title></title> 
<link rel="stylesheet" href="styles.css">
</head>';
} 
echo "<br>";

function showBodySection($page) 
{ 
    echo '    <body>' . PHP_EOL; 
    showMenu(); 
    showContent($page); 
    showFooter(); 
    echo '    </body>' . PHP_EOL; 
} 
//============================================== 
function endDocument() 
{ 
echo  '</html>'; 
} 
//============================================== 


function showMenu(){
    $menuItems = array('home', 'about','contact', 'webshop', /*'detail',*/'register', 'login');
    $menuItemsLogin = array('home', 'about','contact','webshop',/* 'detail',*/ 'cart');
    
    echo 
    '<nav class="menu">
    <ul >';
    
    if (checkSession()){
    
    foreach ($menuItemsLogin as $value){
        echo '<li class="solid"><a href="index.php?page='.$value.'">'.$value.'</a></li>';
        }
        echo '<li class="solid"><a href="index.php?page=logout"> Logout '.$_SESSION["userName"].' </a></li>';
        
    
    }else{
    
    foreach ($menuItems as $value){
    echo '<li class="solid"><a href="index.php?page='.$value.'">'.$value.'</a></li>';
    }
    }
    
    echo '</ul></nav>';
    
    }

function checkSession()
{
return isset($_SESSION["userName"]);
}





function showContent($result){
    switch($result['page']){
        case 'home':
            require ('home.php');
            showHomeHeader();
            showHomeContent();
            break;
        case 'about':
            require ('about.php');
            showAboutHeader();
            showAboutContent();
            break;

        case 'thanks':
            // require ('contact.php');
            require('showForm.php');
            showResult($result['fields'],$result['post']);
            break;
            
        case 'webshop':
            // var_dump($_SESSION);
            require ('webshop.php');
            showWebshopHeader();
            showProducts();
            break;
        case 'detail':
            // var_dump($_SESSION);
            // var_dump($_POST);
            require_once ('detail.php');
            $id=$_GET['id'];
            var_dump($id);
            showProduct($id);
            // showProduct($id);
            break;
        case 'cart':
            // var_dump($_SESSION);
            require_once ('cart.php');
            // $id=$_GET['id'];
            // var_dump($id);
            showCart();
            // showProduct($id);
            break;   
      
        case 'login':
        case 'register':
        case 'contact':
            //require('functions.php');
            // ::: onderstaand geldt voor alle gevallen hierboven
            require('showForm.php');
            openForm($result['page'],'');
            showFields($result['fields'], $result);
            closeForm();
            // var_dump($data);

            //showLoginForm($data);
            break;
        
        default:
        echo "No process request";

    }
}
function showFooter() 
{ 

echo "
<footer>
    <p>&#169; 2022 M.W. de Leuw</p>
</footer>

</body>
</html>";
} 


?>