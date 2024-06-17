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
        <!-- コンテンツ　-->
        <div class="login-page">
            <div class="form">
                <form class="register-form" method="post" action="">
                    <h2 class="text-center">新規登録</h2>
                    <hr color="#000000" size="10px">
                    <div class="input-container">
                        <label for="name">本名</label>
                        <div class="name-container">
                            <input type="text" id="first-name" name="first-name" placeholder="姓" value="<?= htmlspecialchars($_POST['first-name'] ?? '', ENT_QUOTES) ?>" />
                            <input type="text" id="last-name" name="last-name" placeholder="名" value="<?= htmlspecialchars($_POST['last-name'] ?? '', ENT_QUOTES) ?>" />
                        </div>
                        <div class="error-message" id="first-name-error"></div>
                        <div class="error-message" id="last-name-error"></div>
                    </div>
                    <div class="input-container">
                        <label for="username">ユーザーネーム</label>
                        <input type="text" id="username" name="username" placeholder="ユーザーネーム" value="<?= htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES) ?>" />
                        <div class="error-message" id="username-error"></div>
                    </div>

                    <hr>

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

                    <div class="input-container">
                        <label for="zipcode">郵便番号</label>
                        <input type="text" id="zipcode" name="zipcode" placeholder="郵便番号" value="<?= htmlspecialchars($_POST['zipcode'] ?? '', ENT_QUOTES) ?>" />
                        <div class="error-message" id="zipcode-error"></div>
                    </div>
                    <div class="input-container">
                        <label for="prefecture">都道府県</label>
                        <select id="prefecture" name="prefecture">
                            <option value="">都道府県を選択</option>
                            <option value="北海道" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '北海道') ? 'selected' : '' ?>>北海道</option>
<option value="青森県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '青森県') ? 'selected' : '' ?>>青森県</option>
<option value="岩手県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '岩手県') ? 'selected' : '' ?>>岩手県</option>
<option value="宮城県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '宮城県') ? 'selected' : '' ?>>宮城県</option>
<option value="秋田県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '秋田県') ? 'selected' : '' ?>>秋田県</option>
<option value="山形県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '山形県') ? 'selected' : '' ?>>山形県</option>
<option value="福島県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '福島県') ? 'selected' : '' ?>>福島県</option>
<option value="茨城県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '茨城県') ? 'selected' : '' ?>>茨城県</option>
<option value="栃木県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '栃木県') ? 'selected' : '' ?>>栃木県</option>
<option value="群馬県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '群馬県') ? 'selected' : '' ?>>群馬県</option>
<option value="埼玉県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '埼玉県') ? 'selected' : '' ?>>埼玉県</option>
<option value="千葉県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '千葉県') ? 'selected' : '' ?>>千葉県</option>
<option value="東京都" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '東京都') ? 'selected' : '' ?>>東京都</option>
<option value="神奈川県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '神奈川県') ? 'selected' : '' ?>>神奈川県</option>
<option value="新潟県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '新潟県') ? 'selected' : '' ?>>新潟県</option>
<option value="富山県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '富山県') ? 'selected' : '' ?>>富山県</option>
<option value="石川県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '石川県') ? 'selected' : '' ?>>石川県</option>
<option value="福井県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '福井県') ? 'selected' : '' ?>>福井県</option>
<option value="山梨県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '山梨県') ? 'selected' : '' ?>>山梨県</option>
<option value="長野県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '長野県') ? 'selected' : '' ?>>長野県</option>
<option value="岐阜県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '岐阜県') ? 'selected' : '' ?>>岐阜県</option>
<option value="静岡県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '静岡県') ? 'selected' : '' ?>>静岡県</option>
<option value="愛知県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '愛知県') ? 'selected' : '' ?>>愛知県</option>
<option value="三重県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '三重県') ? 'selected' : '' ?>>三重県</option>
<option value="滋賀県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '滋賀県') ? 'selected' : '' ?>>滋賀県</option>
<option value="京都府" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '京都府') ? 'selected' : '' ?>>京都府</option>
<option value="大阪府" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '大阪府') ? 'selected' : '' ?>>大阪府</option>
<option value="兵庫県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '兵庫県') ? 'selected' : '' ?>>兵庫県</option>
<option value="奈良県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '奈良県') ? 'selected' : '' ?>>奈良県</option>
<option value="和歌山県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '和歌山県') ? 'selected' : '' ?>>和歌山県</option>
<option value="鳥取県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '鳥取県') ? 'selected' : '' ?>>鳥取県</option>
<option value="島根県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '島根県') ? 'selected' : '' ?>>島根県</option>
<option value="岡山県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '岡山県') ? 'selected' : '' ?>>岡山県</option>
<option value="広島県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '広島県') ? 'selected' : '' ?>>広島県</option>
<option value="山口県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '山口県') ? 'selected' : '' ?>>山口県</option>
<option value="徳島県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '徳島県') ? 'selected' : '' ?>>徳島県</option>
<option value="香川県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '香川県') ? 'selected' : '' ?>>香川県</option>
<option value="愛媛県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '愛媛県') ? 'selected' : '' ?>>愛媛県</option>
<option value="高知県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '高知県') ? 'selected' : '' ?>>高知県</option>
<option value="福岡県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '福岡県') ? 'selected' : '' ?>>福岡県</option>
<option value="佐賀県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '佐賀県') ? 'selected' : '' ?>>佐賀県</option>
<option value="長崎県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '長崎県') ? 'selected' : '' ?>>長崎県</option>
<option value="熊本県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '熊本県') ? 'selected' : '' ?>>熊本県</option>
<option value="大分県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '大分県') ? 'selected' : '' ?>>大分県</option>
<option value="宮崎県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '宮崎県') ? 'selected' : '' ?>>宮崎県</option>
<option value="鹿児島県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '鹿児島県') ? 'selected' : '' ?>>鹿児島県</option>
<option value="沖縄県" <?= (isset($_POST['prefecture']) && $_POST['prefecture'] == '沖縄県') ? 'selected' : '' ?>>沖縄県</option>

                        </select>
                        <div class="error-message" id="prefecture-error"></div>
                    </div>
                    <div class="input-container">
                        <label for="city">市区町村</label>
                        <input type="text" id="city" name="city" placeholder="市区町村" value="<?= htmlspecialchars($_POST['city'] ?? '', ENT_QUOTES) ?>" />
                        <div class="error-message" id="city-error"></div>
                    </div>
                    <div class="input-container">
                        <label for="street">番地</label>
                        <input type="text" id="street" name="street" placeholder="番地" value="<?= htmlspecialchars($_POST['street'] ?? '', ENT_QUOTES) ?>" />
                        <div class="error-message" id="street-error"></div>
                    </div>
                    <div class="input-container">
                        <label for="building-room">建物名・部屋番号</label>
                        <input type="text" id="building-room" name="building-room" placeholder="建物名・部屋番号" value="<?= htmlspecialchars($_POST['building-room'] ?? '', ENT_QUOTES) ?>" />
                        <div class="error-message" id="building-room-error"></div>
                    </div>
<div class=" checkbox_css">
    <label for="no-building-room" class="checkbox_label">建物名・部屋番号無し</label>
    <input type="checkbox"  id="no-building-room" name="no-building-room" class="checkbox_button">
</div>


                    <hr>

                    <div class="button_layauto">
                        <button type="submit">作成</button>
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
<script src="js/sinkitouroku.js"></script>
