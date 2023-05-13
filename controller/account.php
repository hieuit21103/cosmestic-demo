<?php

if(isset($_POST['account-edit-submit'])){
    $id = $_POST['edit-id'];
    $type = $_POST['type'];
    try{
        $db = new PDO('sqlite:..\database\database.sqlite');
        $db->setAttribute(3,2);
        $stmt = $db->prepare("UPDATE account SET type=$type WHERE user_id=$id");
        $stmt->execute();
    }catch (PDOException $exception){
        die($exception->getMessage());
    }
    header('Location: ../admin.php#account-table');
    die();
}

if (isset($_POST['account-delete-submit'])) {
    try {
        $id = $_POST['delete-id'];
        $db = new PDO('sqlite:..\database\database.sqlite');
        $db->setAttribute(3, 2);
        $stmt = $db->prepare("DELETE FROM account WHERE user_id=$id");
        $stmt->execute();
    } catch (PDOException $exception) {
        die($exception->getMessage());
    }
    header('Location: ../admin.php#account-table');
    die();
}
