<link rel="stylesheet" href="css/item-detail.css">
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
<!-- コンテンツ　-->
    <!-- コンテンツ -->
    <main class="container my-5">
      <div class="row">
        <div class="col-md-6">
          <img src="img/no-image.jpg" id="mainImage" class="product-image img-zone" alt="商品画像">
          <div class="mt-3 img-zone">
            <img src="img/no-image.jpg" class="img-thumbnail thumb-image" alt="商品画像サムネイル1">
            <img src="img\jiji.jpg" class="img-thumbnail thumb-image" alt="商品画像サムネイル2">
            <img src="img\baba.png" class="img-thumbnail thumb-image" alt="商品画像サムネイル3">
            <img src="img\abe.jpg" class="img-thumbnail thumb-image" alt="商品画像サムネイル4">
          </div>
        </div>
        <div class="col-md-6">
          <p class="h6 brand-name text-danger">かっこいいブランド</p>
          <h1 class="product-name">かっこいい服</h1>
      
          <p class="h4 text-danger product-price">¥20000</p>

          <!-- 商品の色選択 -->
          <div class="mb-3">
            <label for="colorSelect" class="form-label">色:</label>
            <select class="form-select" id="colorSelect">
              <option selected>色を選択してください</option>
              <option value="red">ピンク</option>
              <option value="blue">黄緑</option>
              <option value="green">バーガンディ</option>
            </select>
          </div>

          <!-- 商品のサイズ選択 -->
          <div class="mb-3">
            <label for="sizeSelect" class="form-label">サイズ:</label>
            <select class="form-select" id="sizeSelect">
              <option selected>サイズを選択してください</option>
              <option value="small">小</option>
              <option value="medium">中</option>
              <option value="large">大</option>
            </select>
          </div>  


          <button class="btn btn-primary btn-lg add-to-cart-button" onclick= "location.href='kart.php'"><i class="bi bi-cart-plus"></i> カートに追加</button>
          <button class="favorite-button align-middle" onclick="toggleFavorite(event, this)">★</button>
          <p class="product-description">360°どこから見ても可愛いデザイン。
            ディテールにこだわりの大人のドレスシャツ。<br>
            
            胸元のタックがクラシカルでサイドリボンが大人ガーリー。
            ゆったりとした着心地ながらラグジュアリーな印象に。<br>
            
            ■point<br>
            ・細かいところまでこだわったディテール<br>
            ・こだわりのインド綿100％<br>
            ・抜け感のあるサイドリボン<br>
            
            ■detail<br>
            コットン100％のしっかりとした素材で、ピンタックやサイドリボンなど細かいところまでこだわったディテールが嬉しいガーリーブラウス。<br>
            フロントはフェイクボタンとタックで立体的に、サイドもリボンでしっかりメリハリが効いている計算された1枚。<br>
            袖はたっぷりとした身幅のおかげで自然に落ちるフレンチスリーブのようなデザインで、気になる二の腕をかくしてくれるのも嬉しいポイントです。<br>
            インでもアウトでもキマる絶妙な丈感でオフィスからデイリーまで着回しの効く１着。<br>
            
            ■fabric<br>
            厚めでしっかりしたインド綿100％<br>
            ……………………
            透け感：なし(ホワイトのみあり)<br>
            厚さ：普通<br>
            伸縮性：なし<br>
            ポケット：なし<br>
            洗濯方法：洗濯機可<br>
            …………………
            ※詳しいお手入れ方法は商品タグをご参照ください。<br>
            ※ネットに入れてのお洗濯をお勧めいたします。<br>
            </p>
        </div>
      </div>
    </main>
<!-- /コンテンツ　-->
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

<script src="js\item-detail.js"></script>
