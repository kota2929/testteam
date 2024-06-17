<?php
/*!
@file hinagata.php
@brief ユーザー一覧をPHP呼び出しで表示する
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

// ライブラリをインクルード
require_once("../common/libs.php");

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
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief 構築時の処理(継承して使用)
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function create()
    {
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief ユーザーデータの取得
    @return array ユーザー情報の配列
    */
    //--------------------------------------------------------------------------------------
    public function getUserData()
    {
        // データベース接続を試みる 
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($mysqli->connect_error) {
            die("データベース接続失敗: " . $mysqli->connect_error);
        }

        // usersテーブルから全ての情報を取得するクエリを実行
        $sql = "SELECT user_id, user_name, user_email, user_pass, user_post_code, user_address FROM users";
        $result = $mysqli->query($sql);

        if (!$result) {
            die("クエリ実行エラー: " . $mysqli->error);
        }

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        // データベース接続を閉じる
        $mysqli->close();

        return $users;
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief 表示(継承して使用)
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function display()
    {
        // ユーザー情報を取得
        $users = $this->getUserData();

        // HTMLの内容を表示する
        $this->renderHTML($users);
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief ユーザー情報をHTMLで表示
    @param array $users ユーザー情報の配列
    @return なし
    */
    //--------------------------------------------------------------------------------------
    private function renderHTML($users)
    {
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー管理</title>
    <!-- 必要なスタイルやスクリプトのリンクを追加 -->
</head>
<body>
    <div class="contents">
        <main class="container mt-4">
            <!--pageタイトル-->
            <h1>ユーザー管理</h1>
            <br>
            <!--テーブル-->
            <div class="center">
                <?php if (count($users) > 0): ?>
					<!-- 取得した情報をテーブル形式で表示 -->
                    <table border="1" id="userTable">
                        <tr>
                            <th>ユーザーID</th>
                            <th>ユーザー名</th>
                            <th>メールアドレス</th>
                            <th>パスワード</th>
                            <th>郵便番号</th>
                            <th>住所</th>
                            <th>詳細</th>
                        </tr>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                                <td><?php echo htmlspecialchars($user['user_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['user_email']); ?></td>
                                <td><?php echo htmlspecialchars($user['user_pass']); ?></td>
                                <td><?php echo htmlspecialchars($user['user_post_code']); ?></td>
                                <td><?php echo htmlspecialchars($user['user_address']); ?></td>
                                <td><button type="button" class="btn btn-outline-danger" onclick="viewUserDetails(<?php echo htmlspecialchars($user['user_id']); ?>)">詳細</button></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p>0件の結果</p>
                <?php endif; ?>
            </div>
            <br>
        </main>
    </div>

    <!-- 必要なJavaScriptの関数やライブラリを追加 -->
    <script>
        function viewUserDetails(userId) {
            alert('ユーザーID ' + userId + ' の詳細を表示します。');
        }
    </script>
</body>
</html>
<?php
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief デストラクタ
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
