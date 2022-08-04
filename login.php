<?php

function getLoginFields() : array
{return array(			   							
	'email' 	=> array
	('type' => 'email',
	//('type' => 'text',
	'label'=> 'Emailadres:',
	'placeholder' => 'Enter your email address',
	//controleren of email bestaat in tekstbestand
	'check' => 'authenticateUser:password'
	//'check' => ''
	),
	'password'	=> array
	('type' => 'text', 		
	'label'=> 'Password1:',
	'placeholder' => 'Enter your password',
	//controleren of password en emailadres ovreenkomen
	'check' => ''
	),															
);
}

?>