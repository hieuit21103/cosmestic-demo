<?php
session_start();
if(isset($_POST['login-button'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    try{
        // Kết nối đến CSDL
        $db = new PDO('sqlite:../database/database.sqlite');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Truy vấn tài khoản có tên đăng nhập là $username
        $stmt = $db->prepare("SELECT * FROM account WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $account = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($account) {
            // Kiểm tra mật khẩu
            if (password_verify($password, $account['password'])) {
                // Đăng nhập thành công
                $_SESSION['user_id'] = $account['user_id'];
                $_SESSION['username'] = $account['username'];
                if ($account['type'] == 0) {
                    header('Location: ../admin.php');
                } elseif ($account['type'] == 1) {
                    header('Location: ../index.php');
                }
                exit();
            } else {
                // Sai mật khẩu
                $error = "Sai mật khẩu";
            }
        } else {
            // Tài khoản không tồn tại
            $error = "Tài khoản không tồn tại";
        }

    }catch (PDOException $exception){
        die($exception->getMessage());
    }
    if(isset($error)){
        $_SESSION['login-error'] = $error;
        header('Location: ../index.php#my-Login');
    }
}
