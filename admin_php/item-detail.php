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
      <h1>商品一覧</h1>
<br>
    <!--項目-->
    <p>FAQNo.　　｜　　　　　　　Q　　　　　｜A　　　　　　｜補足　　　　　　｜編集</p>
    <!--1行目-->
    <p>1　　　　　｜ログインできない　　　　　　｜あああああああ｜あああああ...｜
    	<button type="button" onclick="window.location.href='item-edit.php'" class="btn btn-outline-success">編集する</button>
	</p>
    <!--2行目-->
    <p>2　　　　　｜分割払いしてもいいですか？｜ダメです。　｜ああああああああ｜
    	<button type="button" onclick="window.location.href='item-edit.php'" class="btn btn-outline-success">編集する</button>
	</p>
    <br>
<br>
<div class="center">
<p>
	<button type="button" onclick="window.location.href='mypage-admin.php'" class="btn btn-outline-success">管理者マイページへ戻る</button>
</p>

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
