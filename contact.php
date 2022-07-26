<?php
/* JH: Zet dit in een functie getContactFields() */
//=============================================================================
// TEST FORM met optionele validatie-callback
//=============================================================================
function getContactFields() : array
{return array(
	'salutation' 	=> array( /* JH: Gebruik geen <tab> karakters in je code, andere collega's hebben misschien andere tabinstellingen, beter om alle tabs te vervangen door spaties en je editor in te stellen om tabs om te zetten naar spaties */
						'type' => 'select',
						'label'=> 'Aanhef:',
						'options_func' => 'getSalutationOptions',
						'check' => ''
						),
	'firstName'		=> array('type' => 'text', 		
						 'label'=> 'Voornaam:',
						 'placeholder' => 'Enter your name',
						 'check' => ''
						),
	'lastName'		=> array('type' => 'text', 		
						'label'=> 'Achternaam:',
						'placeholder' => 'Enter your name',
						'check' => ''
					   ),					   							
	'email' 	=> array('type' => 'email',
						 'label'=> 'Emailadres:',
						 'placeholder' => 'Enter your email address',
						 'check' => 'validEmail'
						 //'check' => ''
						),
	'phoneNr' 	=> array('type' => 'text',
						'label'=> 'Telefoonnummer:',
						'placeholder' => 'Enter your phone nr',
						'check' => ''
					   ),
	'comPref' 	=> array(
						'type' => 'select',
						'label'=> 'Communicatievoorkeur:',
						'options_func' => 'getCommunicationPreference',
						'check' => ''
						),					   								
	'message' 	=> array('type' => 'textarea',
						 'label'=> 'Bericht:',
						 'placeholder' => 'Enter your message',
						 'check' => ''
						),
											
);
}
//$contactform_fields = getContactFields();

function getSalutationOptions() : array
{
    return array(
	'Dhr' => 'mister',
	'Mvr' => 'miss',
	'nvt'  => 'gender_neutral'
    );
}

function getCommunicationPreference() : array
{
    return array(
	'Email' 		=> 'email',
	'Telefoonnumer' => 'tel'
    );
}

?>