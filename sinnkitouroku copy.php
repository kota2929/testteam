<link rel="stylesheet" href="css/sinkitouroku.css">
<?php
/*!
@file hinagata.php
@brief ページ作成の雛形ファイル
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

// ライブラリをインクルード
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
<div class="login-page">
<div class="form">


    <form class="register-form">

    <h2>新規登録</h2>
      <div class="input-container">
        <label for="name">本名</label>
        <input type="text" id="name" placeholder="本名"/>
      </div>
      <div class="input-container">
        <label for="furigana">フリガナ</label>
        <input type="text" id="furigana" placeholder="フリガナ"/>
      </div>
      <div class="input-container">
        <label for="username">ユーザーネーム</label>
        <input type="text" id="username" placeholder="ユーザーネーム"/>
      </div>
      <div class="input-container">
        <label for="zipcode">郵便番号</label>
        <input type="text" id="zipcode" placeholder="郵便番号"/>
      </div>
      <div class="input-container">
        <label for="address">住所</label>
        <input type="text" id="address" placeholder="住所"/>
      </div>

      <div class="input-container">
        <label for="email">メールアドレス</label>
        <input type="text" id="email" placeholder="メールアドレス"/>
      </div>
      <div class="input-container">
        <label for="password">パスワード</label>
        <input type="password" id="password" placeholder="パスワード"/>
      </div>
     
      <button>作成</button>
      <p class="message">すでに登録済みですか？ <a href="#">サインイン</a></p>
    </form>


  
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
<script src="js/sinkitouroku.js"></script>
