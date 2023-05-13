<?php session_start();
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    try{
        $db = new PDO('sqlite:./database/database.sqlite');
        $db->setAttribute(3,2);
        $stmt = $db->prepare('select count(cart_id) as c from cart_detail inner join cart c on cart_detail.cart_id = c.id where c.user_id=:userid');
        $stmt->bindParam(':userid',$user_id);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        if($count){
            $count = $count['c'];
        }else{
            $count = 0;
        }
    }catch (PDOException $exception){
        die($exception->getMessage());
    }
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
    <title>Thanh Toán</title>
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
    <link rel="stylesheet" type="text/css" href="./assets/css/contact.css">
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
        <!-- Menu -->
        <div class="header__nav">
            <ul class="header__nav-list">
                <li class="header__nav-item nav__search">
                    <div class="nav__search-wrap">
                        <input class="nav__search-input" type="text" name="" id="search" placeholder="Tìm sản phẩm...">
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
            <div class="main__breadcrumb">
                <div class="breadcrumb__item">
                    <a href="#" class="breadcrumb__link">Trang chủ</a>
                </div>
                <div class="breadcrumb__item">
                    <a href="#" class="breadcrumb__link">Giới thiệu</a>
                </div>
            </div>
            <div class="row">
               
                <div class="col l-6 m-12 s-12">
                    <div class="contact__wrap">
                        <div class="contact__img">
                            <img src="http://mauweb.monamedia.net/vanihome/wp-content/uploads/2018/04/logo-mona.png" alt="">
                        </div>
                        <ul class="contact__info">
                            <li class="contact__text">
                                <i class="fas fa-map-marked-alt"></i> 58 Ngô Kim Tài, Quán Nam, Kênh Dương, Hải Phòng
                            </li>
                            <li>
                                <a href="tel:076 922 0162" class="contact__link">
                                    <i class="fas fa-phone"></i> 0563620675
                                </a>
                                <a href="tel:076 922 0162" class="contact__link">
                                    &#8212; 0563620675
                                </a>
                            </li>

                            <li>
                                <a href="#" class="contact__link">
                                    <i class="fas fa-envelope"></i> dong92356@st.viamru.edu.vn
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="about-us">
                        <div class="about-us__heading">Liên hệ với chúng tôi</div>
                        <div class="form__group">
                            <div>
                                <input type="text" value="Họ và tên">
                            </div>
                            <div>
                                <input type="text" value="Email">
                            </div>
                            <div>
                                <input type="text" value="Địa chỉ">
                            </div>
                            <div>
                                <input type="text" value="Số điện thoại">
                            </div>
                        </div>
                        <textarea name="" id="" cols="30" rows="5" placeholder="Lời nhắn"></textarea>
                        <button type="submit" class="btn btn--default">Gửi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
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

    <!-- Script common -->
    <script src="./assets/js/commonscript.js"></script>


</body>

</html>