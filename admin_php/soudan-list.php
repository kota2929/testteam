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
    @brief 表示(継承して使用)
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

        // フィルタリング用の条件
        $filter_condition = "";

        // フィルタリングボタンによる条件分岐
        if (isset($_GET['filter'])) {
            $filter_value = $_GET['filter'];
            if ($filter_value == "answered") {
                $filter_condition = "WHERE questions.cons_status = 1";
            } elseif ($filter_value == "unanswered") {
                $filter_condition = "WHERE questions.cons_status = 0";
            }
        }

        // questionsテーブルとusersテーブルから必要な情報を取得するクエリを実行
        $sql = "SELECT users.user_id, questions.cons_id, questions.cons_status, 
                        questions.ans_1, questions.ans_2, questions.ans_3, questions.ans_4,
                        questions.user_cons, questions.mng_ans
                FROM questions
                JOIN users ON users.user_id = questions.user_id
                $filter_condition";

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
                <h1>相談一覧</h1>
                <br><br>
                <div class="center">
                    <!--機能選択ボタン-->
                    <a href="?filter=all" class="btn btn-outline-success">
                        全て表示
                    </a>
                    <a href="?filter=answered" class="btn btn-outline-success">
                        解決済みのみ表示
                    </a>
                    <a href="?filter=unanswered" class="btn btn-outline-success">
                        未解決のみ表示
                    </a>
                    <br>
                    <br>
                    <?php
                    // 取得した情報をテーブル形式で表示
                    if ($result->num_rows > 0) {
                        // データがある場合はテーブルを表示
                        echo "<div class='table-responsive'>";
                        echo "<table class='table table-bordered'>";
                        //項目
                        echo "<thead><tr><th>ユーザーID</th><th>相談ID</th><th>相談ステータス</th><th>回答1</th><th>回答2</th><th>回答3</th><th>回答4</th><th>ユーザー相談</th><th>管理者回答</th><th>削除</th><th>回答</th></tr></thead>";
                        echo "<tbody>";
                        //カテゴリー順に並んでいる
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr id='row_" . htmlspecialchars($row["user_id"]) . "'>";
                            echo "<td>" . htmlspecialchars($row["user_id"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["cons_id"]) . "</td>";
                            echo "<td>" . ($row["cons_status"] == 0 ? "未回答" : "回答済み") . "</td>";
                            echo "<td>" . htmlspecialchars($row["ans_1"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["ans_2"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["ans_3"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["ans_4"]) . "</td>";
                            echo "<td>" . nl2br(str_replace("。", "。\n", htmlspecialchars($row["user_cons"]))) . "</td>";
                            echo "<td>" . nl2br(str_replace("。", "。\n", htmlspecialchars($row["mng_ans"]))) . "</td>";
                            echo "<td><button type='button' class='btn btn-outline-danger' onclick='deleteProduct(" . htmlspecialchars($row["cons_id"]) . ")'>削除する</button></td>";
                            echo "<td><a href='soudan-detail.php?user_id=" . htmlspecialchars($row["user_id"]) . "&cons_id=" . htmlspecialchars($row["cons_id"]) . "&ans_1=" . htmlspecialchars($row["ans_1"]) . "&ans_2=" . htmlspecialchars($row["ans_2"]) . "&ans_3=" . htmlspecialchars($row["ans_3"]) . "&ans_4=" . htmlspecialchars($row["ans_4"]) . "&user_cons=" . htmlspecialchars($row["user_cons"]) . "&mng_ans=" . htmlspecialchars($row["mng_ans"]) . "' class='btn btn-outline-success'>回答する</a></td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        echo "</div>";
                    } else {
                        // データがない場合はメッセージを表示
                        echo "0件の結果";
                    }
                    // データベース接続を閉じる
                    $mysqli->close();
                    //php終了
                    ?>
                    <br>
                </div>
            </main>
        </div>
<?php
        //PHPブロック再開
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
