<?php
session_start();
$name = $_POST['name'];
$number = $_POST['phone-number'];
$address = $_POST['address'];
$username = $_POST['username'];
$password = $_POST['password'];
$hashedPassword = password_hash($password,PASSWORD_DEFAULT);
$confirm_password = $_POST['re-password'];

try{
    $db = new PDO('sqlite:../database/database.sqlite');
    $db->setAttribute(3,2);
    $stmt = $db->prepare("SELECT * FROM account WHERE username=:username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $r){
        if($r['username'] == $username) {
            $error = "Tên đăng nhập đã tồn tại";
            $_SESSION['register-error'] = $error;
            header('Location: ../index.php#my-Register');
            exit();
        }
    }
    if($password != $confirm_password){
        $error = "Mật khẩu xác nhận không trùng khớp";
        $_SESSION['register-error'] = $error;
        header('Location: ../index.php#my-Register');
        exit();
    }
    $stmt = $db->prepare("INSERT INTO customers(name,phone,address) VALUES (:name,:number,:address)");
    $stmt->execute([':name' => $name, ':number' => $number, ':address' => $address]);
    $stmt = $db->prepare("SELECT last_insert_rowid()");
    $id = $stmt->execute();
    $stmt = $db->prepare("INSERT INTO account (username, password, data) VALUES (:username, :password, :data)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':data',$id);
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['register-success'] = "Đăng kí thành công";
    }

    header('Location: ../index.php#my-Login');
    die();

}catch (PDOException $exception){
    die($exception->getMessage());
}
