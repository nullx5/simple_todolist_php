<?php
	$servername = "localhost";
	$DBname = "todolist";
	$username = "root";
	$password = "";
	
    $connectionPDO = new PDO("mysql:host=$servername;dbname=$DBname;charset=utf8", $username, $password);
?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
    <title>Todo List</title>
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
</head>

<body class="container">
    <h1>Add Task</h1>
    <form method="post" action="">
        <input type="text" name="name" value="">
        <input type="submit" name="submit" value="Add">
    </form>
    <h2>List of Tasks</h2>
    <table class="table table-striped">
        <thead><th>Tasks</th><th></th></thead>
        <tbody>
<?php
       if(isset($_POST["submit"]) ){
        $name = $_POST["name"];
        $prepared_statement = $connectionPDO->prepare("INSERT INTO tasks (name) VALUES (:name)");
        $prepared_statement->bindValue(":name", $name, PDO::PARAM_STR);
        $prepared_statement->execute();
    }elseif(isset($_POST["delete"])){
        $id = $_POST["id"];
        $prepared_statement = $connectionPDO->prepare("delete from tasks where id = :id");
        $prepared_statement->bindValue(":id", $id, PDO::PARAM_INT);
        $prepared_statement->execute();
    }	
	
    $prepared_statement = $connectionPDO->prepare("SELECT * FROM tasks ORDER BY id DESC");
    $prepared_statement->execute();
    
    foreach($prepared_statement as $row) {
?>
            <tr>
                <td><?= $row["name"] ?></td>
                <td>
                    <form method="POST">
                        <button type="submit" name="delete">Delete</button>
                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                    </form>
                </td>
            </tr>
<?php
    }
	
?>
        </tbody>
    </table>
</body>
</html>