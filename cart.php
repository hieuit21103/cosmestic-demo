<?php
session_start();
if(isset($_GET['user_id'])){
    $user_id = $_GET['user_id'];
    $db = new PDO('sqlite:./database/database.sqlite');
    $db->setAttribute(3,2);
    $stmt = $db->prepare('SELECT cart_id, p.id,p.image, name, price, cart_detail.quantity FROM cart INNER JOIN cart_detail on cart.id = cart_detail.cart_id INNER JOIN products p on cart_detail.product_id = p.id WHERE user_id=:user_id');
    $stmt->bindParam(':user_id',$user_id);
    $stmt->execute();
    $carts = $stmt->fetchALl(PDO::FETCH_ASSOC);
    $stmt = $db->prepare('select count(cart_id) as count from cart inner join cart_detail c on cart.id = c.cart_id where cart.user_id=:user_id');
    $stmt->bindParam(':user_id',$user_id);
    $stmt->execute();
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    if($count){
        $count = $count['count'];
    }else{
        $count = 0;
    }
}else{
    header('Location: #my-Login');
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- https://cocoshop.vn/ -->
<!-- http://mauweb.monamedia.net/vanihome/ -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <!-- Font roboto -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Icon fontanwesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- Reset css & grid sytem -->
    <link rel="stylesheet" href="./assets/css/library.css">
    <!-- Owl Slider css -->
    <link rel="stylesheet" href="assets/owlCarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/owlCarousel/assets/owl.theme.default.min.css">
    <!-- Layout -->
    <link rel="stylesheet" href="./assets/css/common.css">
    <!-- index -->
    <link rel="stylesheet" type="text/css" href="./assets/css/cart.css">
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Owl caroucel Js-->
    <script src="assets/owlCarousel/owl.carousel.min.js"></script>
</head>

<body>
    <div class="header scrolling" id="myHeader">
        <div class="grid wide">
            <div class="header__top">
                <div class="navbar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <a href="index.php" class="header__logo">
                    <img src="./assets/logo.png" alt="">
                </a>
                <div class="header__search">
                    <div class="header__search-wrap">
                        <input type="text" class="header__search-input" placeholder="Tìm kiếm">
                        <a class="header__search-icon" href="#">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>
                <div class="header__account">
                    <?php
                    if(isset($_SESSION['username'])){
                        $username = $_SESSION['username'];
                        ?>
                        <form method="post" action="controller/logout.php">
                            <a href="#my-Profile" class="name-user"><?php echo "Xin chào ".$username." "; ?></a>
                            <button name="logout-button" style="font-size: 1.6rem; color: var(--black-cl-1); border: none; background-color: transparent">Đăng xuất</button>
                        </form>
                        <?php
                    } else {
                        ?>
                        <a href="#my-Login" class="header__account-login">Đăng Nhập</a>
                        <a href="#my-Register" class="header__account-register">Đăng Kí</a>
                    <?php } ?>
                </div>
                <!-- Cart -->
                <div class="header__cart have">
                    <a href="cart.php?user_id=<?php echo $user_id?>" class="fas fa-shopping-basket" style="font-size: 32px;"></a>
                    <div class="header__cart-amount">
                        <?php if(isset($count)){
                            echo $count;
                        }; ?>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- Menu -->
        <div class="header__nav">
            <ul class="header__nav-list">
                <li class="header__nav-item nav__search">
                    <div class="nav__search-wrap">
                        <input class="nav__search-input" type="text" name="" id="" placeholder="Tìm sản phẩm...">
                    </div>
                    <div class="nav__search-btn">
                        <i class="fas fa-search"></i>
                    </div>
                </li>
                <li class="header__nav-item authen-form">
                    <a href="#" class="header__nav-link">Tài Khoản</a>
                    <ul class="sub-nav">
                        <li class="sub-nav__item">
                            <a href="#my-Login" class="sub-nav__link">Đăng Nhập</a>
                        </li>
                        <li class="sub-nav__item">
                            <a href="#my-Register" class="sub-nav__link">Đăng Kí</a>
                        </li>
                    </ul>
                </li>
                <li class="header__nav-item index">
                    <a href="index.php" class="header__nav-link">Trang chủ</a>
                </li>
                <li class="header__nav-item">
                    <a href="#" class="header__nav-link">Giới Thiệu</a>
                </li>
                <li class="header__nav-item">
                    <a href="listProduct.php" class="header__nav-link">Sản Phẩm</a>
                    <div class="sub-nav-wrap grid wide">
                        <ul class="sub-nav">
                            <li class="sub-nav__item">
                                <a href="" class="sub-nav__link heading">Nước hoa</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Chăm sóc toàn thân vvv</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Khuyến mãi</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Chăm sóc cơ thể</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Nước hoa</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Chăm sóc miệng</a>
                            </li>
                        </ul>
                        <ul class="sub-nav">
                            <li class="sub-nav__item">
                                <a href="" class="sub-nav__link heading">Nước hoa</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Chăm sóc toàn thân vvv</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Khuyến mãi</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Chăm sóc cơ thể</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Nước hoa</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Chăm sóc miệng</a>
                            </li>
                        </ul>
                        <ul class="sub-nav">
                            <li class="sub-nav__item">
                                <a href="" class="sub-nav__link heading">Nước hoa</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Chăm sóc toàn thân vvv</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Khuyến mãi</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Chăm sóc cơ thể</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Nước hoa</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Chăm sóc miệng</a>
                            </li>
                        </ul>
                        <ul class="sub-nav">
                            <li class="sub-nav__item">
                                <a href="" class="sub-nav__link heading">Nước hoa</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Chăm sóc toàn thân vvv</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Khuyến mãi</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Chăm sóc cơ thể</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Nước hoa</a>
                            </li>
                            <li class="sub-nav__item">
                                <a href="listProduct.php" class="sub-nav__link">Chăm sóc miệng</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="header__nav-item">
                    <a href="news.php" class="header__nav-link">Tin Tức</a>
                </li>
                <li class="header__nav-item">
                    <a href="contact.php" class="header__nav-link">Liên Hệ</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main">
        <div class="grid wide">
            <h3 class="main__notify" style="display: none;">
                <div class="main__notify-icon">
                    <i class="fas fa-check"></i>
                    <!-- <i class="fas fa-times"></i> -->
                </div>
                <div class="main__notify-text">Đặt hàng thành công</div>
            </h3>
        <div class="row">
                <div class="col l-8 m-12 s-12">
                    <div class="main__cart" id="cart-item">
                        <div class="row title">
                            <div class="col l-4 m-4 s-8">Sản phẩm</div>
                            <div class="col l-2 m-2 s-0">Giá</div>
                            <div class="col l-2 m-2 s-0">Số lượng</div>
                            <div class="col l-2 m-2 s-4">Tổng</div>
                            <div class="col l-1 m-1 s-0">Xóa</div>
                        </div>
                        <script>
                            try{
                                carts = <?php echo json_encode($carts); ?>;
                            }catch (error){
                                carts = [];
                            }
                            console.log(carts);
                            for(var i = 0;i < carts.length;i++){
                                data=carts[i];
                                var quantity = data.quantity;
                                var product = document.createElement('div');
                                var total = quantity*data.price;
                                product.className = 'row item';
                                product.setAttribute('data-id', data.id);
                                product.innerHTML+=
                                                `
                                                </div>
                                                <div class="col l-4 m-4 s-8">
                                                    <div class="main__cart-product">
                                                        <img src=${data.image} alt="">
                                                        <div class="name">${data.name}</div>
                                                    </div>
                                                </div>
                                                <div class="col l-2 m-2 s-0">
                                                    <div class="main__cart-price">${parseInt(data.price)}</div>
                                                </div>
                                                <div class="col l-2 m-2 s-0">
                                                    <div class="buttons_added" id="buttons_added-${data.id}">
                                                        <input class="minus is-form" type="button" value="-" onclick="createMinusProductFunction(${data.id},${data.id})(); createPriceProductFunction(${data.id},${data.price})()">-
                                                        <input aria-label="quantity" class="input-qty" max="10" min="1" id="quantity-${data.id}" name="quantity" type="number" value="${data.quantity}">
                                                        <input class="plus is-form" type="button" value="+" onclick="createPlusProductFunction(${data.id},${data.id})(); createPriceProductFunction(${data.id},${data.price})()">
                                                    </div>
                                                </div>
                                                <div class="col l-2 m-2 s-4">
                                                    <div class="main__cart-price-1" id="total-price-${data.id}">${total}</div>
                                                </div>
                                                <div class="col l-1 m-1 s-0">
                                                    <span class="main__cart-icon">
                                                    <i class="far fa-times-circle " onclick=""></i>
                                                </span>
                                                </div>
                            `;

                                document.getElementById('cart-item').appendChild(product);
                            }
                        </script>
                        <div class="btn btn--default">
                            Cập nhật giỏ hàng
                        </div>
                    </div>
                </div>
                <div class="col l-4 m-12 s-12">
                    <div class="main__pay">
                        <div class="main__pay-title">Tổng</div>
                        <div class="pay-info">
                            <div class="main__pay-text">
                                Tổng phụ</div>
                            <div class="main__pay-price">
                            </div>
                        </div>
                        <div class="pay-info">
                            <div class="main__pay-text">
                                Giao hàng
                            </div>
                            <div class="main__pay-text">
                                Trả tiền khi nhận hàng
                            </div>

                        </div>
                        <div class="pay-info">
                            <div class="main__pay-text">
                                Tổng thành tiền</div>
                            <div class="main__pay-price" id="total-paid">
                            </div>
                        </div>
                        <div id="pay">
                            <a href="cart_success.php?user_id=<?php echo $user_id;?>" class="btn btn--default orange" type="submit" onclick="showNotify()">Thanh toán</a>
                        </div>
                        <div class="main__pay-title">Phiếu ưu đãi</div>
                        <input type="text" class="form-control">
                        <div class="btn btn--default">Áp dụng</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--footer-->
    <div class="footer">
        <div class="grid wide">
            <div class="row">
                <div class="col l-3 m-6 s-12">
                    <h3 class="footer__title">Menu</h3>
                    <ul class="footer__list">
                        <li class="footer__item">
                            <a href="#" class="footer__link">Trang điểm</a>
                        </li>
                        <li class="footer__item">
                            <a href="#" class="footer__link">Chăm sóc da</a>
                        </li>
                        <li class="footer__item">
                            <a href="#" class="footer__link">Chăm sóc tóc</a>
                        </li>
                        <li class="footer__item">
                            <a href="#" class="footer__link">Nước hoa</a>
                        </li>
                        <li class="footer__item">
                            <a href="#" class="footer__link">Chăm sóc toàn thân </a>
                        </li>
                    </ul>
                </div>
                <div class="col l-3 m-6 s-12">
                    <h3 class="footer__title">Hỗ trợ khách hàng</h3>
                    <ul class="footer__list">
                        <li class="footer__item">
                            <a href="#" class="footer__link">Hướng dẫn mua hàng</a>
                        </li>
                        <li class="footer__item">
                            <a href="#" class="footer__link">Giải đáp thắc mắc</a>
                        </li>
                        <li class="footer__item">
                            <a href="#" class="footer__link">Chính sách mua hàng</a>
                        </li>
                        <li class="footer__item">
                            <a href="#" class="footer__link">Chính sách đổi trả</a>
                        </li>
                    </ul>
                </div>
                <div class="col l-3 m-6 s-12">
                    <h3 class="footer__title">Liên hệ</h3>
                    <ul class="footer__list">
                        <li class="footer__item">
                            <span class="footer__text">
                                    <i class="fas fa-map-marked-alt"></i> 58 Ngô Kim Tài, Quán Nam, Kênh Dương, Lê Chân, Hải Phòng
                                </span>
                        </li>
                        <li class="footer__item">
                            <a href="#" class="footer__link">
                                <i class="fas fa-phone"></i> 0563620675
                            </a>
                        </li>
                        <li class="footer__item">
                            <a href="#" class="footer__link">
                                <i class="fas fa-envelope"></i> dong92356@st.vimaru.edu.vn
                            </a>
                        </li>
                        <li class="footer__item">
                            <div class="social-group">
                                <a href="#" class="social-item"><i class="fab fa-facebook-f"></i>
                                    </a>
                                <a href="#" class="social-item"><i class="fab fa-twitter"></i>
                                    </a>
                                <a href="#" class="social-item"><i class="fab fa-pinterest-p"></i>
                                    </a>
                                <a href="#" class="social-item"><i class="fab fa-invision"></i>
                                    </a>
                                <a href="#" class="social-item"><i class="fab fa-youtube"></i>  
                                    </a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col l-3 m-6 s-12">
                    <h3 class="footer__title">Đăng kí</h3>
                    <ul class="footer__list">
                        <li class="footer__item">
                            <span class="footer__text">Đăng ký để nhận được được thông tin ưu đãi mới nhất từ chúng tôi.</span>
                        </li>
                        <li class="footer__item">
                            <div class="send-email">
                                <input class="send-email__input" type="email" placeholder="Nhập Email...">
                                <a href="#" class="send-email__link">
                                    <i class="fas fa-paper-plane"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="copyright">
            <span class="footer__text"> &copy Bản quyền thuộc về <a class="footer__link" href="#"> WanDon</a></span>
        </div>
    </div>
    <!-- Modal Form -->
    <div class="ModalForm">
        <form method="post" action="controller/register.php">
            <div class="modal" id="my-Register">
                <a href="#" class="overlay-close"></a>
                <div class="authen-modal register">
                    <h3 class="authen-modal__title">Đăng Kí</h3>
                    <div class="form-group">
                        <label for="fullname" class="form-label">Họ và tên*</label>
                        <input id="fullname" name="name" type="text" class="form-control" required>
                        <span class="form-message"></span>
                    </div>
                    <div class="form-group">
                        <label for=phone-number class="form-label">Số điện thoại*</label>
                        <input id="phone-number" name="phone-number" type="number" class="form-control" required>
                        <span class="form-message"></span>
                    </div>
                    <div class="form-group">
                        <label for="address" class="form-label">Địa chỉ*</label>
                        <input id="address" name="address" type="text" class="form-control" required>
                        <span class="form-message"></span>
                    </div>
                    <div class="form-group">
                        <label for="username" class="form-label">Tài khoản</label>
                        <input id="username" name="username" type="text" class="form-control" required>
                        <span class="form-message"></span>
                    </div>
                    <div class="form-group">
                        <label for="reg-password" class="form-label">Mật khẩu *</label>
                        <input id="reg-password" name="password" type="password" class="form-control" required>
                        <span class="form-message"></span>
                    </div>
                    <div class="form-group">
                        <label for="re-password" class="form-label">Nhập lại mật khẩu *</label>
                        <input id="re-password" name="re-password" type="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <span class="form-message">
                            <?php
                            if(isset($_SESSION['register-error'])){
                                echo $_SESSION['register-error'];
                                unset($_SESSION['register-error']);
                            }
                            ?>
                        </span>
                    </div>
                    <div class="authen__btns">
                        <div>
                            <button class="btn btn--default" type="submit">Đăng kí</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form method="post" action="controller/login.php">
            <div class="modal" id="my-Login">
                <a href="#" class="overlay-close"></a>
                <div class="authen-modal login">
                    <h3 class="authen-modal__title">Đăng Nhập</h3>
                    <div class="form-group">
                        <label for="username-input" class="form-label">Tài khoản *</label>
                        <input id="username-input" name="username" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password-input" class="form-label">Mật khẩu *</label>
                        <input id="password-input" name="password" type="password" class="form-control">
                        <span class="form-message">
                            <?php
                            if(isset($_SESSION['login-error'])){
                                echo $_SESSION['login-error'];
                                unset($_SESSION['login-error']);
                            }
                            ?>
                        </span>
                        <div class="authen__btns">
                            <div>
                                <input type="submit" class="btn btn--default" id="login-button" name="login-button" value="Đăng nhập">
                            </div>
                            <input type="checkbox" class="authen-checkbox">
                            <label class="form-label">Ghi nhớ mật khẩu</label>
                        </div>
                        <a class="authen__link">Quên mật khẩu ?</a>
                    </div>
                </div>
        </form>
        <div class="up-top" id="upTop" onclick="goToTop()">
            <i class="fas fa-chevron-up"></i>
        </div>

    </div>
    <!-- Sccipt for owl caroucel -->
    <script>
        function createMinusProductFunction(id,productId) {
            return function() {
                minusProduct(id,productId);
            }
        }

        function createPlusProductFunction(id,productId) {
            return function() {
                plusProduct(id,productId);
            }
        }

        function createPriceProductFunction(productId,price){
            return function (){
                setPrice(productId,price);
            }
        }
        var bid;
        function minusProduct(id,productId) {
            // Cập nhật giá trị hiển thị
            var inputQty = document.getElementById(`quantity-${id}`);
            const product = document.querySelector(`.row.item[data-id="${id}"]`);
            const priceElem = product.querySelector('.main__cart-price-1');
            const price = parseInt(priceElem.textContent);
            const qtyElem = product.querySelector('.input-qty');
            var qty = parseInt(qtyElem.value);
            const newPrice = price * (qty - 1);
            priceElem.textContent = newPrice;
            qty = parseInt(inputQty.value);
            if (qty > 1) {
                inputQty.value = qty - 1;
            }
            bid=productId;
            updateTotalPrice();
        }

        function plusProduct(id,productId) {
            // Cập nhật giá trị hiển thị
            var inputQty = document.getElementById(`quantity-${id}`);
            const product = document.querySelector(`.row.item[data-id="${id}"]`);
            const priceElem = product.querySelector('.main__cart-price-1');
            const price = parseInt(priceElem.textContent);
            const qtyElem = product.querySelector('.input-qty');
            var qty = parseInt(qtyElem.value);
            const newPrice = price * (qty + 1);
            priceElem.textContent = newPrice;
            qty = parseInt(inputQty.value);
            if (qty < 10) {
                inputQty.value = qty + 1;
            }
            bid=productId;
            updateTotalPrice();
        }
        function updateTotalPrice() {
            var products = document.querySelectorAll('.row.item');
            var totalPrice = 0;
            for (var i = 0; i < products.length; i++) {
                var product = products[i];
                var priceElem = product.querySelector('.main__cart-price');
                var price = parseInt(priceElem.textContent);
                var qtyElem = product.querySelector('.input-qty');
                var qty = parseInt(qtyElem.value);
                totalPrice += price*qty;
            }
            var totalPriceElem = document.querySelector('.main__pay-price');
            totalPriceElem.textContent = totalPrice;
        }

        function setPrice(count,price) {
            var quantity = document.getElementById(`quantity-${count}`).value;
            var totalPrice = document.getElementById(`total-price-${count}`);
            price = price * quantity;
            totalPrice.textContent = price;
        }
        function showNotify() {
            console.log(count);
            if(count > 0){
                var notify = document.querySelector('.main__notify');
                notify.style.display = 'flex';
            }
        }
    </script>
    <!-- Script common -->
    <script src="./assets/js/commonscript.js"></script>


</body>

</html>