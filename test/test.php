<!DOCTYPE html>
<html>
	<head>
		<title>Hash</title>
		<meta charset="utf-8">
	</head>
	<body>
		<form>
			<label for="pass">Mot de passe</label><br>
			<input id="pass" type="password" name="pass"><br>
			<input type="submit">
		</form><br><br>
		Mot de passe chiffré<br>
		<textarea autofocus id="hash"><?php if(isset($_GET['pass'])) echo password_hash($_GET['pass'], PASSWORD_DEFAULT);?></textarea>
	</body>
</html>
