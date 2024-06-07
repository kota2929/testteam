<?php
/*!
@file hinagata.php
@brief ページ作成の雛形ファイル
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

//ライブラリをインクルード
require_once("../common/libs.php");

$err_array = array();
$err_flag = 0;
$page_obj = null;

//--------------------------------------------------------------------------------------
///	本体ノード
//--------------------------------------------------------------------------------------
class cmain_node extends cnode {
    //--------------------------------------------------------------------------------------
    /*!
    @brief	コンストラクタ
    */
    //--------------------------------------------------------------------------------------
    public function __construct() {
        //親クラスのコンストラクタを呼ぶ
        parent::__construct();
    }
    //--------------------------------------------------------------------------------------
    /*!
    @brief  本体実行（表示前処理）
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function execute(){
        global $mysqli, $brand_data;
        
        // データベース接続を試みる 
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_error) {
            die("データベース接続失敗: " . $mysqli->connect_error);
        }

        // blandsテーブルの全ての内容を取得するクエリを実行
        $query = "SELECT bland_id, bland_name FROM blands";
        $result = $mysqli->query($query);

        $brand_data = array();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $brand_data[] = $row;
            }
        } else {
            echo "クエリ実行エラー: " . $mysqli->error . "<br>";
        }
    }
    //--------------------------------------------------------------------------------------
    /*!
    @brief	構築時の処理(継承して使用)
    @return	なし
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
        global $brand_data;
//PHPブロック終了
?>
<!-- コンテンツ　-->
<div class="contents">
    <!-- コンテンツ -->
    <main class="container mt-4">
        <!--pageタイトル-->
        <h1>ブランドの登録</h1>
        <br>
        <!--ブランド一覧テーブル-->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ブランドID</th>
                        <th>ブランド名</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($brand_data)): ?>
                        <?php foreach ($brand_data as $brand): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($brand['bland_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($brand['bland_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">データがありません。</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <br>
        <!--ブランド登録フォーム-->
        <div class="center">
            <form action="item-add-fin.php" method="post">
                <label for="brand">ブランド名</label>
                <input type="text" id="brand" name="brand" size="30" required><br><br>
                <button type="submit" class="btn btn-outline-success">ブランドを登録</button>
            </form>
        </div>
        <br>
    </main>
</div>
<!-- /コンテンツ　-->
<?php 
//PHPブロック再開
    }
    //--------------------------------------------------------------------------------------
    /*!
    @brief	デストラクタ
    */
    //--------------------------------------------------------------------------------------
    public function __destruct(){
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

$mysqli->close();
?>
