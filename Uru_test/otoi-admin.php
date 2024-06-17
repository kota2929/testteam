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
class cmain_node extends cnode {
    //--------------------------------------------------------------------------------------
    /*!
    @brief コンストラクタ
    */
    //--------------------------------------------------------------------------------------
    public function __construct() {
        // 親クラスのコンストラクタを呼ぶ
        parent::__construct();
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief 本体実行（表示前処理）
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function execute(){
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief 構築時の処理(継承して使用)
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function create(){
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief ユーザーデータの取得
    @return array ユーザー情報の配列
    */
    //--------------------------------------------------------------------------------------
    public function getInquiryData()
    {
        // データベース接続を試みる 
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($mysqli->connect_error) {
            die("データベース接続失敗: " . $mysqli->connect_error);
        }

        // quirysテーブルから全ての情報を取得するクエリを実行
        $sql = "SELECT quiry_id, quiry_email, quiry_user_name, quiry_text, quiry_status FROM quirys";
        $result = $mysqli->query($sql);

        if (!$result) {
            die("クエリ実行エラー: " . $mysqli->error);
        }

        $inquiries = [];
        while ($row = $result->fetch_assoc()) {
            $inquiries[] = $row;
        }

        // データベース接続を閉じる
        $mysqli->close();

        return $inquiries;
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief 表示(継承して使用)
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function display(){
        // お問い合わせデータを取得
        $inquiries = $this->getInquiryData();

        // HTMLの内容を表示する
        $this->renderHTML($inquiries);
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief お問い合わせ情報をHTMLで表示
    @param array $inquiries お問い合わせ情報の配列
    @return なし
    */
    //--------------------------------------------------------------------------------------
    private function renderHTML($inquiries)
    {
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせページ</title>
    <!-- 必要なスタイルやスクリプトのリンクを追加 -->
</head>
<body>
    <div class="contents">
        <main class="container mt-4">
            <!-- pageタイトル -->
            <h1>お問い合わせページ</h1>
            <br><br>
            <!-- テーブル -->
            <div class="center">
                <?php if (count($inquiries) > 0): ?>
                    <table border="1" id="inquiryTable">
                        <tr>
                            <th>お問い合わせID</th>
                            <th>メールアドレス</th>
                            <th>ユーザー名</th>
                            <th>問い合わせ内容</th>
                            <th>ステータス</th>
                            <th>削除</th>
                            <th>回答</th>
                        </tr>
                        <?php foreach ($inquiries as $inquiry): ?>
                            <tr id="row_<?php echo htmlspecialchars($inquiry['quiry_id']); ?>">
                                <td><?php echo htmlspecialchars($inquiry['quiry_id']); ?></td>
                                <td><?php echo htmlspecialchars($inquiry['quiry_email']); ?></td>
                                <td><?php echo htmlspecialchars($inquiry['quiry_user_name']); ?></td>
                                <td><?php echo htmlspecialchars($inquiry['quiry_text']); ?></td>
                                <td><?php echo htmlspecialchars($inquiry['quiry_status']); ?></td>
                                <td><button type="button" class="btn btn-outline-danger" onclick="deleteInquiry(<?php echo htmlspecialchars($inquiry['quiry_id']); ?>)">削除する</button></td>
                                <td><button type="button" class="btn btn-outline-success" onclick="window.location.href='otoi-detail-comp.php?quiry_id=<?php echo htmlspecialchars($inquiry['quiry_id']); ?>'">回答する</button></td>
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
        function deleteInquiry(quiryId) {
            alert('お問い合わせID ' + quiryId + ' の問い合わせを削除します。');
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
    public function __destruct(){
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
