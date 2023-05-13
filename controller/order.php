<?php

if (isset($_POST['order-delete-submit'])) {
    $id = $_POST['id'];
    try {
        $db = new PDO('sqlite:..\database\database.sqlite');
        $db->setAttribute(3, 2);
        $stmt = $db->prepare("DELETE FROM invoices WHERE id=$id");
        $stmt->execute();
    } catch (PDOException $exception) {
        echo $exception->getMessage();
    }
    header('Location: ../admin.php#order-table');
    die();
}
