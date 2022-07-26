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

    switch($page){

        case "login":
            require ('login.php');
            $fields = getLoginFields();
            if ($_SERVER['REQUEST_METHOD']=='POST')
            {
                require('validation.php');
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
            $result['fields'] = $fields; 
            $result['post']=$result;
                      
            // var_dump($result);           
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
    $menuItems = array('home', 'about','contact', 'register', 'login');
    $menuItemsLogin = array('home', 'about','contact');
    
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