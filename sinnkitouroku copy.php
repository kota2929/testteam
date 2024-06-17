<link rel="stylesheet" href="css/sinkitouroku.css">
<?php
/*!
@file hinagata.php
@brief ページ作成の雛形ファイル
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

// ライブラリをインクルード
require_once("common/libs.php");

$err_array = array();
$err_flag = 0;
$page_obj = null;

//--------------------------------------------------------------------------------------
///	本体ノード
//--------------------------------------------------------------------------------------
class cmain_node extends cnode {
    //--------------------------------------------------------------------------------------
    /*!
    @brief    コンストラクタ
    */
    //--------------------------------------------------------------------------------------
    public function __construct() {
        // 親クラスのコンストラクタを呼ぶ
        parent::__construct();
    }
    //--------------------------------------------------------------------------------------
    /*!
    @brief  本体実行（表示前処理）
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function execute(){
    }
    //--------------------------------------------------------------------------------------
    /*!
    @brief    構築時の処理(継承して使用)
    @return    なし
    */
    //--------------------------------------------------------------------------------------
    public function create(){
    }
    //--------------------------------------------------------------------------------------
    /*!
    @brief  表示(継承して使用)
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function display(){
        global $err_array; // エラーメッセージ配列をグローバルから参照

        ?>
        <!-- コンテンツ -->
        <div class="login-page">
            <div class="form">
                <!-- エラーメッセージ表示領域 -->
                <?php if (!empty($err_array)) { ?>
                    <div class="error-message">
                        <?php foreach ($err_array as $err) {
                            echo $err . "<br>";
                        } ?>
                    </div>
                <?php } ?>

                <form class="register-form" method="post" action="">
                    <!-- フォームの中身 -->
                    <h2>新規登録</h2>
                    <div class="input-container">
                        <label for="name">本名</label>
                        <input type="text" id="name" name="name" placeholder="本名"/>
                    </div>
                    <div class="input-container">
                        <label for="furigana">フリガナ</label>
                        <input type="text" id="furigana" name="furigana" placeholder="フリガナ"/>
                    </div>
                    <!-- 他のフォーム要素も同様に -->
                    <button type="submit">作成</button>
                    <p class="message">すでに登録済みですか？ <a href="#">サインイン</a></p>
                </form>
            </div>
        </div>
        <!-- /コンテンツ -->
        <?php
    }
    //--------------------------------------------------------------------------------------
    /*!
    @brief    デストラクタ
    */
    //--------------------------------------------------------------------------------------
    public function __destruct(){
        // 親クラスのデストラクタを呼ぶ
        parent::__destruct();
    }
}

// フォームが送信されたかどうかを確認
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームの入力値を取得
    $name = $_POST["name"];
    $furigana = $_POST["furigana"];
    // 他のフォーム要素も同様に取得

    // 入力値の検証
    if (empty($name)) {
        $err_array[] = "本名を入力してください。";
    }
    // 他のフォーム要素も同様に検証

    // エラーメッセージがない場合は登録処理などを行う
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
<script src="js/sinkitouroku.js"></script>
