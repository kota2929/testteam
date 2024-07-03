<link rel="stylesheet" href="css/sinkitouroku.css">
<?php
/*!
@file hinagata.php
@brief ページ作成の雛形ファイル
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

//ライブラリをインクルード
require_once ("../common/libs.php");

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
            $admin_name = trim($_POST['name']);
            $admin_email = trim($_POST['email']);
            $admin_pass = trim($_POST['password']);

            // バリデーションチェック
            if (empty($admin_name)) {
                $err_array['name'] = '名前を入力してください';
            }

            if (empty($admin_email)) {
                $err_array['email'] = 'メールアドレスを入力してください';
            } elseif (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
                $err_array['email'] = '正しいフォーマットで入力してください';
            } else {
                // メールアドレスの重複チェック
                $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                if ($db->connect_error) {
                    die("データベース接続に失敗しました: " . $db->connect_error);
                }
                $stmt = $db->prepare("SELECT COUNT(*) FROM mngs WHERE mng_email = ?");
                $stmt->bind_param('s', $admin_email);
                $stmt->execute();
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();

                if ($count > 0) {
                    $err_array['email'] = 'このメールアドレスは既に使用されています';
                }
            }

            if (empty($admin_pass)) {
                $err_array['password'] = 'パスワードを入力してください';
            } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $admin_pass)) {
                $err_array['password'] = '８桁以上の英数字でパスワードを設定してください';
            }

            // エラーがない場合のみデータベースに格納
            if (empty($err_array)) {
                // パスワードのハッシュ化
                $hashed_password = password_hash($admin_pass, PASSWORD_DEFAULT);

                // データベース接続情報（接続は既にされている前提）
                $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                if ($db->connect_error) {
                    die("データベース接続に失敗しました: " . $db->connect_error);
                }

                // データの挿入
                $stmt = $db->prepare("INSERT INTO mngs (mng_name, mng_email, mng_pass) VALUES (?, ?, ?)");
                $stmt->bind_param('sss', $admin_name, $admin_email, $hashed_password);

                if ($stmt->execute()) {
                    header("Location: login.php");
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
        <!-- コンテンツ　-->
        <div class="login-page">
            <div class="form">
                <form class="register-form" method="post" action="">
                    <div class="form-title"> 
                        <h2 class="text-center">管理者新規登録</h2>
                    </div>
                   
                    <div class="form-body">
                    <div class="input-container">
                        <label for="name">名前</label>
                        <input type="text" id="name" name="name" placeholder="名前" value="<?= htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES) ?>" />
                        <div class="error-message" id="name-error"></div>
                    </div>
                    <div class="input-container">
                        <label for="email">メールアドレス</label>
                        <input type="text" id="email" name="email" placeholder="メールアドレス" value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES) ?>" />
                        <div class="error-message" id="email-error"></div>
                    </div>
                    <div class="input-container">
                        <label for="password">パスワード</label>
                        <input type="password" id="password" name="password" placeholder="パスワード" value="<?= htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES) ?>" />
                        <div class="error-message" id="password-error"></div>
                    </div>

                    <hr>

                    <div class="button_layauto">
                        <button type="submit">作成</button>
                    </div>
                    <div class="go_login">
                        <p class="message">すでに登録済みですか？ <a href="login.php">サインイン</a></p>
                    </div>
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
<script src="js/sinkitouroku.js"></script>
