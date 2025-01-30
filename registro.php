<?php
$conn = new mysqli("localhost", "root", "", "todolist");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    echo "Formulário enviado!<br>";

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);


    $verify_query = mysqli_query($conn, "SELECT username FROM usuarios WHERE username='$username'");
    if (mysqli_num_rows($verify_query) != 0) {
        echo "<div class='message'><p>Esse usuário já está sendo utilizado, tente outro por favor!</p></div> <br>";
    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        $query = mysqli_query($conn, "INSERT INTO usuarios(username, password) VALUES('$username', '$hashed_password')");

        if ($query) {
            echo "<div class='message'><p>Registrado com sucesso!</p></div> <br>";
            header("Location: login.php"); // Redireciona para a página de login
            exit();
        } else {
            echo "<div class='message'><p>Erro ao cadastrar. Tente novamente.</p></div>";
        }
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
    <title>Registro</title>
</head>

<body>
    <div class="container">
        <h1>Registro</h1>
        <form autocomplete="off" action="registro.php" method="post" class="form-container">
            <div class="row">
                <input name="username" value="" id="username" type="text" class="validate" required>
                <label class="active" for="username">Nome de usuário</label>

                <input name="password" value="" id="password" type="password" class="validate" required>
                <label class="active" for="password">Senha</label>

                <br>
                <div class="row center-align">
                    <button class="btn waves-effect waves-light container" type="submit" name="submit">Cadastrar</button>
                </div>
                <p class="row center-align">Já tem uma conta? <a href="login.php">Faça login</a></p>
            </div>
        </form>
    </div>
</body>

</html>