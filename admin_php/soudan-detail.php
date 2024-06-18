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
        //親クラスのコンストラクタを呼ぶ
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
        // GETパラメータからユーザーIDと相談IDを取得
        $user_id = $_GET['user_id'];
        $cons_id = $_GET['cons_id'];

        // データベース接続を試みる 
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($mysqli->connect_error) {
            die("データベース接続失敗: " . $mysqli->connect_error);
        }

        // ユーザーIDと相談IDに対応する相談内容を取得するクエリを実行
        $sql = "SELECT * FROM questions WHERE user_id = '$user_id' AND cons_id = '$cons_id'";
        $result = $mysqli->query($sql);

        if (!$result) {
            die("クエリ実行エラー: " . $mysqli->error);
        }

        // データがあるか確認
        if ($result->num_rows > 0) {
            // データがある場合は行を取得
            $row = $result->fetch_assoc();

            // user_consの見やすさを上げるために、「。」が現れたら改行
            $user_cons = nl2br(str_replace("。", "。\n", htmlspecialchars($row["user_cons"])));

            // 相談内容を表示
            echo "<h1 style='text-align:center;'>相談詳細</h1>";

            echo "<div class='wide'>";
            echo "<table class='table table-bordered' style='width: 50%; margin: 0 auto;'>";
            echo "<tr><th>項目</th><th>内容</th></tr>";
            echo "<tr><td>ユーザーID</td><td>" . htmlspecialchars($row["user_id"]) . "</td></tr>";
            echo "<tr><td>相談ID</td><td>" . htmlspecialchars($row["cons_id"]) . "</td></tr>";
            echo "<tr><td>相談内容</td><td>" . $user_cons . "</td></tr>";
            // 追加の相談情報を表示
            echo "<tr><td>回答1</td><td>" . (isset($row["ans_1"]) ? htmlspecialchars($row["ans_1"]) : "") . "</td></tr>";
            echo "<tr><td>回答2</td><td>" . (isset($row["ans_2"]) ? htmlspecialchars($row["ans_2"]) : "") . "</td></tr>";
            echo "<tr><td>回答3</td><td>" . (isset($row["ans_3"]) ? htmlspecialchars($row["ans_3"]) : "") . "</td></tr>";
            echo "<tr><td>回答4</td><td>" . (isset($row["ans_4"]) ? htmlspecialchars($row["ans_4"]) : "") . "</td></tr>";
            echo "</table>";
            echo "</div>";
        } else {
            // データがない場合はメッセージを表示
            echo "<h1 style='text-align:center;'>相談詳細</h1>";
            echo "該当する相談が見つかりませんでした。";
        }

        //PHPブロック終了
?>
        <!-- コンテンツ -->
        <div class="contents">
            <main class="container mt-4">
                <!--pageタイトル-->
                <h1>相談詳細</h1>
                <br>
                <form method="POST" action="">
                    <div class="wide">
                        管理者回答
                        <textarea class="form-control" id="mng_ans" name="mng_ans" rows="5"></textarea>
                    </div>
                    <br>
                    <div class="center" style="text-align: center;">
                        <button type="submit" class="btn btn-outline-success">回答送信</button>
                    </div>
                </form>
                <br>
            </main>
        </div>
        <!-- /コンテンツ -->
<?php
        //PHPブロック再開

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mng_ans = $_POST['mng_ans'];

            if (empty($mng_ans)) {
                echo "<script>alert('回答を入力してください。');</script>";
            } else {
                // mng_ansとcons_statusを更新するクエリを実行
                $update_sql = "UPDATE questions SET mng_ans = ?, cons_status = 1 WHERE user_id = ? AND cons_id = ?";
                $stmt = $mysqli->prepare($update_sql);
                $stmt->bind_param('sss', $mng_ans, $user_id, $cons_id);

                if ($stmt->execute()) {
                
                    header("Location: soudan-detail-comp.php");
                    exit();
                } else {
                    echo "回答の送信に失敗しました: " . $stmt->error;
                }
            }
        }

        $mysqli->close();
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
