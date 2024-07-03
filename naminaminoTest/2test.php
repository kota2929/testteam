<?php
/*!
@file hinagata.php
@brief ページ作成の雛形ファイル
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

// ライブラリをインクルード
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
		// 親クラスのコンストラクタを呼ぶ
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
		// 更新・削除処理を実行
		$this->update_or_delete();
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
		}

		// faqテーブルから全ての情報を取得するクエリを実行
		$sql = "SELECT faq_id, question, answer FROM faq";
		$result = $mysqli->query($sql);

		if (!$result) {
			die("クエリ実行エラー: " . $mysqli->error);
		}

		// データを表示
		$this->renderHTML($result);

		// データベース接続を閉じる
		$mysqli->close();
	}

	//--------------------------------------------------------------------------------------
	/*!
	@brief  更新または削除処理
	*/
	//--------------------------------------------------------------------------------------
	private function update_or_delete()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['faq_id'])) {
			// データベース接続を試みる 
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if ($mysqli->connect_error) {
				die("データベース接続失敗: " . $mysqli->connect_error);
			}

			$faq_id = intval($_POST['faq_id']);

			if (isset($_POST['update'])) {
				// 更新処理
				$product_name = $mysqli->real_escape_string($_POST['product_name']);
				$product_exp = $mysqli->real_escape_string($_POST['product_exp']);
				$question = $mysqli->real_escape_string($_POST['question']);
				$answer = $mysqli->real_escape_string($_POST['answer']);

				$update_query = "UPDATE faq SET 
									product_name = '$product_name', 
									product_exp = '$product_exp', 
									question = '$question', 
									answer = '$answer'
								WHERE faq_id = $faq_id";

				if ($mysqli->query($update_query)) {
					echo "FAQ情報を更新しました。<br>";
				} else {
					echo "エラー: " . $mysqli->error . "<br>";
				}
			} elseif (isset($_POST['delete'])) {
				// 削除処理
				$delete_query = "DELETE FROM faq WHERE faq_id = $faq_id";
				if ($mysqli->query($delete_query)) {
					echo "FAQを削除しました。<br>";
				} else {
					echo "エラー: " . $mysqli->error . "<br>";
				}
			}

			$mysqli->close();
		}
	}

	//--------------------------------------------------------------------------------------
	/*!
	@brief  質問情報をHTMLで表示
	@param object $result データベースから取得したクエリ結果
	@return なし
	*/
	//--------------------------------------------------------------------------------------
	private function renderHTML($result)
	{
		//PHPブロック終了
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQページ</title>
    <!-- 必要なスタイルやスクリプトのリンクを追加 -->
</head>
<body>
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
                ?>
                <p>
                    <button type="button" onclick="window.location.href='FAQ-add.php'" class="btn btn-outline-success">新しいFAQを登録する</button>
                </p>
                <br>
            </div>
        </main>
    </div>
    <!-- 必要なJavaScriptの関数やライブラリを追加 -->
    <script>
        function deleteProduct(faqId) {
            alert('FAQ ID ' + faqId + ' の情報を削除します。');
            // 削除処理を実装する必要があります
        }
    </script>
</body>
</html>
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
		// 親クラスのデストラクタを呼ぶ
		parent::__destruct();
	}
}

// ページを作成
$page_obj = new cnode();
// ヘッダ追加
$page_obj->add_child(cutil::create('cheader'));
// 本体追加
$page_obj->add_child($main_obj = cutil::create('cmain_node'));
// フッタ追加
$page_obj->add_child(cutil::create('cfooter'));
// 構築時処理
$page_obj->create();
// 本体実行（表示前処理）
$main_obj->execute();
// ページ全体を表示
$page_obj->display();

?>
