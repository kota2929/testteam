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
	private $products = array();


	public function __construct() {
		//親クラスのコンストラクタを呼ぶ
		parent::__construct();
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief  本体実行（表示前処理）
	@return なし
	*/
	//--------------------------------------------------------------------------------------
	public function execute(){
    global $mysqli;

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // First SQL query to retrieve all products
    $query_products = "SELECT product_id, product_name, product_price FROM products";

    // Execute the first query
    $result_products = $mysqli->query($query_products);

    // Initialize products array
    $this->products = array();

    // Fetch products from the result set
    while ($row = $result_products->fetch_assoc()) {
        $this->products[] = $row;
    }

    // Close the result set for the first query
    $result_products->close();

    // Second SQL query to retrieve top 5 newest items
    $query_newest_items = "SELECT product_id, product_name, product_price FROM products ORDER BY registration_date DESC LIMIT 5";

    // Execute the second query
    $result_newest_items = $mysqli->query($query_newest_items);

    // Initialize newest items array
    $this->newest_items = array();

    // Fetch newest items from the result set
    while ($row = $result_newest_items->fetch_assoc()) {
        $this->newest_items[] = $row;
    }

    // Close the result set for the second query
    $result_newest_items->close();

    // Close the database connection
    $mysqli->close();
}

	//--------------------------------------------------------------------------------------
	/*!
	@brief	構築時の処理(継承して使用)
	@return	なし
	*/
	//--------------------------------------------------------------------------------------
	public function create(){
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief  表示(継承して使用)
	@return なし
	*/
	//--------------------------------------------------------------------------------------
	public function display(){
//PHPブロック終了
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
<?php

// シャッフルする
shuffle($this->products);

// 表示する新着アイテムの数を指定
$display_count = 5; // 例として5つの商品を表示するとします

// 表示する新着アイテムの数だけループを実行
for ($i = 0; $i < $display_count && $i < count($this->products); $i++) {
    // 新着アイテム情報を取得
    $item = $this->products[$i];
    
    // 新着アイテム情報から必要なデータを取得
    $item_name = $item['product_name'];
    $item_price = round($item['product_price']);
    $item_id = $item['product_id'];

    // 新着アイテムのカードのHTMLを出力
    echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">';
    echo '<div class="card-container">';
    echo '<div class="card">';
    echo '<a href="item-detail.php?id=' . $item_id . '" class="card-link">'; // 商品詳細ページへのリンクを追加
    echo '<img src="img/no-image.jpg" alt="' . $item_name . '" class="card-img">';
    echo '<div class="card-content">';
    echo '<h3 class="card-title">' . $item_name . '</h3>';
    echo '<div class="card-info">';
    echo '<p class="card-price">¥' . $item_price . '</p>';
    echo '<button class="favorite-button" onclick="toggleFavorite(event, this)">★</button>';
    echo '</div></div></a></div></div></div>';
}


?>
</div>

<div class="product-introduce-text">
  <h3>新着アイテム </h3>
</div>

<div class="product-card-container row">

  <?php

// 表示する商品の数を指定
// 表示する新着アイテムの数を指定
$display_count = 5; // 例として5つの商品を表示するとします

// 表示する新着アイテムの数だけループを実行
for ($i = 0; $i < $display_count && $i < count($this->newest_items); $i++) {
    // 新着アイテム情報を取得
    $item = $this->newest_items[$i];
    
    // 新着アイテム情報から必要なデータを取得
    $item_name = $item['product_name'];
    $item_price = round($item['product_price']);
    $item_id = $item['product_id'];

    // 新着アイテムのカードのHTMLを出力
    echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">';
    echo '<div class="card-container">';
    echo '<div class="card">';
    echo '<a href="item-detail.php?id=' . $item_id . '" class="card-link">'; // 商品詳細ページへのリンクを追加
    echo '<img src="img/no-image.jpg" alt="' . $item_name . '" class="card-img">';
    echo '<div class="card-content">';
    echo '<h3 class="card-title">' . $item_name . '</h3>';
    echo '<div class="card-info">';
    echo '<p class="card-price">¥' . $item_price . '</p>';
    echo '<button class="favorite-button" onclick="toggleFavorite(event, this)">★</button>';
    echo '</div></div></a></div></div></div>';
}



?>
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
