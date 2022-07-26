<?php

//=============================================================================
// 1FORM DISPLAY
//=============================================================================


function openForm($page,$action,$method="POST")
{
	echo '<main><form action="'./* JH: is dit niet altijd index.php? */ $action.'" method="'.$method.'" >'.PHP_EOL
.'		<input type="hidden" name="page" value="'.$page.'" />'.PHP_EOL;
}


function closeForm($submit_caption="Verstuur")
{
	echo '		<input  type="submit" value="Verstuur"></input>'.PHP_EOL
		.'	</form></main>'.PHP_EOL;
}


function showFields($arr_fieldinfo, $arr_postresult=array())
{

	foreach ($arr_fieldinfo as $fieldname => $fieldinfo)
	{
		
		echo '		<label for="'.$fieldname.'">'.$fieldinfo['label'].'</label>';
		switch ($fieldinfo['type'])
		{
			case "textarea" :
				echo '		<textarea name="'
					.$fieldname
					.'" placeholder="'
					.$fieldinfo['placeholder'].'">'
					//ternary operator
					.(isset($arr_postresult[$fieldname]) ? $arr_postresult[$fieldname] : '')
					.'</textarea>'
					;
				break;

			case "select" :
				$current_value = (isset($arr_postresult[$fieldname]) ? $arr_postresult[$fieldname] : '');
				echo '		<select name="'.$fieldname.'">'.PHP_EOL;
				if (isset($fieldinfo['options_func']))
				{	
					//call_user_funct is een ingebouwde php functie die een waarde uit de array teruggeeft
					$options = call_user_func($fieldinfo['options_func']);
					if ($options)
					{
						foreach ($options as $key => $value)
						{
							$selected = $current_value==$value ? "selected" : "";
							echo '<option value="'.$value.'" '.$selected.'>'.$key.'</option>'.PHP_EOL;
						}
					}						
				}
				echo '		</select>'.PHP_EOL;
				break;
			case "radio" :	
			echo '		<input type="'.$fieldinfo['type'] /* JH TIP: Spring na een case altijd iets verder in */
				.'" name="'.$fieldname
				// .'" placeholder="'.$fieldinfo['placeholder'].'"value="' 
				.(isset($arr_postresult[$fieldname]) ? $arr_postresult[$fieldname] : '')
				.'" />' /* JH: De voorheen geselecteerde radiobutton wordt niet opnieuw ge'checked' als iets anders in het formulier fout is */
				.PHP_EOL;
			break;
			default :	
				echo '		<input type="'.$fieldinfo['type']
					.'" name="'.$fieldname
					.'" placeholder="'.$fieldinfo['placeholder'].'"value="' 
					.(isset($arr_postresult[$fieldname]) ? $arr_postresult[$fieldname] : '')
					.'" />'
					.PHP_EOL;
				break;
		}
		echo '<br />'.PHP_EOL;
		if (isset($arr_postresult[$fieldname.'_err']))
		{
			echo '	<span class="error">* '.$arr_postresult[$fieldname.'_err'].'</span><br/>';
		}			
	}
}


//=============================================================================
// FORM RESULT
// Loop door alle velden, toon per veld naam, type en geposte waarde
//=============================================================================
function showResult($arr_fieldinfo, $arr_postresult)
{	
	echo "Bedankt voor uw reactie:";
	echo '<table>'.PHP_EOL;	
	// echo '<tr><th>name</th><th>type</th><th>value</th></tr>'.PHP_EOL;
	foreach ($arr_fieldinfo as $fieldname => $fieldinfo)
	{
		echo '<tr><td>'
			.$fieldinfo['label']
			.'</td><td>'
			// .$fieldinfo['type']
			.'</td><td>'
			.$arr_postresult[$fieldname]
			.'</td></tr>'
			.PHP_EOL;
	}
	echo '</table>'.PHP_EOL;	
}

//=============================================================================

?>