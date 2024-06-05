<link rel="stylesheet" href = "css/mypage.css">
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

<div class="contents-body">
      <div class="sidebar d-flex flex-column p-0 bg-body-tertiary">
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="mypage.php">
                <svg class="bi"></svg>
                会員情報
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center gap-2" href="rireki.php">
                <svg class="bi"></svg>
                注文履歴
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center gap-2" href="okini">
                <svg class="bi"></svg>
                お気に入り
              </a>
            </li>
          </ul>
          <hr class="my-3">
          <ul class="nav flex-column mb-auto">
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center gap-2" href="#modal-01">
                <svg class="bi"></svg>
                ログアウト
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="contents-block">
        <div class="content-area">
          <h5><strong>会員登録情報</strong></h5>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th colspan="3">基本情報</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th><p>氏名</p></th>
                <td>佐藤夢二</td>
                <td><input type="button" value="編集"></td>
              </tr>
              <tr>
                <th><p>郵便番号</p></th>
                <td><p>〒XXX-XXXX<p></td>
                  <td><input type="button" value="編集"></td>
              </tr>
              <tr>
                <th><p>住所</p></th>
                <td><p>福島県郡山市喜久田町XXXXXXXXX</p></td>
                <td><input type="button" value="編集"></td>
              </tr>
              <tr>
                <th><p>電話番号</p></th>
                <td><p>090-XXXX-XXXX</p></td>
                <td><input type="button" value="編集"></td>
              </tr>
              <tr>
                <th><p>パスワード</p></th>
                <td><p>*********</p></td>
                <td><input type="button" value="編集"></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="content-area">
          <h5><strong>身体情報</strong></h5>
          <table class="table table-bordered">
            <thead>
              <tr><th colspan="3">身体情報</th></tr>
            </thead>
            <tbody>
              <tr>
                <th><p>年齢</p></th>
                <td><p>30</p></td>
                <td><input type="button" value="編集"></td>
              </tr>
              <tr>
                <th><p>身長</p></th>
                <td><p>165cm<p></td>
                <td><input type="button" value="編集"></td>
              </tr>
              <tr>
                <th><p>体重</p></th>
                <td><p>55kg</p></td>
                <td><input type="button" value="編集"></td>
              </tr>
              <tr>
                <th><p>ウエスト</p></th>
                <td><p>80cm</p></td>
                <td><input type="button" value="編集"></td>
              </tr>
              <tr>
                <th><p>股下</p></th>
                <td><p>秘密♡</p></td>
                <td><input type="button" value="編集"></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="content-area">
          <h5><strong>クレジットカード情報</strong></h5>
          <table class="table table-bordered">
            <thead>
              <tr><th colspan="4">クレジットカード情報</th></tr>
            </thead>
            <tbody>
              <tr>
                <th><p>カード番号</p></th>
                <td><p>＊＊＊＊＊＊＊＊＊＊＊XXX</p></td>
                <td><input type="button" value="編集"></td>
              </tr>
            </tbody>
          </table>
        </div>
        
      </div>
  <div class="modal-wrapper" id="modal-01">
    <a href="#!" class="modal-overlay"></a>
    <div class="modal-window">
      <div class="modal-content">
        <p class="modal_title">ログアウトしますか？</p>
        <div class="btn-group">
        <button class="cancel-btn" onclick="">キャンセル</button>
        <button class="logout-btn" onclick="">ログアウト</button>
        </div>
      </div>
      <a href="#!" class="modal-close"><i class="far fa-times-circle"></i></a>
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
