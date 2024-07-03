<?php
/*!
@file user-detail.php
@brief ユーザー詳細表示および編集ページ
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

//ライブラリをインクルード
require_once("../Uru_test/URUCOMMON/common/libs.php");

$err_array = array();
$err_flag = 0;
$page_obj = null;

//--------------------------------------------------------------------------------------
/// 本体ノード
//--------------------------------------------------------------------------------------
class cmain_node extends cnode
{
	//--------------------------------------------------------------------------------------
	/*!
    @brief コンストラクタ
    */
	//--------------------------------------------------------------------------------------
	public function __construct()
	{
		// 親クラスのコンストラクタを呼ぶ
		parent::__construct();
	}

	//--------------------------------------------------------------------------------------
	/*!
    @brief 本体実行（表示前処理）
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
    @brief 構築時の処理(継承して使用)
    @return なし
    */
	//--------------------------------------------------------------------------------------
	public function create()
	{
		// ページが生成されたときの処理をここに記述する
	}

	//--------------------------------------------------------------------------------------
	/*!
    @brief 更新または削除処理
    */
	//--------------------------------------------------------------------------------------
	public function update_or_delete()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
			// データベース接続を試みる 
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if ($mysqli->connect_error) {
				die("データベース接続失敗: " . $mysqli->connect_error);
			}

			$user_id = intval($_POST['user_id']);

			if (isset($_POST['update'])) {
				// 更新処理
				$user_name = $mysqli->real_escape_string($_POST['user_name']);
				$user_email = $mysqli->real_escape_string($_POST['user_email']);
				$user_pass = $mysqli->real_escape_string($_POST['user_pass']);
				$user_post_code = $mysqli->real_escape_string($_POST['user_post_code']);
				$user_address = $mysqli->real_escape_string($_POST['user_address']);

				$update_query = "UPDATE users SET 
                                    user_name = '$user_name', 
                                    user_email = '$user_email', 
                                    user_pass = '$user_pass', 
                                    user_post_code = '$user_post_code', 
                                    user_address = '$user_address' 
                                WHERE user_id = $user_id";

				if ($mysqli->query($update_query)) {
					echo "ユーザー情報を更新しました。<br>";
				} else {
					echo "エラー: " . $mysqli->error . "<br>";
				}
			} elseif (isset($_POST['delete'])) {
				// 削除処理
				$delete_query = "DELETE FROM users WHERE user_id = $user_id";
				if ($mysqli->query($delete_query)) {
					echo "ユーザーを削除しました。<br>";
				} else {
					echo "エラー: " . $mysqli->error . "<br>";
				}
			}

			// データベース接続を閉じる
			$mysqli->close();
			// POSTリクエストの後にリダイレクトする（ページリロード）
			header("Location: " . $_SERVER['PHP_SELF']);
			exit;
		}
	}

	//--------------------------------------------------------------------------------------
	/*!
    @brief 表示(継承して使用)
    @return なし
    */
	//--------------------------------------------------------------------------------------
	public function display()
	{
		if (!isset($_GET['user_id'])) {
			echo "ユーザーIDが指定されていません。";
			exit;
		}
		$user_id = intval($_GET['user_id']);

		// データベース接続を試みる 
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if ($mysqli->connect_error) {
			die("データベース接続失敗: " . $mysqli->connect_error);
		} /*else {
			echo "データベース接続成功<br>";
		}*/

		// ユーザー情報とボディ情報を取得するクエリ
		$sql = "SELECT users.*, bodys.*
            	FROM users
            	LEFT JOIN bodys ON users.user_id = bodys.user_id
            	WHERE users.user_id = $user_id";

		$result = $mysqli->query($sql);

		if (!$result) {
			die("クエリ実行エラー: " . $mysqli->error);
		}

		// 結果を取得
		$user_data = $result->fetch_assoc();

		// デバッグ用に取得したデータを出力
		echo '<pre>';
		print_r($user_data);
		echo '</pre>';

		// 結果が空かどうかを確認
		if (!$user_data) {
			echo "指定されたユーザー情報が見つかりません。";
			exit;
		}

		// HTMLの内容を表示
		$this->renderHTML($user_data);
	}

	//--------------------------------------------------------------------------------------
	/*!
    @brief ユーザー情報をHTMLで表示
    @param array $user_data ユーザー情報の配列
    @return なし
    */
	//--------------------------------------------------------------------------------------
	private function renderHTML($user_data)
	{
		if (!$user_data) {
			echo "指定されたユーザー情報が見つかりません。";
			return;
		}
?>

			<!-- コンテンツ -->
			<div class="contents">
				<main class="container mt-4">
					<!-- ページタイトル -->
					<h1>ユーザー詳細</h1>
					<div class="center">
						<?php if ($user_data) : ?>

							<input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_data['user_id']); ?>">

							<label>ユーザーID</label><br>
							<input disabled="disabled" name="user_id" size="30" value="<?php echo htmlspecialchars($user_data['user_id']); ?>" required><br><br>

							<label>ユーザーネーム</label><br>
							<input disabled="disabled" name="user_name" size="30" value="<?php echo htmlspecialchars($user_data['user_name']); ?>" required><br><br>

							<label>メールアドレス</label><br>
							<input disabled="disabled" name="user_email" size="30" value="<?php echo htmlspecialchars($user_data['user_email']); ?>" required><br><br>

							<label>パスワード</label><br>
							<input disabled="disabled" name="user_pass" size="30" value="<?php echo htmlspecialchars($user_data['user_pass']); ?>" required><br><br>

							<label>郵便番号</label><br>
							<input disabled="disabled" name="user_post_code" size="30" value="<?php echo htmlspecialchars($user_data['user_post_code']); ?>" required><br><br>

							<label>住所</label><br>
							<textarea disabled="disabled" name="user_address" cols="40" rows="2" required><?php echo htmlspecialchars($user_data['user_address']); ?></textarea><br><br>

							<!-- bodys テーブルからの情報 -->
							<label>ボディID</label><br>
							<input disabled="disabled" name="body_id" size="30" value="<?php echo htmlspecialchars($user_data['body_id']); ?>" required><br><br>

							<label>年齢</label><br>
							<input disabled="disabled" name="age" size="30" value="<?php echo htmlspecialchars($user_data['age']); ?>" required><br><br>

							<label>身長</label><br>
							<input disabled="disabled" name="height" size="30" value="<?php echo htmlspecialchars($user_data['height']); ?>" required><br><br>

							<label>体重</label><br>
							<input disabled="disabled" name="weight" size="30" value="<?php echo htmlspecialchars($user_data['weight']); ?>" required><br><br>

							<label>足のサイズ</label><br>
							<input disabled="disabled" name="shoes_waist" size="30" value="<?php echo htmlspecialchars($user_data['shoes_waist']); ?>" required><br><br>

							<!-- 削除用フォーム -->
							<form method="post" action="">
								<input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_data['user_id']); ?>">
								<button type="submit" name="delete" class="btn btn-outline-danger">このユーザーを削除する</button>
							</form>
							<br>

							<!-- 戻るボタン用フォーム -->
							<form action="JavaScript:history.back();">
								<button type="submit" class="btn btn-outline-success">ユーザー一覧へ戻る</button>
							</form>
							<br><br><br><br>

						<?php else : ?>
							<p>指定されたユーザーが見つかりませんでした。</p>
						<?php endif; ?>
					</div>
				</main>
			</div>

<?php
	}

	//--------------------------------------------------------------------------------------
	/*!
    @brief デストラクタ
    */
	//--------------------------------------------------------------------------------------
	public function __destruct()
	{
		//親クラスのデストラクタを呼ぶ
		parent::__destruct();
	}

	//--------------------------------------------------------------------------------------
	/*!
    @brief テーブルからデータを取得する関数
    */
	//--------------------------------------------------------------------------------------
	private function get_table_data($mysqli, $table, $id_col, $name_col)
	{
		$query = "SELECT $id_col, $name_col FROM $table";
		$result = $mysqli->query($query);

		$data = array();
		if ($result) {
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
		} else {
			echo "クエリ実行エラー: " . $mysqli->error . "<br>";
		}
		return $data;
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
