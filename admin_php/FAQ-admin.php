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
class cmain_node extends cnode
{
	//--------------------------------------------------------------------------------------
	/*!
	@brief	コンストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __construct()
	{
		//親クラスのコンストラクタを呼ぶ
		parent::__construct();
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief  本体実行（表示前処理）
	@return なし
	*/
	//--------------------------------------------------------------------------------------
	public function execute()
	{
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	構築時の処理(継承して使用)
	@return	なし
	*/
	//--------------------------------------------------------------------------------------
	public function create()
	{
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief  表示(継承して使用)
	@return なし
	*/
	//--------------------------------------------------------------------------------------
	public function display()
	{
		// データベース接続を試みる 
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if ($mysqli->connect_error) {
			die("データベース接続失敗: " . $mysqli->connect_error);
		} else {
			echo "データベース接続成功<br>";
		}

		// faqテーブルから全ての情報を取得するクエリを実行
		$sql = "SELECT faq_id, question, answer 
                FROM faq";

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
			<h1>FAQページ</h1>
			<br><br>
			<div class="center">
				<?php
				// 取得した情報をテーブル形式で表示
				if ($result->num_rows > 0) {
					// データがある場合はテーブルを表示
					echo "<table class='table table-bordered'>";
					//項目
					echo "<tr><th>FAQのID</th><th>質問内容</th><th>回答</th><th>削除する</th><th>編集する</th></tr>";
					//カテゴリー順に並んでいる
					while ($row = $result->fetch_assoc()) {
						echo "<tr id='row_" . htmlspecialchars($row["faq_id"]) . "'>";
						echo "<td>" . htmlspecialchars($row["faq_id"]) . "</td>";
						echo "<td>" . nl2br(htmlspecialchars($row["question"])) . "</td>";
						echo "<td>" . nl2br(htmlspecialchars($row["answer"])) . "</td>";
						echo "<td><button type='button' class='btn btn-outline-danger' onclick='deleteProduct(" . htmlspecialchars($row["faq_id"]) . ")'>削除する</button></td>";
						echo "<td><button type='button' onclick='window.location.href=\"FAQ-edit.php?faq_id=" . htmlspecialchars($row["faq_id"]) . "\"' class='btn btn-outline-success'>編集する</button></td>";
						echo "</tr>";
					}
					echo "</table>";
				} else {
					// データがない場合はメッセージを表示
					echo "0件の結果";
				}
				// データベース接続を閉じる
				$mysqli->close();
				//php終了
				?>

				<p>
					<button type="button" onclick="window.location.href='FAQ-add.php'" class="btn btn-outline-success">新しいFAQを登録する</button>
				</p>
				<br>
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
	public function __destruct()
	{
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
