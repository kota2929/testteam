<link rel="stylesheet" href="css/sinkitouroku.css">
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
        <h2>新規会員登録</h2>
    </div>
    <div class="contact_text">
        <p>
            必要事項を入力してお買い物<br>
        </p>
    </div>
    
    <div class="cotact_form_body">
        <form>
            <div class="form-group">
                <label for="sei"><span class="required">本名</span></label>
                <div class="name-fields">
                    <input class="input-text" type="text" id="sei" name="sei" placeholder="姓" required>
                    <input class="input-text" type="text" id="mei" name="mei" placeholder="名" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="huri-sei"><span class="required">ふりがな</span></label>
                <div class="hurigana-fields">
                    <input class="input-text" type="text" id="huri-sei" name="huri-sei" placeholder="せい" required>
                    <input class="input-text" type="text" id="huri-mei" name="huri-mei" placeholder="めい" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="username"><span class="required">ユーザネーム</span></label>
                <input class="input-text" type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="email"><span class="required">メールアドレス</span></label>
                <input class="input-text" type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="postcode"><span class="required">郵便番号</span></label>
                <input class="input-text" type="text" id="postcode" name="postcode" required onkeyup="fetchAddress()">
            </div>

            <div class="form-group">
                <label for="prefecture"><span class="required">都道府県</span></label>
                <input class="input-text" type="text" id="prefecture" name="prefecture" required>
            </div>

            <div class="form-group">
                <label for="city"><span class="required">市区町村</span></label>
                <input class="input-text" type="text" id="city" name="city" required>
            </div>

            <div class="form-group">
                <label for="address"><span class="required">番地</span></label>
                <input class="input-text" type="text" id="address" name="address" required>
            </div>

            <div class="form-group">
                <label for="building"><span class="required">建物名・部屋番号</span></label>
                <input class="input-text" type="text" id="building" name="building">
            </div>

            <div class="form-group">
                <p>ご入力内容をご確認の上、お間違いがなければ[アカウント登録]ボタンを押してください</p>
                <button class="submit-btn" type="submit" onclick="submitForm()">アカウント登録</button>
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
<script src="js/sinkitouroku.js"></script>
