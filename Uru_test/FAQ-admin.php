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
    @brief FAQデータの取得
    @return array FAQ情報の配列
    */
    //--------------------------------------------------------------------------------------
    public function getFAQData() {
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

        $faqs = [];
        while ($row = $result->fetch_assoc()) {
            $faqs[] = $row;
        }

        // データベース接続を閉じる
        $mysqli->close();

        return $faqs;
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief 表示(継承して使用)
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function display() {
        // FAQデータを取得
        $faqs = $this->getFAQData();

        // HTMLの内容を表示する
        $this->renderHTML($faqs);
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief FAQ情報をHTMLで表示
    @param array $faqs FAQ情報の配列
    @return なし
    */
    //--------------------------------------------------------------------------------------
    private function renderHTML($faqs) {
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
            <!-- pageタイトル -->
            <h1>FAQページ</h1>
            <br><br>
            <!-- テーブル -->
            <div class="center">
                <?php if (count($faqs) > 0): ?>
                    <table border="1" id="faqTable">
                        <tr>
                            <th>FAQのID</th>
                            <th>質問内容</th>
                            <th>回答</th>
                            <th>編集する</th>
                            <th>削除する</th>
                        </tr>
                        <?php foreach ($faqs as $faq): ?>
                            <tr id="row_<?php echo htmlspecialchars($faq['faq_id']); ?>">
                                <td><?php echo htmlspecialchars($faq['faq_id']); ?></td>
                                <td><?php echo htmlspecialchars($faq['question']); ?></td>
                                <td><?php echo htmlspecialchars($faq['answer']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-outline-success" onclick="window.location.href='FAQ-edit.php?faq_id=<?php echo htmlspecialchars($faq['faq_id']); ?>'">編集する</button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-danger" onclick="deleteFAQ(<?php echo htmlspecialchars($faq['faq_id']); ?>)">削除する</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p>0件の結果</p>
                <?php endif; ?>
            </div>
            <p>
                <button type="button" onclick="window.location.href='FAQ-edit.php'" class="btn btn-outline-success">新しいFAQを登録する</button>
            </p>
            <br>
        </main>
    </div>

    <!-- 必要なJavaScriptの関数やライブラリを追加 -->
    <script>
        function deleteFAQ(faqId) {
            alert('FAQ ID ' + faqId + ' のFAQを削除します。');
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
