<?php

function getRegisterFields() : array
{return array(
	'name'		=> array
	('type' => 'text', 		
	'label'=> 'Naam:',
	'placeholder' => 'Enter your name',
    'check' => ''
	),				   							
	'email' 	=> array
	('type' => 'email',	
	'label'=> 'Emailadres:',
	'placeholder' => 'Enter your email address',
	'check' => 'samePassword:name:password:passwordTwo'
	),
	'password'	=> array
	('type' => 'text', 		
	'label'=> 'Password1:',
	'placeholder' => 'Enter your password',
	'check' => ''
	),
	'passwordTwo'=> array
	('type' => 'text', 		
	'label'=> 'Password2:',
	'placeholder' => 'Enter your password',
	'check' => ''
	),																
);
}

?>