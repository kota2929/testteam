<link rel="stylesheet" href="css/login.css">
<?php
/*!
@file hinagata.php
@brief ページ作成の雛形ファイル
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

//ライブラリをインクルード
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
            $stmt = $mysqli->prepare("SELECT user_pass FROM users WHERE user_email = ?");
            $stmt->bind_param("s", $accountID);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($hashed_password);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    // パスワードが正しい場合、セッションにユーザー情報を保存
                    $_SESSION['user_email'] = $accountID;
                    header("Location: dashboard.php"); // ログイン成功後にリダイレクト
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
          <main class="container mt-4">
            <br><br>
            <p class="p1">ログイン</p>
            <div class="ZXx center-form">
              <form action="#" method="post">
                <div class="input-container">
                  <input type="text" class="g1" name="accountID" value="" placeholder="アカウントID">
                  <input type="password" class="g1" name="password" value="" placeholder="パスワード">
                </div>
                <div class="login-button-layout">
                  <button type="submit">ログイン</button>
                </div>
              </form>
              <a class="p2" href="#">パスワードをお忘れの方</a>
              <br><br>
              <p class="p3">初めてご利用になる方</p>
              <button class="fh" onclick="">新規登録</button>
            </div>
          </main>
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
?>
