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
		// POSTされたデータを処理
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			// フォームから送信されたデータを取得
			$question = $_POST['question'] ?? '';
			$answer = $_POST['answer'] ?? '';

			// データベースに接続
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

			// 接続エラーをチェック
			if ($mysqli->connect_error) {
				die("データベース接続失敗: " . $mysqli->connect_error);
			}

			// テーブルにデータを追加するクエリを作成
			$sql = "INSERT INTO faq (question, answer) VALUES ('$question', '$answer')";

			// クエリを実行し、結果をチェック
			if ($mysqli->query($sql) === TRUE) {
				echo "新しいレコードが正常に追加されました。";
				// FAQ-fin.phpに遷移
				header("Location: FAQ-fin.php");
				exit(); // 必ずexit()で処理を終了する
			} else {
				echo "エラー: " . $sql . "<br>" . $mysqli->error;
			}

			// データベース接続を閉じる
			$mysqli->close();
		}
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
      <h1>FAQを追加</h1>
<br>
      <!--フォーム-->
        <form action="" method="post">
            <div class="FAQ_title">
                <label for="question">よくある質問内容</label><br>
                <input type="text" id="question" name="question" size="40" required><br>
            </div>
            <br>
            <div class="wide">
                <label for="answer">回答文</label><br>
                <textarea id="answer" name="answer" rows="5" cols="40" required></textarea><br>
            </div>
            <br>
            <div class="center">
                <button type="submit" class="btn btn-outline-success">保存する</button>
                <button type="button" onclick="window.location.href='FAQ-admin.php'" class="btn btn-outline-secondary">戻る</button>
            </div>
        </form>
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
