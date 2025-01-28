<?php
$conn = new mysqli("localhost", "root", "", "todolist");
if ($conn->connect_error) {
    die("Connection Failed " . $conn->connect_error);
}
if (isset($_POST["addtarefa"])) {
    $task = $_POST["task"];
    $conn->query("INSERT INTO tarefas (tarefas) VALUES ('$task')");
    header("location: index.php");
}

if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $conn->query("DELETE FROM tarefas WHERE id = '$id'");
    header("Location: index.php");
}

if (isset($_GET["complete"])) {
    $id = $_GET["complete"];
    $conn->query("UPDATE tarefas SET status ='completo' WHERE id =$id");
    header("Location: index.php");
}

$result = $conn->query("SELECT * FROM tarefas ORDER BY status = 'completo' ASC, id DESC");
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <title>Todo List</title>
</head>

<body>
    <div class="container">
        <h1>Lista de tarefas</h1>
        <form autocomplete="off" action="index.php" method="post" class="form-container">
            <input maxlength="25" type="text" name="task" placeholder="Digite a tarefa" id="">
            <button class="btn waves-effect waves-light" type="submit" name="addtarefa">Submit</button>
        </form>
        <ul class="collection with-header">
            <?php while ($row = $result->fetch_assoc()): ?>
                <li class="<?php echo $row["status"]; ?> collection-header ">
                    <strong><?php echo $row["tarefas"] ?></strong>
                    <div class="actions">
                        <?php if ($row["status"] != 'completo'): ?>
                            <a href="index.php?complete=<?php echo $row['id']; ?>" class="waves-effect waves-light btn-small"> Completo</a>
                        <?php endif; ?>
                        <a href="index.php?delete=<?php echo $row['id']; ?>" class="waves-effect waves-light red btn-small">Deletar</a>
                    </div>
                </li>
            <?php endwhile ?>
        </ul>
    </div>

</body>

</html>