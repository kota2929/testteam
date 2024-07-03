<?php
/*!
@file hinagata.php
@brief ページ作成の雛形ファイル
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

//ライブラリをインクルード
require_once("../Uru_test/URUCOMMON/common/libs.php");

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
        // データベース接続を試みる 
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($mysqli->connect_error) {
            die("データベース接続失敗: " . $mysqli->connect_error);
        } /*else {
            echo "データベース接続成功<br>";
        }*/

        // productsテーブルから全ての情報を取得するクエリを実行
        $sql = "SELECT products.product_id, products.product_name, products.product_exp, products.product_price, 
                       genres.genre_name, seasons.season_name, blands.bland_name, categorys.category_name 
                FROM products
                JOIN genres ON products.genre_id = genres.genre_id
                JOIN seasons ON products.season_id = seasons.season_id
                JOIN blands ON products.bland_id = blands.bland_id
                JOIN categorys ON products.category_id = categorys.category_id";

        $result = $mysqli->query($sql);

        if (!$result) {
            die("クエリ実行エラー: " . $mysqli->error);
        }
//PHPブロック終了
?>
<!-- コンテンツ　-->
<div class="contents">
	
<main class="container mt-4">
        <!--pageタイトル-->
      <h1>注文管理</h1>
<br>
<!--テーブル-->
<br>
<p>注文ID｜ユーザーID｜合計金額｜注文ステータス｜注文作成日時｜詳細</p>
	1　　　｜ 　23　　｜￥13,456｜ああああああああ｜2024-08-02-04:46:01｜
	  <button type="button" onclick="window.location.href='order-rireki.php'" class="btn btn-outline-success">詳細</button>
</p>
<p>2　　　｜　　58　　｜￥5,230｜あああああああああ｜2024-09-20-15:03:56｜
	  <button type="button" onclick="window.location.href='order-rireki.php'" class="btn btn-outline-success">詳細</button>
</p>
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
