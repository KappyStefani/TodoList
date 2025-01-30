<?php
session_start();
$conn = new mysqli("localhost", "root", "", "todolist");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // Não precisa escapar pois será usado no password_verify

    $result = mysqli_query($conn, "SELECT * FROM usuarios WHERE username='$username'")
        or die("Erro na consulta: " . mysqli_error($conn));
    $row = mysqli_fetch_assoc($result);

    // Comparação correta da senha
    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['usuario_id'] = $row['usuario_id'];

        header("Location: index.php");
        exit();
    } else {
        echo "<div class='message'>
        <p>Nome ou senha incorreto</p>
        </div> <br>";
    }
}
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <h1>Entrar</h1>
        <form autocomplete="off" action="login.php" method="post" class="form-container">
            <div class="row">
                <input name="username" value="" id="username" type="text" class="validate" required>
                <label class="active" for="username">Nome de usuário</label>

                <input name="password" value="" id="password" type="password" class="validate" required>
                <label class="active" for="password">Senha</label>

                <br>
                <div class="row center-align">
                    <button class="btn waves-effect waves-light container" type="submit" name="submit">Entrar</button>
                </div>
                <p class="row center-align">Não tem uma conta?<a href="registro.php"> Se registre!</a></p>
            </div>
        </form>
    </div>
</body>

</html>