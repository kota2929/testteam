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
<<<<<<< HEAD
<h5><strong>雛形ファイル</strong></h5>
※このファイルは雛形ファイルです。
=======
	
<main class="container mt-4">
        <!--pageタイトル-->
      <h1>お問い合わせ一覧</h1>
      
<div class="center">
    <!--機能選択ボタン-->
    <a href="../管理者側/FAQenroll.html" class="btn btn-outline-success">
        全て表示
    </a>
    <a href="../counseling_read.html" class="btn btn-outline-success">
        解決済みのみ表示
    </a>
    <a href="../user_control.html" class="btn btn-outline-success">
        未解決のみ表示
    </a>
    <br><br>
    <!--項目-->
    <p>相談No.　　｜商品名 　　｜ユーザー名　｜購入日時　　　　　｜詳細</p>
    <!--1行目-->
    <p>1　　　　　｜タンクトップ　｜山田　敏夫｜2024-08-02-04:46:01｜
      <a href="soudan-detail.php" class="btn btn-outline-success">
      解決済み
      </a></p>
    <!--2行目-->
    <p>2　　　　　｜シャツ　　　｜あいす　　｜2024-09-20-15:03:56｜
      <a href="soudan-detail.php" class="btn btn-outline-success">
      回答する
      </a></p>
    <br>
</div>
    </main>


>>>>>>> origin/develop
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
