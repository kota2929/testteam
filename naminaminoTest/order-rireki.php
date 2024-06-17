<?php
/*!
@file hinagata.php
@brief ページ作成の雛形ファイル
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

//ライブラリをインクルード
require_once("../common/libs.php");

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
	
    <!-- コンテンツ -->
    <main class="container mt-4">
        <!--pageタイトル-->
      <h1>注文詳細</h1>
    <!--追加・削除ボタン-->
<div class="center">
    
<br><br>
	注文詳細ID<br><input disabled="disabled" name="order-detail-id" size="30"><br><br>
	注文ID<br><input disabled="disabled" name="order-id" size="30"><br><br>
	商品ID<br><input disabled="disabled" name="item-id" size="30"><br><br>
	サイズID<br><input disabled="disabled" name="size-id" size="30"><br><br>
	色ID<br><input disabled="disabled" name="color-id" size="30"><br><br>
	注文個数<br><input disabled="disabled" name="order-num" size="30"><br><br>
	一種類の商品の合計金額<br><input disabled="disabled" name="one-item-allpey" size="30"><br><br>
<br><br>
	<button type="button" onclick="history.back(); return false;" class="btn btn-outline-success">戻る</button>
<br><br>
</div>

    </main>

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
