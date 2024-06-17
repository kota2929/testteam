<?php
/*!
@file FAQ-edit.php
@brief FAQ編集ページ
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

//ライブラリをインクルード
require_once("../common/libs.php");

$err_array = array();
$err_flag = 0;
$page_obj = null;

// データベースに接続
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// 接続エラーをチェック
if ($mysqli->connect_error) {
    die("データベース接続失敗: " . $mysqli->connect_error);
}

// FAQ IDを取得
$faq_id = $_GET['faq_id'] ?? null;

// 初期化
$question = '';
$answer = '';

if ($faq_id !== null) {
    // FAQデータを取得
    $sql = "SELECT question, answer FROM faq WHERE faq_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $faq_id);
    $stmt->execute();
    $stmt->bind_result($question, $answer);
    $stmt->fetch();
    $stmt->close();

    // 「。」で改行する
    $question = str_replace("。", "。\n", $question);
    $answer = str_replace("。", "。\n", $answer);
}

// POSTされたデータを処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームから送信されたデータを取得
    $question = $_POST['question'] ?? '';
    $answer = $_POST['answer'] ?? '';

    // データベースに接続
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // 接続エラーをチェック
    if ($mysqli->connect_error) {
        die("データベース接続失敗: " . $mysqli->connect_error);
    }

    // FAQを更新するクエリを作成
    $sql = "UPDATE faq SET question = ?, answer = ? WHERE faq_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssi", $question, $answer, $faq_id);

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
?>

<!-- コンテンツ　-->
<div class="contents">
    <!-- コンテンツ -->
    <main class="container mt-4">
        <!--pageタイトル-->
        <h1>FAQ編集</h1>
        <br>
        <!--フォーム-->
        <form action="" method="post">
            <div class="FAQ_title">
                <label for="question">よくある質問内容</label><br>
                <textarea id="question" name="question" rows="10" cols="100" required><?php echo htmlspecialchars($question); ?></textarea><br>
            </div>
            <br>
            <div class="wide">
                <label for="answer">回答文</label><br>
                <textarea id="answer" name="answer" rows="10" cols="100" required><?php echo htmlspecialchars($answer); ?></textarea><br>
            </div>
            <br>
            <div class="center">
                <button type="submit" class="btn btn-outline-success">保存する</button>
                <button type="button" onclick="window.location.href='FAQ-admin.php'" class="btn btn-outline-secondary">戻る</button>
            </div>
        </form>
    </main>
</div>
<!-- /コンテンツ　-->
