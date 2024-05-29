<link rel="stylesheet" href = "css/FAQ.css">
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
<main class="container">
      <h2 class="faq-title">よくある質問（FAQ）</h2>

      <div class="q&a">
        <div class="question_text">
          <p>Q.返品は可能ですか？</p>
        </div>
        <div class="answer_text">
          <p>以下に該当する場合は返品・交換をお受けできません。</p>
          <ul>
            <li>商品タグ（※）の紛失、破損・汚損がある場合 ※紐などでくくられている下げ札や、袋や箱に貼付されているシールタグなどがあります。</li>
            <li>商品本体に縫い付けられているタグを切り離した場合</li>
            <li>商品に付属する箱や袋（※）の紛失、破損・汚損がある場合</li>
            <li>商品を受取った日より一週間以上経過している場合</li>
          </ul>
        </div>
      </div>

      <div class="q&a">
        <div class="question_text">
          <p>Q.支払方法は何が利用できますか？</p>
        </div>
        <div class="answer_text">
          <p>当サイトで利用できる決済方法の種類は以下の通りです。</p>
          <ul>
            <li>コンビニ支払い</li>
            <li>クレジットカード支払い</li>
          </ul>
        </div>
      </div>

      <div class="q&a">
        <div class="question_text">
          <p>Q.商品が届くまでにどのくらいかかりますか？</p>
        </div>
        <div class="answer_text">
          <p>通常、ご注文から3日以内に納品させていただいております。ただし、地域や天候、繁忙期によっては前後する可能性がございます。</p>
        </div>
      </div>

      <div class="q&a">
        <div class="question_text">
          <p>Q.配送方法にはどんな種類がありますか？</p>
        </div>
        <div class="answer_text">
          <p>通常配送と日時指定配送がご利用いただけます。</p>
        </div>
      </div>

      <div class="contact_text_block">
        <h2 class="contact_text">解決しない場合、詳しく知りたい場合には下記のお問い合わせフォームから</h2>
      </div>

      <div class="contact_button_block text-center">
        <a href="contact.html" class="contact_button">お問い合わせフォームへ</a>
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
