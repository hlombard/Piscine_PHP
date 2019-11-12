#!/usr/bin/php
<?php
while (1)
{
	echo "Entrez un nombre: ";
	$nb = trim(fgets(STDIN));
	if (feof(STDIN) === true)
	{
		echo "\n";
		break;
	}
	$notnb = 0;
	for ($i = 0; $i < strlen($nb); $i++)
	{
		if ($i == 0 && is_numeric($nb[$i]) === false)
		{ 
			if ($nb[$i] != '+' && $nb[$i] != '-')
			{
				$notnb = 1;
				break;
			}
			else
			{
				if (strlen($nb) === 1)
					$notnb = 1;
			}	
		}
		if ($i != 0)
		{
			if (is_numeric($nb[$i]) === false)
				$notnb = 1;
		}		
	}
	if ($notnb === 1 || strlen($nb) === 0)
		echo "'$nb' n'est pas un chiffre\n";
	else
	{
		$len = strlen($nb) - 1;
		if ($nb[$len] % 2 === 0)
			echo "Le chiffre $nb est Pair\n";
		else
			echo "Le chiffre $nb est Impair\n";
	}
}
?>
