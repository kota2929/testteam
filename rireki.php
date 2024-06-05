<link rel="stylesheet" href = "css/rireki.css">
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
<div class="contents">
<div class="contents-body">
      <div class="sidebar d-flex flex-column p-0 bg-body-tertiary">
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="mypage.php">
                <svg class="bi"></svg>
                会員情報
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center gap-2" href="rireki.php">
                <svg class="bi"></svg>
                注文履歴
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center gap-2" href="okini">
                <svg class="bi"></svg>
                お気に入り
              </a>
            </li>
          </ul>
          <hr class="my-3">
          <ul class="nav flex-column mb-auto">
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center gap-2" href="#modal-01">
                <svg class="bi"></svg>
                ログアウト
              </a>
            </li>
          </ul>
        </div>
      </div>

      <div class="order-card">
        <div class="rireki-title">
          <h2>注文履歴</h2>
        </div>

        <div class="order-card-body">
          <div class="order-details-header">
            <div>注文日: 2024年5月20日</div>
            <div>合計: ¥2,500</div>
            <div>お届け先: 佐藤夢二</div>
          </div>
          <div class="order-content">
            <img src="path/to/image1.jpg" alt="商品画像">
            <div class="order-details">
              <p>商品名: 商品名〜〜〜〜〜〜〜〜〜〜〜</p>
              <p>サイズ: M</p>
              <p>カラー: Black</p>
            </div>
            <div class="order-actions">
              <button class="btn btn-primary">再度購入</button>
            </div>
          </div>
        </div>

        <div class="order-card-body">
          <div class="order-details-header">
            <div>注文日: 2024年3月10日</div>
            <div>合計: ¥2,500</div>
            <div>お届け先: 佐藤夢二</div>
          </div>
          <div class="order-content">
            <img src="path/to/image2.jpg" alt="商品画像">
            <div class="order-details">
              <p>商品名: 商品名〜〜〜〜〜〜〜〜〜〜〜</p>
              <p>サイズ: M</p>
              <p>カラー: Black</p>
            </div>
            <div class="order-actions">
              <button class="btn btn-primary">再度購入</button>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
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
