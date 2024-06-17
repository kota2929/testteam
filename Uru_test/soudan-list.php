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
    @brief 質問データの取得
    @return array 質問情報の配列
    */
    //--------------------------------------------------------------------------------------
    public function getQuestionsData()
    {
        // データベース接続を試みる 
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($mysqli->connect_error) {
            die("データベース接続失敗: " . $mysqli->connect_error);
        }

        // questionsテーブルから全ての情報を取得するクエリを実行
        $sql = "SELECT users.user_id, questions.cons_id, questions.cons_status, 
                        questions.ans_1, questions.ans_2, questions.ans_3,
                        questions.user_cons, questions.mng_ans
                FROM questions
                JOIN users ON users.user_id = questions.user_id";

        $result = $mysqli->query($sql);

        if (!$result) {
            die("クエリ実行エラー: " . $mysqli->error);
        }

        $questions = [];
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }

        // データベース接続を閉じる
        $mysqli->close();

        return $questions;
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief 表示(継承して使用)
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function display()
    {
        // 質問データを取得
        $questions = $this->getQuestionsData();

        // HTMLの内容を表示する
        $this->renderHTML($questions);
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief 質問情報をHTMLで表示
    @param array $questions 質問情報の配列
    @return なし
    */
    //--------------------------------------------------------------------------------------
    private function renderHTML($questions)
    {
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>相談一覧</title>
    <!-- 必要なスタイルやスクリプトのリンクを追加 -->
</head>
<body>
    <div class="contents">
        <main class="container mt-4">
            <!-- pageタイトル -->
            <h1>相談一覧</h1>
            <br><br>
            <div class="center">
                <!-- 機能選択ボタン -->
                <a href="#" class="btn btn-outline-success">全て表示</a>
                <a href="#" class="btn btn-outline-success">解決済みのみ表示</a>
                <a href="#" class="btn btn-outline-success">未解決のみ表示</a>

                <!-- テーブル -->
                <?php if (count($questions) > 0): ?>
                    <table border="1" id="questionsTable">
                        <tr>
                            <th>相談ID</th>
                            <th>ステータス</th>
                            <th>回答1</th>
                            <th>回答2</th>
                            <th>回答3</th>
                            <th>ユーザーの相談</th>
                            <th>管理者の回答</th>
                            <th>削除</th>
                            <th>編集</th>
                        </tr>
                        <?php foreach ($questions as $question): ?>
                            <tr id="row_<?php echo htmlspecialchars($question['user_id']); ?>">
                                <td><?php echo htmlspecialchars($question['cons_id']); ?></td>
                                <td><?php echo htmlspecialchars($question['cons_status']); ?></td>
                                <td><?php echo htmlspecialchars($question['ans_1']); ?></td>
                                <td><?php echo htmlspecialchars($question['ans_2']); ?></td>
                                <td><?php echo htmlspecialchars($question['ans_3']); ?></td>
                                <td><?php echo htmlspecialchars($question['user_cons']); ?></td>
                                <td><?php echo htmlspecialchars($question['mng_ans']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-outline-danger" onclick="deleteQuestion(<?php echo htmlspecialchars($question['cons_id']); ?>)">削除する</button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-success" onclick="window.location.href='soudan-detail-comp.php?cons_id=<?php echo htmlspecialchars($question['cons_id']); ?>'">編集する</button>
                                </td>
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
        function deleteQuestion(consId) {
            alert('相談ID ' + consId + ' の相談を削除します。');
            // 削除処理を実装する必要があります
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
