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
      <h1>商品の追加</h1>
<br>
<!--ボタン-->
<br>
<div class="center">

商品ID

	商品名<br><input name="id" size="30"><br><br>
	商品の説明<br><input name="id" size="30"><br><br>
	ジャンルID<br>
		<select id="fruits" name="janru">
    		<option value="apple">　</option>
      		<option value="orange">カジュアル</option>
      		<option value="grape">ストリート</option>
    	</select><br><br>
	季節ID<br>
		<select id="fruits" name="kisetu">
    		<option value="apple">　</option>
      		<option value="orange">春夏</option>
      		<option value="grape">秋冬</option>
    	</select><br><br>
	単価<br><input name="pey" size="30"><br><br>
	ブランドID<br>
		<select id="fruits" name="burando">
    		<option value="apple">　</option>
      		<option value="orange">らぁめん</option>
      		<option value="grape">うどん</option>
    	</select><br><br>
	色ID<br>
		<select id="fruits" name="color">
    		<option value="apple">　</option>
      		<option value="orange">赤</option>
      		<option value="grape">青</option>
    	</select><br><br>
	サイズID<br>
		<select id="fruits" name="size">
    		<option value="apple">　</option>
    		<option value="apple">S</option>
      		<option value="orange">M</option>
      		<option value="grape">L</option>
    	</select><br><br>
	<br>

	<button type="button" onclick="window.location.href='item-add-fin.php'" class="btn btn-outline-success">商品を登録</button>
</div>
  <br>
  <br>
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
