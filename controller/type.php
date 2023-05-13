<?php
if(isset($_POST['type-add-submit'])){
    $id = $_POST['id'];
    $name = $_POST['name'];

    try {
        $db = new PDO('sqlite:..\database\database.sqlite');
        $db->setAttribute(3,2);
        $stmt = $db->prepare("INSERT INTO types VALUES ('$id','$name')");
        $stmt->execute();
    }catch (PDOException $exception){
        echo $exception->getMessage();
    }

    header('Location: ../admin.php#types-table');
    die();
}

if(isset($_POST['type-delete-submit'])){
    $id = $_POST['delete-id'];
    try {
        $db = new PDO('sqlite:..\database\database.sqlite');
        $db->setAttribute(3,2);
        $stmt = $db->prepare("DELETE FROM types WHERE id=$id");
        $stmt->execute();
    }catch (PDOException $exception){
        echo $exception->getMessage();
    }
    header('Location: ../admin.php#types-table');
    die();
}
