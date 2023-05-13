<?php
session_start();
if(isset($_GET['user_id'])){
    $user_id = $_GET['user_id'];
    try {
        $db = new PDO('sqlite:./database/database.sqlite');
        $db->setAttribute(3,2);
        $stmt = $db->prepare('SELECT cart_id, cus.id as cusid, sum(p.price * cart_detail.quantity) as total FROM cart INNER JOIN cart_detail on cart.id = cart_detail.cart_id INNER JOIN products p on cart_detail.product_id = p.id inner join customers cus on user_id=cus.id WHERE user_id=:user_id');
        $stmt->bindParam(':user_id',$user_id);
        $stmt->execute();
        $paid = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($paid);
        if($paid) {
            $currentDate = date('Y-m-d H:i:s');
            $customerID = $paid['cusid'];
            $total = $paid['total'];
            $status = 1;
            $transport = 1;
            $stmt = $db->prepare('INSERT INTO invoices(DATE, CUSTOMER_ID, TOTAL_PAID, STATUS, TRANSPORT_ID) VALUES (:current,:id,:total,:status,:transport)');
            $stmt->bindParam(':current', $currentDate);
            $stmt->bindParam(':id', $customerID);
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':transport', $transport);
            $stmt->execute();
            echo "Đặt hàng thành công";
            sleep(3);
            header('Location: ./index.php');
        }else{
            $error = "";
        }
        header("Location: ./cart.php?user_id=$user_id");
    }catch (PDOException $exception){
        die($exception->getMessage());
    }
}