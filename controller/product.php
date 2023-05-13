<?php
if(isset($_POST['product-add-submit'])){
	$target_dir = "assets/img/product/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
	$image = $target_file;
	$name = $_POST['name'];
	$price = $_POST['price'];
	$quantity = $_POST['quantity'];
	$type = $_POST['type'];

	try {
		$db = new PDO('sqlite:..\database\database.sqlite');
		$db->setAttribute(3,2);
		$stmt = $db->prepare("INSERT INTO products(IMAGE, NAME, PRICE, QUANTITY, TYPE) VALUES ('$image','$name','$price','$quantity','$type')");
		$stmt->execute();
	}catch (PDOException $exception){
		echo $exception->getMessage();
	}

	header('Location: ../admin.php#product-table');
	die();
}

if(isset($_POST['product-delete-submit'])){
    $id = $_POST['id'];
    try {
        $db = new PDO('sqlite:..\database\database.sqlite');
        $db->setAttribute(3,2);
        $stmt = $db->prepare("DELETE FROM products WHERE id=$id");
        $stmt->execute();
    }catch (PDOException $exception){
        echo $exception->getMessage();
    }
    header('Location: ../admin.php#product-table');
    die();
}
