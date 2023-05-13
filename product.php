<?php
session_start();
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
if(isset($_GET['id'])){
    try {
        $id = $_GET['id'];
        $db = new PDO('sqlite:./database/database.sqlite');
        $stmt = $db->prepare('SELECT * FROM products WHERE id= :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <title>Chi tiêt sản phẩm</title>
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
    <link rel="stylesheet" type="text/css" href="./assets/css/product.css">
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Owl caroucel Js-->
    <script src="assets/owlCarousel/owl.carousel.min.js"></script>

    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css">
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
                        <label>
                            <input type="text" class="header__search-input" placeholder="Tìm kiếm">
                        </label>
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
                    <a href="#" class="header__nav-link">Sản Phẩm</a>
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
        <div class="grid wide" >
            <div class="productInfo" id="product-detail">
            <script>
                try{
                    var product = <?php echo json_encode($product); ?>;
                }catch(error){
                    console.log('Lỗi khi lấy dữ liệu sản phẩm:', error);
                    var product = null;
                }
                var data = product;
                var product = document.createElement('div');
                product.className = 'row';
                product.innerHTML += `
                            <div class="col l-5 m-12 s-12">
                                <div class="product__avt" style="background-image: url(${data.image})">
                                </div>
                            </div>
                            <div class="col l-7 m-12s s-12 pl">
                                <div class="main__breadcrumb">
                                    <div class="breadcrumb__item">
                                        <a href="index.php" class="breadcrumb__link">Trang chủ</a>
                                    </div>
                                    <div class="breadcrumb__item">
                                        <a href="product.php" class="breadcrumb__link">Sản phẩm</a>
                                    </div>
                                </div>
                                <h3 class="productInfo__name">
                                    ${data.name}
                                </h3>
                                <div class="productInfo__price">
                                    ${data.price} <span class="priceInfo__unit">đ</span>
                                </div>
                                <div class="productInfo__description">
                                    <span> ${data.name} </span> ${data.description}
                                </div>

                                <div class="productInfo__addToCart">
                                    <div class="buttons_added">
                                        <input class="minus is-form" type="button" value="-" onclick="minusProduct()">
                                        <input aria-label="quantity" class="input-qty" max="10" min="1" name="" type="number" value="1">
                                        <input class="plus is-form" type="button" value="+" onclick="plusProduct()">
                                    </div>
                                    <div class=" btn btn--default orange ">Thêm vào giỏ</div>
                                </div>
                                <div class="productIndfo__policy ">
                                    <div class="policy bg-1 ">
                                        <img src="./assets/img/policy/policy1.png " class="productIndfo__policy-img "/>
                                        <div class="productIndfo__policy-info ">
                                            <h3 class="productIndfo__policy-title ">Giao hàng miễn phí</h3>
                                            <p class="productIndfo__policy-description ">Cho đơn hàng từ 300K</p>
                                        </div>
                                    </div>
                                    <div class="policy bg-2 ">
                                        <img src="./assets/img/policy/policy2.png " class="productIndfo__policy-img "/>
                                        <div class="productIndfo__policy-info ">
                                            <h3 class="productIndfo__policy-title ">Giao hàng miễn phí</h3>
                                            <p class="productIndfo__policy-description ">Cho đơn hàng từ 300K</p>
                                        </div>
                                    </div>
                                    <div class="policy bg-1 ">
                                        <img src="./assets/img/policy/policy3.png " class="productIndfo__policy-img "></img>
                                        <div class="productIndfo__policy-info ">
                                            <h3 class="productIndfo__policy-title ">Giao hàng miễn phí</h3>
                                            <p class="productIndfo__policy-description ">Cho đơn hàng từ 300K</p>
                                        </div>
                                    </div>
                                    <div class="policy bg-2 ">
                                        <img src="./assets/img/policy/policy4.png " class="productIndfo__policy-img "/>
                                        <div class="productIndfo__policy-info ">
                                            <h3 class="productIndfo__policy-title ">Giao hàng miễn phí</h3>
                                            <p class="productIndfo__policy-description ">Cho đơn hàng từ 300K</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="productIndfo__category ">
                                    <p class="productIndfo__category-text"> Số lượng trong kho : ${data.quantity}</p>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="productDetail ">
                        <div class="main__tabnine ">
                            <div class="grid wide ">
                                <!-- Tab items -->
                                <div class="tabs ">
                                    <div class="tab-item active ">
                                        Mô tả
                                    </div>
                                    <div class="tab-item ">
                                        Đánh giá
                                    </div>
                                    <div class="line "></div>
                                </div>
                                <!-- Tab content -->
                                <div class="tab-content ">
                                    <div class="tab-pane active ">
                                        <div class="productDes ">
                                            <div class="productDes__title ">${data.name} là gì</div>
                                            <p class="productDes__text "> ${data.desc}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="tab-pane ">
                                        <div class="productDes__ratting ">
                                            <div class="productDes__ratting-title ">Đánh giá của bạn</div>
                                            <div class="productDes__ratting-wrap">
                                                <div id="rating">
                                                    <input type="radio" id="star5" name="rating" value="5" />
                                                    <label class="full" for="star5" title="Awesome - 5 stars"></label>

                                                    <input type="radio" id="star4half" name="rating" value="4 and a half" />
                                                    <label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>

                                                    <input type="radio" id="star4" name="rating" value="4" />
                                                    <label class="full" for="star4" title="Pretty good - 4 stars"></label>

                                                    <input type="radio" id="star3half" name="rating" value="3 and a half" />
                                                    <label class="half" for="star3half" title="Meh - 3.5 stars"></label>

                                                    <input type="radio" id="star3" name="rating" value="3" />
                                                    <label class="full" for="star3" title="Meh - 3 stars"></label>

                                                    <input type="radio" id="star2half" name="rating" value="2 and a half" />
                                                    <label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>

                                                    <input type="radio" id="star2" name="rating" value="2" />
                                                    <label class="full" for="star2" title="Kinda bad - 2 stars"></label>

                                                    <input type="radio" id="star1half" name="rating" value="1 and a half" />
                                                    <label class="half" for="star1half" title="Meh - 1.5 stars"></label>

                                                    <input type="radio" id="star1" name="rating" value="1" />
                                                    <label class="full" for="star1" title="Sucks big time - 1 star"></label>

                                                    <input type="radio" id="starhalf" name="rating" value="half" />
                                                    <label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                                </div>
                                                <textarea class="ratecomment" name=" " id=" " cols="30 " rows="1" placeholder="Vui lòng viết đánh giá của bạn "></textarea>
                                            </div>
                                            <input type="submit " class="btn btn--default" value="Đánh giá">
                                        </div>
                                        <ul class="rate__list">
                                            <li class="rate__item">
                                                <div class="rate__info">
                                                    <img src="https://lh3.googleusercontent.com/ogw/ADGmqu9PFgn_rHIm9i3eIlVr5RwzwY2w8EystHF213wj=s32-c-mo" alt="">
                                                    <h3 class="rate__user">Giang Tuấn Phương</h3>
                                                    <div class="rate__star">
                                                        <div class="group-star">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star-half-alt"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="rate__comment">Sản phẩm chất lượng rất tốt thật tuyệt vời</div>
                                            </li>
                                            <li class="rate__item">
                                                <div class="rate__info">
                                                    <img src="https://lh3.googleusercontent.com/ogw/ADGmqu9PFgn_rHIm9i3eIlVr5RwzwY2w8EystHF213wj=s32-c-mo" alt="">
                                                    <h3 class="rate__user">Giang Tuấn Phương</h3>
                                                    <div class="rate__star">

                                                    </div>
                                                </div>
                                                <div class="rate__comment">Sản phẩm chất lượng rất tốt</div>
                                            </li>
                                            <li class="rate__item">
                                                <div class="rate__info">
                                                    <img src="https://lh3.googleusercontent.com/ogw/ADGmqu9PFgn_rHIm9i3eIlVr5RwzwY2w8EystHF213wj=s32-c-mo" alt="">
                                                    <h3 class="rate__user">Giang Tuấn Phương</h3>
                                                    <div class="rate__star">

                                                    </div>
                                                </div>
                                                <div class="rate__comment">Sản phẩm chất lượng rất tốt</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main__frame ">
                        <div class="grid wide ">
                            <h3 class="category__title ">Khánh Duy Cometics</h3>
                            <h3 class="category__heading ">Sản Phẩm Tương tự</h3>
                            <div class="owl-carousel hight owl-theme ">
                                <a href="# " class="product ">
                                    <div class="product__avt " style="background-image: url(assets/img/product/product1.jpg) ">
                                    </div>
                                    <div class="product__info ">
                                        <h3 class="product__name ">Framed-Sleeve Tops Group</h3>
                                        <div class="product__price ">
                                            <div class="price__old ">340.000 <span class="price__unit ">đ</span></div>
                                            <div class="price__new ">320.000 <span class="price__unit ">đ</span></div>
                                        </div>
                                    </div>
                                    <div class="product__sale ">
                                        <span class="product__sale-percent ">22%</span>
                                        <span class="product__sale-text ">Giảm</span>
                                    </div>
                                </a>
                                <a href="# " class="product ">
                                    <div class="product__avt " style="background-image: url(assets/img/product/product1.jpg) ">
                                    </div>
                                    <div class="product__info ">
                                        <h3 class="product__name ">Framed-Sleeve Tops Group</h3>
                                        <div class="product__price ">
                                            <div class="price__old ">340.000 <span class="price__unit ">đ</span></div>
                                            <div class="price__new ">320.000 <span class="price__unit ">đ</span></div>
                                        </div>
                                    </div>
                                    <div class="product__sale ">
                                        <span class="product__sale-percent ">22%</span>
                                        <span class="product__sale-text ">Giảm</span>
                                    </div>
                                </a>
                                <a href="# " class="product ">
                                    <div class="product__avt " style="background-image: url(assets/img/product/product2.jpg) ">
                                    </div>
                                    <div class="product__info ">
                                        <h3 class="product__name ">Framed-Sleeve Tops Group</h3>
                                        <div class="product__price ">
                                            <div class="price__old ">340.000 <span class="price__unit ">đ</span></div>
                                            <div class="price__new ">320.000 <span class="price__unit ">đ</span></div>
                                        </div>
                                    </div>
                                    <div class="product__sale ">
                                        <span class="product__sale-percent ">22%</span>
                                        <span class="product__sale-text ">Giảm</span>
                                    </div>
                                </a>
                                <a href="# " class="product ">
                                    <div class="product__avt " style="background-image: url(assets/img/product/product3.jpg) ">
                                    </div>
                                    <div class="product__info ">
                                        <h3 class="product__name ">Framed-Sleeve Tops Group</h3>
                                        <div class="product__price ">
                                            <div class="price__new ">320.000 <span class="price__unit ">đ</span></div>
                                        </div>
                                    </div>
                                    <div class="product__sale ">
                                        <span class="product__sale-percent ">22%</span>
                                        <span class="product__sale-text ">Giảm</span>
                                    </div>
                                </a>
                                <a href="# " class="product ">
                                    <div class="product__avt " style="background-image: url(assets/img/product/product4.jpg) ">
                                    </div>
                                    <div class="product__info ">
                                        <h3 class="product__name ">Framed-Sleeve Tops Group</h3>
                                        <div class="product__price ">
                                            <div class="price__old ">340.000 <span class="price__unit ">đ</span></div>
                                            <div class="price__new ">320.000 <span class="price__unit ">đ</span></div>
                                        </div>
                                    </div>
                                    <div class="product__sale ">
                                        <span class="product__sale-percent ">22%</span>
                                        <span class="product__sale-text ">Giảm</span>
                                    </div>
                                </a>
                                <a href="# " class="product ">
                                    <div class="product__avt " style="background-image: url(assets/img/product/product5.jpg) ">
                                    </div>
                                    <div class="product__info ">
                                        <h3 class="product__name ">Framed-Sleeve Tops Group</h3>
                                        <div class="product__price ">
                                            <div class="price__old ">340.000 <span class="price__unit ">đ</span></div>
                                            <div class="price__new ">320.000 <span class="price__unit ">đ</span></div>
                                        </div>
                                    </div>
                                    <div class="product__sale ">
                                        <span class="product__sale-percent ">22%</span>
                                        <span class="product__sale-text ">Giảm</span>
                                    </div>
                                </a>
                                <a href="# " class="product ">
                                    <div class="product__avt " style="background-image: url(assets/img/product/product6.jpg) ">
                                    </div>
                                    <div class="product__info ">
                                        <h3 class="product__name ">Framed-Sleeve Tops Group</h3>
                                        <div class="product__price ">
                                            <div class="price__old ">340.000 <span class="price__unit ">đ</span></div>
                                            <div class="price__new ">320.000 <span class="price__unit ">đ</span></div>
                                        </div>
                                    </div>
                                    <div class="product__sale ">
                                        <span class="product__sale-percent ">22%</span>
                                        <span class="product__sale-text ">Giảm</span>
                                    </div>
                                </a>
                                <a href="# " class="product ">
                                    <div class="product__avt " style="background-image: url(assets/img/product/product4.jpg) ">
                                    </div>
                                    <div class="product__info ">
                                        <h3 class="product__name ">Framed-Sleeve Tops Group</h3>
                                        <div class="product__price ">
                                            <div class="price__old ">340.000 <span class="price__unit ">đ</span></div>
                                            <div class="price__new ">320.000 <span class="price__unit ">đ</span></div>
                                        </div>
                                    </div>
                                    <div class="product__sale ">
                                        <span class="product__sale-percent ">22%</span>
                                        <span class="product__sale-text ">Giảm</span>
                                    </div>
                                </a>
                                <a href="# " class="product ">
                                    <div class="product__avt " style="background-image: url(assets/img/product/product6.jpg) ">
                                    </div>
                                    <div class="product__info ">
                                        <h3 class="product__name ">Framed-Sleeve Tops Group</h3>
                                        <div class="product__price ">
                                            <div class="price__old ">340.000 <span class="price__unit ">đ</span></div>
                                            <div class="price__new ">320.000 <span class="price__unit ">đ</span></div>
                                        </div>
                                    </div>
                                    <div class="product__sale ">
                                        <span class="product__sale-percent ">22%</span>
                                        <span class="product__sale-text ">Giảm</span>
                                    </div>
                                </a>
                                <a href="# " class="product ">
                                    <div class="product__avt " style="background-image: url(assets/img/product/product1.jpg) ">
                                    </div>
                                    <div class="product__info ">
                                        <h3 class="product__name ">Framed-Sleeve Tops Group</h3>
                                        <div class="product__price ">
                                            <div class="price__old ">340.000 <span class="price__unit ">đ</span></div>
                                            <div class="price__new ">320.000 <span class="price__unit ">đ</span></div>
                                        </div>
                                    </div>
                                    <div class="product__sale ">
                                        <span class="product__sale-percent ">22%</span>
                                        <span class="product__sale-text ">Giảm</span>
                                    </div>
                                </a>
                                <a href="# " class="product ">
                                    <div class="product__avt " style="background-image: url(assets/img/product/product4.jpg) ">
                                    </div>
                                    <div class="product__info ">
                                        <h3 class="product__name ">Framed-Sleeve Tops Group</h3>
                                        <div class="product__price ">
                                            <div class="price__old ">340.000 <span class="price__unit ">đ</span></div>
                                            <div class="price__new ">320.000 <span class="price__unit ">đ</span></div>
                                        </div>
                                    </div>
                                    <div class="product__sale ">
                                        <span class="product__sale-percent ">22%</span>
                                        <span class="product__sale-text ">Giảm</span>
                                    </div>
                                </a>
                            </div>`;
                document.getElementById('product-detail').appendChild(product);
                function plusProduct() {
                    var inputQty = document.querySelector('.input-qty');
                    var qty = parseInt(inputQty.value);
                    if (qty < 10) {
                        inputQty.value = qty + 1;
                    }
                }

                function minusProduct() {
                    var inputQty = document.querySelector('.input-qty');
                    var qty = parseInt(inputQty.value);
                    if (qty > 1) {
                        inputQty.value = qty - 1;
                    }
                }

            </script>
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
    <!-- Messenger Plugin chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin chat code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "105913298384666");
        chatbox.setAttribute("attribution", "biz_inbox");
        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v10.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <script>
        $(document).ready(function() {
            var sync1 = $("#sync1 ");
            var sync2 = $("#sync2 ");
            var slidesPerPage = 4;
            var syncedSecondary = true;
            sync1.owlCarousel({
                items: 1,
                loop: true,
                margin: 20,
                nav: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: true
            })
            sync2
                .on('initialized.owl.carousel', function() {
                    sync2.find(".owl-item ").eq(0).addClass("current ");
                })
                .owlCarousel({
                    items: 4,
                    dots: false,
                    nav: false,
                    margin: 30,
                    smartSpeed: 200,
                    slideSpeed: 500,
                    slideBy: 4,
                    responsiveRefreshRate: 100
                }).on('changed.owl.carousel', syncPosition2);

            function syncPosition(el) {
                var count = el.item.count - 1;
                var current = Math.round(el.item.index - (el.item.count / 2) - .5);

                if (current < 0) {
                    current = count;
                }
                if (current > count)  {
                    current = 0;
                }

                //end block

                sync2
                    .find(".owl-item ")
                    .removeClass("current ")
                    .eq(current)
                    .addClass("current ");
                var onscreen = sync2.find('.owl-item.active').length - 1;
                var start = sync2.find('.owl-item.active').first().index();
                var end = sync2.find('.owl-item.active').last().index();

                if (current > end) {
                    sync2.data('owl.carousel').to(current, 100, true);
                }
                if (current < start) {
                    sync2.data('owl.carousel').to(current - onscreen, 100, true);
                }
            }

            function syncPosition2(el) {
                if (syncedSecondary) {
                    var number = el.item.index;
                    sync1.data('owl.carousel').to(number, 100, true);
                }
            }

            sync2.on("click ", ".owl-item ", function(e) {
                e.preventDefault();
                var number = $(this).index();
                sync1.data('owl.carousel').to(number, 300, true);
            });
        });

        $('.owl-carousel.hight').owlCarousel({
            loop: true,
            margin: 20,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 6
                }
            }
        })
    </script>

    <!-- Script common -->
    <script src="./assets/js/commonscript.js ">
    </script>
    <script>
        function calcRate(r) {
            const f = ~~r, //Tương tự Math.floor(r)
                id = 'star' + f + (r % f ? 'half' : '')
            id && (document.getElementById(id).checked = !0)
        }
    </script>

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
</body>

</html>