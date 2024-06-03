<link rel="stylesheet" href="css/okini.css">
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
<div class="okini-page">
        <div class="okini-items">
          
          <div class="okini-title"><h2>お気に入り</h2></div>

          <div class="okini-item">
            <img src="img/20230628_080424.jpg" alt="商品画像">
            <div class="okini-details">
                <p class = "item-text">ヒトラーT</p>
                <p class = "item-text">サイズ：M</p>
                <p class = "item-text">カラー：Black</p>
                <p class = "item-text">¥2,500</p>
            </div>
            <div class="okini-actions">
			<input class="add_cart" type="button" value="カートに追加">
                <button class="delete-btn">削除</button>
            </div>
        </div>

            <div class="okini-item">
              <img src="img/hg.jpeg" alt="商品画像">
              <div class="okini-details">
                  <p class = "item-text">レイザーラモンHGTシャツ</p>
                  <p class = "item-text">サイズ：M</p>
                  <p class = "item-text">カラー：Black</p>
                  <p class = "item-text">¥4,980</p>
              </div>
              <div class="okini-actions">
			  <input class="add_cart" type="button" value="カートに追加">
                  <button class="delete-btn">削除</button>
              </div>
          </div>

          <div class="okini-item">
            <img src="img/hg.jpeg" alt="商品画像">
            <div class="okini-details">
                <p class = "item-text">レイザーラモンHGTシャツ</p>
                <p class = "item-text">サイズ：M</p>
                <p class = "item-text">カラー：Black</p>
                <p class = "item-text">¥4,980</p>
            </div>
            <div class="okini-actions">
			<input class="add_cart" type="button" value="カートに追加">
                <button class="delete-btn">削除</button>
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
