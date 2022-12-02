<html>
<head>
    <title>Password Encrypter</title>
</head>
<body>
<form action="index.php" method="POST">
    <input type="text" name="password" placeholder="password">
    <input type="submit" name="submit">
</form>
<?php
echo "<p>Password: ". $_POST['password'] ."</p>";
echo "<p>Encrypted: ". password_hash($_POST['password'], PASSWORD_DEFAULT) ."</p>";
?>
</body>
</html>