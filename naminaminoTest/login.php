<link rel="stylesheet" href="css/login copy.css">
<?php
/*!
@file hinagata.php
@brief ページ作成の雛形ファイル
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/
// ライブラリをインクルード
require_once("common/libs.php");

session_start(); // セッション開始

$err_array = array();
$err_flag = 0;
$page_obj = null;

class cmain_node extends cnode {
public function __construct() {
    parent::__construct();
}

public function execute(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $accountID = $_POST['accountID'];
        $password = $_POST['password'];

        // データベース接続
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($mysqli->connect_error) {
            die("データベース接続失敗: " . $mysqli->connect_error);
        }

        // SQLクエリの準備
        $stmt = $mysqli->prepare("SELECT mng_id, mng_pass FROM mngs WHERE mng_email = ?");
        $stmt->bind_param("s", $accountID);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                // パスワードが正しい場合、セッションにユーザー情報を保存
                $_SESSION['mng_email'] = $accountID;
                $_SESSION['mng_id'] = $user_id;
                // ログイン成功後にリダイレクト
                header("Location: mypage-admin.php");
                exit();
            } else {
                echo "パスワードが間違っています。";
            }
        } else {
            echo "アカウントIDが存在しません。";
        }

        $stmt->close();
        $mysqli->close();
    }
}

public function create(){
}

public function display(){
    ?>
    <div class="contents">
    <div class="login-container">
        <h2 class="login-title">ログイン</h2>
        <form class="login-form" name="loginForm" method="post">
            <div class="form-group">
                <input type="text" class="user-name" name="accountID" placeholder="メールアドレス" required>
            </div>
            <div class="form-group">
                <input type="password" class="password" name="password" placeholder="パスワード" required>
            </div>
            
            <!-- エラーメッセージを表示する場所 -->
            <div class="form-group">
                <input class="loginbtn" type="submit" value="ログイン" onclick="" />
            </div>
            <div class="login-text">
                <a class="forget-pass">パスワードをお忘れの方</a>
            </div>
            <div class="new-user">
                <label>初めてのご利用になる方</label>
            </div>
            <div class="form-group">
                <button class="regist-btn" type="button" onclick="location.href='sinnkitouroku.php'">新規登録</button>
            </div>
        </form>
    </div>
    </div>
    <?php
}

public function __destruct(){
    parent::__destruct();
}
}

// ページを作成
$page_obj = new cnode();
$page_obj->add_child(cutil::create('cheader'));
$page_obj->add_child($main_obj = cutil::create('cmain_node'));
$page_obj->add_child(cutil::create('cfooter'));
$page_obj->create();
$main_obj->execute();
$page_obj->display();
