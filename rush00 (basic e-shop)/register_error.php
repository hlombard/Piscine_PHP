<html>
<meta charset="UTF-8">
<body>
	Désolé mais le nom d'utilisateur: [
	<?php echo $_REQUEST["login"];?>
	] est déjà pris.
	<br \> <br \>
	Vous allez être redirigé de nouveau sur la page de création d'utilisateur dans 5 secondes
	<?php
		Header("refresh:5; url=register.html");
	?>
</body>
</html>
