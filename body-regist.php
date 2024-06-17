<link rel="stylesheet" href="css/sinkitouroku.css">
<?php
/*!
@file hinagata.php
@brief ページ作成の雛形ファイル
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

//ライブラリをインクルード
require_once ("common/libs.php");

$err_array = array();
$err_flag = 0;
$page_obj = null;

//--------------------------------------------------------------------------------------
///	本体ノード
//--------------------------------------------------------------------------------------
class cmain_node extends cnode
{
    //--------------------------------------------------------------------------------------
    /*!
       @brief	コンストラクタ
       */
    //--------------------------------------------------------------------------------------
    public function __construct()
    {
        //親クラスのコンストラクタを呼ぶ
        parent::__construct();
    }

    //--------------------------------------------------------------------------------------
    /*!
       @brief  本体実行（表示前処理）
       @return なし
       */
    //--------------------------------------------------------------------------------------
    public function execute()
    {
        global $err_array, $err_flag;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $err_array = array();
            $err_flag = 0;

            // 入力データの取得とバリデーション
            $user_first_name = trim($_POST['first-name']);
            $user_last_name = trim($_POST['last-name']);
            $user_nickname = trim($_POST['username']);
            $user_email = trim($_POST['email']);
            $user_pass = trim($_POST['password']);
            $user_post_code = trim($_POST['zipcode']);
            $user_address = trim($_POST['prefecture'] . $_POST['city'] . $_POST['street'] . ($_POST['building-room'] ?? ''));

            // バリデーションチェック
            if (empty($user_first_name)) {
                $err_array['first-name'] = '姓を入力してください';
            }

            if (empty($user_last_name)) {
                $err_array['last-name'] = '名を入力してください';
            }

            if (empty($user_nickname)) {
                $err_array['username'] = 'ユーザーネームを入力してください';
            }

            if (empty($user_email)) {
                $err_array['email'] = 'メールアドレスを入力してください';
            } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                $err_array['email'] = '正しいフォーマットで入力してください';
            } else {
                // メールアドレスの重複チェック
                $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                if ($db->connect_error) {
                    die("データベース接続に失敗しました: " . $db->connect_error);
                }
                $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE user_email = ?");
                $stmt->bind_param('s', $user_email);
                $stmt->execute();
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();

                if ($count > 0) {
                    $err_array['email'] = 'このメールアドレスは既に使用されています';
                }
            }

            if (empty($user_pass)) {
                $err_array['password'] = 'パスワードを入力してください';
            } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $user_pass)) {
                $err_array['password'] = '８桁以上の英数字でパスワードを設定してください';
            }

            if (empty($user_post_code)) {
                $err_array['zipcode'] = '郵便番号を入力してください';
            } elseif (!preg_match('/^\d{7}$/', $user_post_code)) {
                $err_array['zipcode'] = 'ハイフン無し、半角数字７桁で入力してください';
            }

            if (empty($user_address)) {
                $err_array['address'] = '住所を入力してください';
            }

            // エラーがない場合のみデータベースに格納
            if (empty($err_array)) {
                // パスワードのハッシュ化
                $hashed_password = password_hash($user_pass, PASSWORD_DEFAULT);

                // データベース接続情報（接続は既にされている前提）
                $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                if ($db->connect_error) {
                    die("データベース接続に失敗しました: " . $db->connect_error);
                }

// データの挿入
$stmt = $db->prepare("INSERT INTO users (user_name, user_email, user_pass, user_post_code, user_address, user_nickname) VALUES (?, ?, ?, ?, ?, ?)");
$user_name = $user_first_name . ' ' . $user_last_name;  // 姓と名を半角スペースで結合
$stmt->bind_param('ssssss', $user_name, $user_email, $hashed_password, $user_post_code, $user_address, $user_nickname);

// bind_param() の引数は、最初に型定義文字列（ここでは 'ssssss'）があり、その後に順番にバインドする変数が続くことになります。



                if ($stmt->execute()) {
                    header("Location: login copy.php");
                    exit;
                } else {
                    echo "<div class='error-message'>データベースエラー: " . $stmt->error . "</div>";
                }

                $stmt->close();
                $db->close();
            } else {
                // エラーメッセージを表示するためにJavaScriptを使用
                echo "<script>window.errors = " . json_encode($err_array) . ";</script>";
                if (isset($err_array['email'])) {
                    echo "<script>window.emailError = '" . $err_array['email'] . "';</script>";
                }
            }
        }
    }

    //--------------------------------------------------------------------------------------
    /*!
       @brief	構築時の処理(継承して使用)
       @return	なし
       */
    //--------------------------------------------------------------------------------------
    public function create()
    {
    }

    //--------------------------------------------------------------------------------------
    /*!
       @brief  表示(継承して使用)
       @return なし
       */
    //--------------------------------------------------------------------------------------
    public function display()
    {
        //PHPブロック終了
        ?>
<!-- コンテンツ -->
<div class="login-page">
    <div class="form">
        <form class="register-form" method="post" action="">
            <h2 class="text-center">身体情報入力</h2>
            <p class="body-regist-exp">身体情報を登録しより自分に合った服選びを</p>
            <hr color="#000000" size="10px">
            
            <!-- 登録ボタンとスキップボタンを追加 -->
            <div class="button_layauto">
                <button type="button" id="show-body-info-form">登録</button>
                <button type="button" id="skip-body-info">スキップ</button>
            </div>

            <!-- 身体情報フォーム（デフォルトでは非表示） -->
            <div id="body-info-form" style="display: none;">
                <label for="height">身長</label>
                <input type="text" id="height" name="height" placeholder="身長を入力してください">
                <span id="height-error" class="error-message"></span>
                
                <label for="weight">体重</label>
                <input type="text" id="weight" name="weight" placeholder="体重を入力してください">
                <span id="weight-error" class="error-message"></span>
                
                <label for="chest">胸囲</label>
                <input type="text" id="chest" name="chest" placeholder="胸囲を入力してください">
                <span id="chest-error" class="error-message"></span>
                
                <label for="waist">ウエスト</label>
                <input type="text" id="waist" name="waist" placeholder="ウエストを入力してください">
                <span id="waist-error" class="error-message"></span>
                
                <label for="hip">ヒップ</label>
                <input type="text" id="hip" name="hip" placeholder="ヒップを入力してください">
                <span id="hip-error" class="error-message"></span>
                
                <div class="button_layauto">
                    <button type="submit">保存</button>
                </div>
            </div>

            <div class="go_login">
                <p class="message">すでに登録済みですか？ <a href="rogin.php">サインイン</a></p>
            </div>
        </form>
    </div>
</div>

        <!-- /コンテンツ　-->

        <script>
            // JavaScript でエラーメッセージを表示する
            document.addEventListener("DOMContentLoaded", function() {
                const errors = window.errors || {};
                for (const field in errors) {
                    if (errors.hasOwnProperty(field)) {
                        const errorMessage = errors[field];
                        document.getElementById(field + "-error").textContent = errorMessage;
                    }
                }
                if (window.emailError) {
                    document.getElementById("global-error").textContent = window.emailError;
                }
            });

        </script>

        <?php
        //PHPブロック再開
    }

    //--------------------------------------------------------------------------------------
    /*!
       @brief	デストラクタ
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
<script src="js/body-regist.js"></script>
