<?php

//=============================================================================
// FORM VALIDATION
//contact
//=============================================================================


function validEmail($value)
{
	return filter_var($value, FILTER_VALIDATE_EMAIL);	
}

// =============================================================
// LOGIN VALIDATION
//===============================================================

function authenticateUser($value, $otherValues){
	// var_dump($value, $otherValues);
    $user = findUserByEmail($value);
	// var_dump($user);	
    if($user===NULL){
        $userLogin= array(
            'valid'     =>  false,
			'error'     =>  'user unknown',
        );
		//var_dump($userLogin);
		return $userLogin;
    }else{

	// var_dump($otherValues[0]);
    if($otherValues[0]===$user['password']){
        $userLogin= array(
            'valid'     =>  true,
            'email'     =>  $user['email'],
            'extra'      =>  $user['name'],
        ); 
		// var_dump($userLogin);
        return $userLogin;        
    }else{
        $userLogin= array(
            'valid'     =>  false,
			'error'     =>  'password does not match with email',
        );
		return $userLogin;
		//var_dump($userLogin);
    }
    }
}


function doLoginUser($userName){
	$_SESSION['userName']=$userName;
}

//==================================
//REGISTER VALIDATION
//==================================


function samePassword($value, $otherValues){

    $user = findUserByEmail($value);

	if($user===NULL){
		if($otherValues[1]===$otherValues[2]){
			$newUser = array(
				'valid'=>true,
				'extra'=>array(		
				'email'=> $value,
				'name'=>$otherValues[0],
				'password'=>$otherValues[1])
			);
			var_dump($newUser);
			return $newUser;
		}else{
			$newUser= array(
				'valid'     =>  false,
				'error'     =>  'passwords do not match',
			);
			var_dump($newUser);
			return $newUser;
		}	
    }else{
        $newUser= array(
            'valid'     =>  false,
			'error'     =>  'Emailadres already exists',
        );
		var_dump($newUser);
		return $newUser;
    }
}

function addUser($newUser){
    $servername = "localhost";
    $username = "gebruiker";
    $password = "OIT.fxhgeTO6(reM";
    $dbname = "marck_webshop";
// Create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

$sql = "INSERT INTO users(naam, email, wachtwoord)
VALUES ('".$newUser['name']."','".$newUser['email']."','".$newUser['password']."')";

if (mysqli_query($conn, $sql)) {
    // $last_id = mysqli_insert_id($conn);
    // echo "New record created successfully. Last inserted ID is: " . $last_id;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn); 
};

function addUserOld($newUser){
    $file = 'dataUser/users.txt';
    $stringUser = PHP_EOL . $newUser['email']. '|' . $newUser['name'] . '|' . $newUser['password'] ;
    $newFile = fopen($file,"a");
    fwrite($newFile,$stringUser);
    fclose($newFile);
};

//==================================
//LOGIN EN REGISTER VALIDATION
//==================================
function findUserByEmail($email){
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
$sql = "SELECT id, naam, email, wachtwoord FROM users WHERE email ='".$email."'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
    $user=array(
        'email'=>$row["email"],
        'name'=>$row["naam"],
        'password'=>$row["wachtwoord"]
    );
    }
} else {
    $user = NULL;
}

mysqli_close($conn);
return $user;
}
//textFile version:

function findUserByEmailOld($content){
    $file = 'dataUser/users.txt';
    $myFile = fopen($file, "r") or die("Unable to open file!");
    $firstLine=fgets($myFile);
    $trimFirstLine=trim($firstLine, "[]\n");
    $keyUser = explode("]|[", $trimFirstLine);
    
    $valueUser=array();
    $userExist = false;
    while(!feof($myFile)&&!$userExist) {
        //achter && !userExists alleen element 0 controleren
        $line = fgets($myFile);
        $trimLine=trim($line, "\n");
        $valueUser =  explode("|",$trimLine);
        if(array_search($content,$valueUser)===false){        
        }else{
        $userExist = true;
        }
    }
    fclose($myFile);
    
    if($userExist===true){
    $user= array_combine($keyUser,$valueUser);
    }else{
    $user = NULL;
    }
    return $user;
}
//==================================
//FIELD VALIDATION
//==================================

//=============================================================================
function checkField($fieldname, $fieldinfo)
{
	//ML eerst wordt lege array aangemaakt
	$result = array();
	$result['ok'] = false;
  /* JH: Je kan ook gebruik maken van de getArrayVal functie: $value = getArrayVar($_POST, $fieldname); */
	if (isset($_POST[$fieldname]))
	{
		$value = $_POST[$fieldname];
		$value = trim($value); 
		$value = stripslashes($value); 
		$value = htmlspecialchars($value); 
		//value is dus de geposte waarde
		if (empty($value))
		{
			// array key wordt aangemaakt met naam_err en de label waarde wordt empty
			$result[$fieldname.'_err'] = $fieldinfo['label'].' is empty.';
			//$result['valid'] = false;
		}
		else
		{
			//na toevoegen select geeft onderstaand een foutmelding
			var_dump($fieldinfo['check']);
			if ($fieldinfo['check'])
			{
				$fielddata = explode(":", $fieldinfo['check']);
				var_dump($fielddata);
				var_dump(count($fielddata));
				if(count($fielddata)>1){
					for($i=1; $i < count($fielddata); $i++) {
						$otherValues[] = trim(stripslashes(htmlspecialchars($_POST[$fielddata[$i]])));
						var_dump($otherValues);
					}
					$valid = call_user_func($fielddata[0], $value, $otherValues);
				}else{
			
				$valid = call_user_func($fieldinfo['check'], $value);}
			
				if (is_array($valid) ? $valid['valid'] : $valid)
			
				{
					$result['ok'] = true;
					$result[$fieldname] = $value;
					if (is_array($valid) && array_key_exists("extra", $valid)) {
						$result['extra'] = $valid['extra'];
					}
				}
				else
				{
				
					if (is_array($valid) && array_key_exists("error", $valid)) {
						$result[$fieldname.'_err'] = $fieldinfo['label'].' '.$valid['error'];
					} else {
						$result[$fieldname.'_err'] = $fieldinfo['label'].' is invalid.';
					}
				}			
			}		
			else
			{	
				$result['ok'] = true;
				$result[$fieldname] = $value;
			}	
		}	

	}
	else
	{
		$result[$fieldname.'_err'] = $fieldname.' not found.';
	}
	return $result;
}


function checkFields($arr_fieldinfo)
{
	$result = array();
	$result['ok'] = true;
	foreach ($arr_fieldinfo as $fieldname => $fieldinfo)
	{
		$check = checkField($fieldname, $fieldinfo);
		if ($check['ok'])
		{
			$result[$fieldname] = $check[$fieldname];
			if (array_key_exists("extra", $check)) {
				$result['extra'] = $check['extra'];
			}
		}	
		else
		{
			$result['ok'] = false;
			$result[$fieldname.'_err'] = $check[$fieldname.'_err'];
		}			
	}
	return $result;
}


?>