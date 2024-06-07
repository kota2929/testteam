    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/item-home.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">


<?php
// PHP ブロック開始

//ライブラリをインクルード
require_once("common/libs.php");

$err_array = array();
$err_flag = 0;
$page_obj = null;

class cmain_node extends cnode {
    public function __construct() {
        parent::__construct();
    }

    public function execute() {
    }

    public function create() {
    }

    public function display() {
?>
<!-- コンテンツ -->
<div class="contents">
<main class="container">

<div>
  <ul class="slider">
    <li><img src="img/IMG_5450.JPG" alt=""></li>
    <li><img src="img/IMG_5450.JPG" alt=""></li>
    <li><img src="img/IMG_5450.JPG" alt=""></li>
    <li><img src="img/IMG_5450.JPG" alt=""></li>
    <li><img src="img/IMG_5450.JPG" alt=""></li>
    <!--/slider-->
  </ul>
</div>

<section>
  <nav class="custom-nav">
    <ul>
      <li><a href="#">Genre</a>
        <ul>
          <li><a href="#">きれいめ</a></li>
          <li><a href="#">カジュアル</a></li>
          <li><a href="#">ストリート</a></li>
        </ul>
      </li>
      <li><a href="#">Season</a>
        <ul>
          <li><a href="#">春</a></li>
          <li><a href="#">夏</a></li>
          <li><a href="#">秋</a></li>
          <li><a href="#">冬</a></li>
        </ul>
      </li>
      <li><a href="#">Color</a>
        <ul>
          <li><a href="#">白</a></li>
          <li><a href="#">黒</a></li>
          <li><a href="#">グレー</a></li>
          <li><a href="#">緑</a></li>
        </ul>
      </li>
    </ul>
  </nav>
</section>


<div class="product-introduce-text">
  <h3>人気のおすすめアイテム</h3>
</div>
<div class="product-card-container row">

  <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card-container">
      <div class="card">
        <a href="" class="card-link">
          <img src="img/no-image.jpg" alt="商品名" class="card-img">
          <div class="card-content">
            <h3 class="card-title">かっこいい服</h3>
            <div class="card-info">
              <p class="card-price">¥20,000</p>
              <button class="favorite-button" onclick="toggleFavorite(event, this)">★</button>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card-container">
      <div class="card">
        <a href="" class="card-link">
          <img src="img/no-image.jpg" alt="商品名" class="card-img">
          <div class="card-content">
            <h3 class="card-title">かっこいい服</h3>
            <div class="card-info">
              <p class="card-price">¥20,000</p>
              <button class="favorite-button" onclick="toggleFavorite(event, this)">★</button>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card-container">
      <div class="card">
        <a href="" class="card-link">
          <img src="img/no-image.jpg" alt="商品名" class="card-img">
          <div class="card-content">
            <h3 class="card-title">かっこいい服</h3>
            <div class="card-info">
              <p class="card-price">¥20,000</p>
              <button class="favorite-button" onclick="toggleFavorite(event, this)">★</button>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card-container">
      <div class="card">
        <a href="商品ページURL" class="card-link">
          <img src="img/no-image.jpg" alt="商品名" class="card-img">
          <div class="card-content">
            <h3 class="card-title">かっこいい服</h3>
            <div class="card-info">
              <p class="card-price">¥20,000</p>
              <button class="favorite-button" onclick="toggleFavorite(event, this)">★</button>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card-container">
      <div class="card">
        <a href="" class="card-link">
          <img src="img/no-image.jpg" alt="商品名" class="card-img">
          <div class="card-content">
            <h3 class="card-title">かっこいい服</h3>
            <div class="card-info">
              <p class="card-price">¥20,000</p>
              <button class="favorite-button" onclick="toggleFavorite(event, this)">★</button>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card-container">
      <div class="card">
        <a href="" class="card-link">
          <img src="img/no-image.jpg" alt="商品名" class="card-img">
          <div class="card-content">
            <h3 class="card-title">かっこいい服</h3>
            <div class="card-info">
              <p class="card-price">¥20,000</p>
              <button class="favorite-button" onclick="toggleFavorite(event, this)">★</button>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>

</div>

<div class="product-introduce-text">
  <h3>新着アイテム </h3>
</div>

<div class="product-card-container row">

  <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card-container">
      <div class="card">
        <a href="" class="card-link">
          <img src="img/no-image.jpg" alt="商品名" class="card-img">
          <div class="card-content">
            <h3 class="card-title">かっこいい服</h3>
            <div class="card-info">
              <p class="card-price">¥20,000</p>
              <button class="favorite-button" onclick="toggleFavorite(event, this)">★</button>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card-container">
      <div class="card">
        <a href="" class="card-link">
          <img src="img/no-image.jpg" alt="商品名" class="card-img">
          <div class="card-content">
            <h3 class="card-title">かっこいい服</h3>
            <div class="card-info">
              <p class="card-price">¥20,000</p>
              <button class="favorite-button" onclick="toggleFavorite(event, this)">★</button>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card-container">
      <div class="card">
        <a href="" class="card-link">
          <img src="img/no-image.jpg" alt="商品名" class="card-img">
          <div class="card-content">
            <h3 class="card-title">かっこいい服</h3>
            <div class="card-info">
              <p class="card-price">¥20,000</p>
              <button class="favorite-button" onclick="toggleFavorite(event, this)">★</button>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card-container">
      <div class="card">
        <a href="" class="card-link">
          <img src="img/no-image.jpg" alt="商品名" class="card-img">
          <div class="card-content">
            <h3 class="card-title">かっこいい服</h3>
            <div class="card-info">
              <p class="card-price">¥20,000</p>
              <button class="favorite-button" onclick="toggleFavorite(event, this)">★</button>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card-container">
      <div class="card">
        <a href="" class="card-link">
          <img src="img/no-image.jpg" alt="商品名" class="card-img">
          <div class="card-content">
            <h3 class="card-title">かっこいい服</h3>
            <div class="card-info">
              <p class="card-price">¥20,000</p>
              <button class="favorite-button" onclick="toggleFavorite(event, this)">★</button>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card-container">
      <div class="card">
        <a href="" class="card-link">
          <img src="img/no-image.jpg" alt="商品名" class="card-img">
          <div class="card-content">
            <h3 class="card-title">かっこいい服</h3>
            <div class="card-info">
              <p class="card-price">¥20,000</p>
              <button class="favorite-button" onclick="toggleFavorite(event, this)">★</button>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>

</div>
</div>
<!-- /コンテンツ -->

<?php
    }

    public function __destruct() {
        parent::__destruct();
    }
}

$page_obj = new cnode();
$page_obj->add_child(cutil::create('cheader'));
$page_obj->add_child($main_obj = cutil::create('cmain_node'));
$page_obj->add_child(cutil::create('cfooter'));
$page_obj->create();
$main_obj->execute();
$page_obj->display();

?>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="js/home.js"></script>

</body>
</html>
