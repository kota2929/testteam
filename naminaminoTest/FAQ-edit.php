<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ編集ページ</title>
    <link rel="stylesheet" href="path/to/your/css/file.css"> <!-- 適切なCSSファイルへのリンクを追加 -->
</head>

<body>

    <?php
    /*!
@file FAQ-edit.php
@brief FAQ編集ページ
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

    // ライブラリをインクルード
    require_once("../Uru_test/URUCOMMON/common/libs.php");

    class cmain_node extends cnode
    {
        private $question = '';
        private $answer = '';
        private $faq_id;

        // コンストラクタ
        public function __construct()
        {
            // 親クラスのコンストラクタを呼ぶ
            parent::__construct();

            // FAQ IDを取得
            $this->faq_id = $_GET['faq_id'] ?? null;

            // データベースに接続
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($mysqli->connect_error) {
                die("データベース接続失敗: " . $mysqli->connect_error);
            }

            if ($this->faq_id !== null) {
                // FAQデータを取得
                $sql = "SELECT question, answer FROM faq WHERE faq_id = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("i", $this->faq_id);
                $stmt->execute();
                $stmt->bind_result($this->question, $this->answer);
                $stmt->fetch();
                $stmt->close();

                // 「。」で改行する
                $this->question = str_replace("。", "。\n", $this->question);
                $this->answer = str_replace("。", "。\n", $this->answer);
            }

            // データベース接続を閉じる
            $mysqli->close();
        }

        // 本体実行（表示前処理）
        public function execute()
        {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // フォームから送信されたデータを取得
                $this->question = $_POST['question'] ?? '';
                $this->answer = $_POST['answer'] ?? '';

                // データベースに接続
                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                if ($mysqli->connect_error) {
                    die("データベース接続失敗: " . $mysqli->connect_error);
                }

                // FAQを更新するクエリを作成
                $sql = "UPDATE faq SET question = ?, answer = ? WHERE faq_id = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("ssi", $this->question, $this->answer, $this->faq_id);

                // クエリを実行し、結果をチェック
                if ($stmt->execute()) {
                    echo "レコードが正常に更新されました。";
                    // FAQ-fin.phpに遷移
                    header("Location: FAQ-fin.php");
                    exit(); // 必ずexit()で処理を終了する
                } else {
                    echo "エラー: " . $sql . "<br>" . $mysqli->error;
                }

                // データベース接続を閉じる
                $stmt->close();
                $mysqli->close();
            }
        }

        // 表示
        public function display()
        {
    ?>
            <!-- コンテンツ　-->
            <div class="contents">
                <main class="container mt-4">
                    <!--ページタイトル-->
                    <h1>FAQ編集</h1>
                    <br>
                    <!--フォーム-->
                    <div class="center">
                        <form action="" method="post">
                            <div class="FAQ_title">
                                <label for="question">よくある質問内容</label><br>
                                <textarea id="question" name="question" rows="10" cols="100" required><?php echo htmlspecialchars($this->question); ?></textarea><br>
                            </div>
                            <br>
                            <div class="wide">
                                <label for="answer">回答文</label><br>
                                <textarea id="answer" name="answer" rows="10" cols="100" required><?php echo htmlspecialchars($this->answer); ?></textarea><br>
                            </div>
                            <br>
                            <div class="center">
                                <p>
                                    <button type="submit" class="btn btn-outline-success">保存する</button>
                                    <button type="button" onclick="window.location.href='FAQ-admin.php'" class="btn btn-outline-secondary">戻る</button>
                                </p>
                            </div>
                        </form>
                    </div>
                </main>
            </div>
            <!-- /コンテンツ　-->
    <?php
        }

        // デストラクタ
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

</body>

</html>