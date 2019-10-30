<?message::show('login')?>

<form action="/auth/login" method="POST">
	<input required type="text"     name="login">
	<input required type="password" name="password">
	<input type="submit" value="Вход">
</form>
