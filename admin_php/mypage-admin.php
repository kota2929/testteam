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

    <main class="container mt-4">
        <!--pageタイトル-->
      <h1>管理者マイページ</h1>
      <!--ボタンの後ろ-->
<div class="btn-back">
    <!--機能選択ボタン-->
    <a href="FAQ-admin.php" class="btn btn-outline-success">
        FAQ登録
    </a>
    <a href="soudan-list.php" class="btn btn-outline-success">
          相談閲覧
    </a>
    <a href="user-admin.php" class="btn btn-outline-success">
        ユーザー管理
    </a>
    <a href="item-admin.php" class="btn btn-outline-success">
        商品管理
    </a>
    <a href="order-admin.php" class="btn btn-outline-success">
        注文管理
    </a>

</div>
      <!-- ボタン8
    FAQ/相談/ユーザー管理/商品管理/注文管理(注文詳細) -->
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
