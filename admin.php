<?php
session_start();
if(isset($_SESSION['user_id'])){
    if($_SESSION['user_id'] != 0){
        die("Not found");
    }
}else{
    die("Not found");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <script src="assets/js/admin.js"></script>
</head>
<body>
<a href="controller/logout.php">Đăng xuất</a>
<div class="navbar" id="navbar">
    <div class="navbar__item">
        <a href="#product-table">Sản phẩm</a>
    </div>
    <div class="navbar__item">
        <a href="#order-table">Đơn hàng</a>
    </div>
    <div class="navbar__item">
        <a href="#account-table" >Tài khoản</a>
    </div>
    <div class="navbar__item">
        <a href="#transport-table" >Quản lý đơn vị vận chuyển</a>
    </div>
    <div class="navbar__item">
        <a href="#types-table">Quản lý danh mục mỹ phẩm</a>
    </div>
</div>
<div class="product-table" id='product-table'>
        <table>
            <thead class="product-table-head">
            <tr>
                <th>Id</th>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá tiền</th>
                <th>Số lượng</th>
                <th>Loại</th>
            </tr>
            </thead>
            <tbody class="product-table-body">
            <?php
            try {
                $db = new PDO("sqlite:.\database\database.sqlite");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $db->prepare("SELECT * FROM PRODUCTS");
                $stmt->execute();
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $ex) {
                die($ex->getMessage());
            }
            ?>
            <script>
                try {
                    var products = <?php echo json_encode($products); ?>;
                } catch (error) {
                    console.log('Lỗi khi lấy dữ liệu sản phẩm:', error);
                    var products = [];
                }
                var productTableBody = document.querySelector('.product-table-body');
                for (var i = 0; i < products.length; i++) {
                    var data = products[i];
                    productTableBody.innerHTML +=
                        `<tr>
                        <td>${data.id}</td>
                        <td>${data.image}</td>
                        <td>${data.name}</td>
                        <td>${data.price}</td>
                        <td>${data.quantity}</td>
                        <td>${data.type}</td>
                    </tr>`;
                }
            </script>
            </tbody>
        </table>
        <button class="button_add" id="product-modal-trigger" onclick="addProduct()">Thêm</button>
        <button class="button_delete" id="product-modal-delete-button" onclick="deleteProduct()">Xoá</button>
    </div>
<form method="post" action="controller/product.php" enctype="multipart/form-data">
    <div id="product-modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Thêm sản phẩm</h2>
            <form>
                <div class="form-group">
                    <label for="product-image">Hình ảnh:</label>
                    <input type="file" id="product-image" name="image" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="product-name">Tên sản phẩm:</label>
                    <input type="text" id="product-name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="product-price">Giá:</label>
                    <input type="number" id="product-price" name="price" required>
                </div>
                <div class="form-group">
                    <label for="product-quantity">Số lượng:</label>
                    <input type="number" id="product-quantity" name="quantity" required>
                </div>
                <div class="form-group">
                    <label for="product-type">Loại:</label>
                    <input type="text" id="product-type" name="type" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="product-add-submit" value="Thêm">
                </div>
            </form>
        </div>
    </div>
</form>
<form method="post" action="controller/product.php" enctype="multipart/form-data">
    <div id="product-modal-delete" class="modal">
        <div class="modal-content">
            <span class="delete-close">&times;</span>
            <h2>Xoá sản phẩm</h2>
            <form>
                <div class="form-group">
                    <label for="product-id">Mã sản phẩm</label>
                    <input type="text" id="product-id" name="id" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="product-delete-submit" value="Xoá">
                </div>
            </form>
        </div>
    </div>
</form>
<div class="order-table" id='order-table'>
        <table>
            <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Ngày đặt hàng</th>
                <th>Tổng tiền</th>
                <th>Tên khách hàng</th>
                <th>Trạng thái</th>
                <th>Mã đơn vị vận chuyển</th>
            </tr>
            </thead>
            <tbody class="order-table-body">
            <?php
            try {
                $db = new PDO("sqlite:.\database\database.sqlite");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $db->prepare("SELECT * FROM invoices INNER JOIN customers c on c.id = invoices.customer_id");
                $stmt->execute();
                $order = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $ex) {
                die($ex->getMessage());
            }
            ?>
            <script>
                try {
                    var orders = <?php echo json_encode($order); ?>;
                } catch (error) {
                    console.log('Lỗi khi lấy dữ liệu đơn hàng:', error);
                    var orders = [];
                }
                var orderTableBody = document.querySelector('.order-table-body');
                for (var i = 0; i < orders.length; i++) {
                    var order = orders[i];
                    orderTableBody.innerHTML +=
                        `<tr>
                            <td>${order.id}</td>
                            <td>${order.date}</td>
                            <td>${order.total_paid}</td>
                            <td>${order.name}</td>
                            <td>${order.status}</td>
                            <td>${order.transport_id}</td>
                        </tr>`;
                }
            </script>
            </tbody>
        </table>
        <button class="button_delete" id="order-modal-delete-button" onclick="deleteOrder()">Xoá</button>
    </div>
<form method="post" action="controller/order.php">
    <div id="order-modal-delete" class="modal">
        <div class="modal-content">
            <span class="order-delete-close">&times;</span>
            <h2>Xoá đơn hàng</h2>
            <form>
                <div class="form-group">
                    <label for="order-id">Mã đơn</label>
                    <input type="text" id="order-id" name="id" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="order-delete-submit" value="Xoá">
                </div>
            </form>
        </div>
    </div>
</form>
<div class="account-table" id='account-table'>
    <table>
        <thead>
        <tr>
            <th>ID người dùng</th>
            <th>Tài khoản</th>
            <th>Mật khẩu</th>
            <th>Quyền</th>
            <th>Dữ liệu</th>
        </tr>
        </thead>
        <tbody class="account-table-body">
        <?php
        try {
            $db = new PDO("sqlite:.\database\database.sqlite");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $db->prepare("SELECT * FROM account");
            $stmt->execute();
            $account = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
        ?>
        <script>
            try {
                var accounts = <?php echo json_encode($account); ?>;
            } catch (error) {
                console.log('Lỗi khi lấy dữ liệu đơn hàng:', error);
                var accounts = [];
            }
            var accountTableBody = document.querySelector('.account-table-body');
            for (var i = 0; i < accounts.length; i++) {
                var account = accounts[i];
                accountTableBody.innerHTML +=
                    `<tr>
                            <td>${account.user_id}</td>
                            <td>${account.username}</td>
                            <td>${account.password}</td>
                            <td>${account.type}</td>
                            <td>${account.data}</td>
                        </tr>`;
            }
        </script>
        </tbody>
    </table>
    <button class="button_delete" id="account-modal-delete-button" onclick="deleteAccount()">Xoá</button>
</div>
<form method="post" action="controller/account.php">
    <div id="account-modal-delete" class="modal">
        <div class="modal-content">
            <span class="account-delete-close">&times;</span>
            <h2>Xoá người dùng</h2>
            <form>
                <div class="form-group">
                    <label for="account-id-delete">ID người dùng</label>
                    <input type="text" id="account-id-delete" name="delete-id" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="account-delete-submit" value="Xoá">
                </div>
            </form>
        </div>
    </div>
</form>
<form method="post" action="controller/account.php">
    <div id="account-modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="account-edit-close">&times;</span>
            <h2>Phân quyền</h2>
            <form>
                <div class="form-group">
                    <label for="account-id-edit">ID người dùng</label>
                    <input type="text" id="account-id-edit" name="edit-id" required tabindex="-1">
                </div>
                <div class="form-group">
                    <label for="account-type">Loại:</label>
                    <select name="type" class="dropdown-menu">
                        <option value="0">Admin</option>
                        <option value="1">User</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" name="account-edit-submit" value="Sửa">
                </div>
            </form>
        </div>
    </div>
</form>
<div class="transport-table" id="transport-table">
    <table>
        <thead>
        <tr>
            <th>Mã đơn vị</th>
            <th>Tên đơn vị</th>
        </tr>
        </thead>
        <tbody class="transport-table-body">
        <?php
        try {
            $db = new PDO("sqlite:.\database\database.sqlite");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $db->prepare("SELECT * FROM transports");
            $stmt->execute();
            $transports = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
        ?>
        <script>
            try {
                var transports = <?php echo json_encode($transports); ?>;
            } catch (error) {
                console.log('Lỗi khi lấy dữ liệu sản phẩm:', error);
                var transports = [];
            }
            var transportTableBody = document.querySelector('.transport-table-body');
            for (var i = 0; i < transports.length; i++) {
                var data = transports[i];
                transportTableBody.innerHTML +=
                    `<tr>
                        <td>${data.id}</td>
                        <td>${data.name}</td>
                    </tr>`;
            }
        </script>
        </tbody>
    </table>
    <button class="button_add" id="transport-add-button" onclick="addTransport()">Thêm</button>
    <button class="button_delete" id="transport-delete-button" onclick="deleteTransport()">Xoá</button>
</div>
<form method="post" action="controller/transport.php">
    <div id="transport-modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="transport-close">&times;</span>
            <h2>Thêm đơn vị vận chuyển</h2>
            <form>
                <div class="form-group">
                    <label for="transport-id">Mã đơn vị vận chuyển</label>
                    <input type="text" id="transport-id" name="id" required>
                </div>
                <div class="form-group">
                    <label for="transport-name">Tên đơn vị vận chuyển:</label>
                    <input type="text" id="transport-name" name="name" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="transport-add-submit" value="Thêm">
                </div>
            </form>
        </div>
    </div>
</form>
<form method="post" action="controller/transport.php">
    <div id="transport-modal-delete" class="modal">
        <div class="modal-content">
            <span class="transport-delete-close">&times;</span>
            <h2>Xoá đơn vị vận chuyển</h2>
            <form>
                <div class="form-group">
                    <label for="transport-id-delete">ID đơn vị vận chuyển</label>
                    <input type="text" id="transport-id-delete" name="delete-id" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="transport-delete-submit" value="Xoá">
                </div>
            </form>
        </div>
    </div>
</form>
<div class="types-table" id="types-table">
    <table>
        <thead>
        <tr>
            <th>Mã loại</th>
            <th>Tên loại</th>
        </tr>
        </thead>
        <tbody class="type-table-body">
        <?php
        try {
            $db = new PDO("sqlite:.\database\database.sqlite");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $db->prepare("SELECT * FROM types");
            $stmt->execute();
            $types = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
        ?>
        <script>
            try {
                var types = <?php echo json_encode($types); ?>;
            } catch (error) {
                console.log('Lỗi khi lấy dữ liệu sản phẩm:', error);
                var types = [];
            }
            var typeTableBody = document.querySelector('.type-table-body');
            for (var i = 0; i < types.length; i++) {
                var data = types[i];
                typeTableBody.innerHTML +=
                    `<tr>
                        <td>${data.id}</td>
                        <td>${data.name}</td>
                    </tr>`;
            }
        </script>
        </tbody>
    </table>
    <button class="button_add" id="type-add-button" onclick="addtype()">Thêm</button>
    <button class="button_delete" id="type-delete-button" onclick="deletetype()">Xoá</button>
</div>
<form method="post" action="controller/type.php">
    <div id="type-modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Thêm danh mục sản phẩm</h2>
            <form>
                <div class="form-group">
                    <label for="type-id">Mã loại:</label>
                    <input type="text" id="type-id" name="id" required>
                </div>
                <div class="form-group">
                    <label for="type-name">Tên loại:</label>
                    <input type="text" id="type-name" name="name" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="type-add-submit" value="Thêm">
                </div>
            </form>
        </div>
    </div>
</form>
<form method="post" action="controller/type.php">
    <div id="type-modal-delete" class="modal">
        <div class="modal-content">
            <span class="type-delete-close">&times;</span>
            <h2>Xoá đơn vị vận chuyển</h2>
            <form>
                <div class="form-group">
                    <label for="type-id-delete">ID loại:</label>
                    <input type="text" id="type-id-delete" name="delete-id" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="type-delete-submit" value="Xoá">
                </div>
            </form>
        </div>
    </div>
</form>
</body>
</html>