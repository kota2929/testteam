<link rel="stylesheet" href="css/toiawase.css">
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
<div class="contact_title">
        <h2>お問い合わせ</h2>
    </div>
    <div class="contact_text">
        <p>
            ご質問・ご要望など、下記のフォームよりお送りください。<br>
            担当者が確認次第、折り返しお返事させていただきます。
        </p>
    </div>
    
    <div class="cotact_form_body">
        <form action="お問い合わせを受け取るスクリプトのパス" method="post">
            <div class="form-group">
                <label for="name"><span class="required">お名前</span></label>
                <input class="input-text" type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="school"><span class="required">フリガナ</span></label>
                <input class="input-text" type="text" id="school" name="school">
            </div>

            <div class="form-group">
                <label for="email"><span class="required">メールアドレス</span></label>
                <input class="input-text" type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
              <label for="phone"><span class="required">電話番号</span></label>
              <input class="input-text" type="text" id="phone" name="phone" required>
          </div>

            <div class="form-group">
                <label for="message"><span class="required">お問い合わせ内容</span></label>
                <textarea id="message" name="message" required></textarea>
            </div>

            <div class="form-group">
                <p>ご入力内容をご確認の上、お間違いがなければ[送信]ボタンを押してください</p>
                <button class="submit-btn" type="submit" onclick="submitForm()">送信</button>
            </div>
            
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
