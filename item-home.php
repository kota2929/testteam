<link rel="stylesheet" href="css/item-home.css">
<link rel="stylesheet" href="css/item-index.css">
<?php
/*!
@file hinagata.php
@brief ページ作成の雛形ファイル
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

//ライブラリをインクルード
require_once("common/libs.php");

$err_array = array();
$err_flag = 0;
$page_obj = null;


//--------------------------------------------------------------------------------------
///	本体ノード
//--------------------------------------------------------------------------------------
class cmain_node extends cnode {
	//--------------------------------------------------------------------------------------
	/*!
	@brief	コンストラクタ
	*/
	//--------------------------------------------------------------------------------------
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
    <main class="container">
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

      <div class="product-card-container row">

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

        </div>

        <!-- Repeat similar blocks for more products -->

      </div>
    </main>
<?php 
//PHPブロック再開
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	デストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __destruct(){
		//親クラスのデストラクタを呼ぶ
		parent::__destruct();
	}
}

//ページを作成
$page_obj = new cnode();
//ヘッダ追加
$page_obj->add_child(cutil::create('cheader'));
//本体追加
$page_obj->add_child($main_obj = cutil::create('cmain_node'));
//フッタ追加
$page_obj->add_child(cutil::create('cfooter'));
//構築時処理
$page_obj->create();
//本体実行（表示前処理）
$main_obj->execute();
//ページ全体を表示
$page_obj->display();

?>
