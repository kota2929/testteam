<?php
/*!
@file item-image-add.php
@brief 商品画像を追加するページ
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

// ライブラリをインクルード
require_once("../common/libs.php");

$err_array = array();
$err_flag = 0;
$page_obj = null;

// 商品情報を取得
$product_id = $_POST['product_id'] ?? null;
$product_name = $_POST['product_name'] ?? null;
$product_exp = $_POST['product_exp'] ?? null;
$product_price = $_POST['product_price'] ?? null;
$bland_name = $_POST['bland_name'] ?? null;
$genre_name = $_POST['genre_name'] ?? null;
$season_name = $_POST['season_name'] ?? null;
$category_name = $_POST['category_name'] ?? null;
$color_name = $_POST['color_name'] ?? null;

// 画像保存先のディレクトリを設定
$upload_dir = "../ProductImageFile/";

// 画像アップロード処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image_count = 0;
    if (isset($_FILES['image1']) && $_FILES['image1']['error'] === UPLOAD_ERR_OK) {
        $image_count++;
    }
    if (isset($_FILES['image2']) && $_FILES['image2']['error'] === UPLOAD_ERR_OK) {
        $image_count++;
    }
    if (isset($_FILES['image3']) && $_FILES['image3']['error'] === UPLOAD_ERR_OK) {
        $image_count++;
    }

    // 少なくとも1つの画像が選択されているか確認
    if ($image_count > 0) {
        // 画像が選択されている場合の処理を行う
        $images = [$_FILES['image1'], $_FILES['image2'], $_FILES['image3']];
        $image_paths = [];

        // ディレクトリの存在を確認し、存在しない場合は作成
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0777, true)) {
                die("ディレクトリの作成に失敗しました: " . $upload_dir);
            }
        }

        // データベース接続を試みる 
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_error) {
            die("データベース接続失敗: " . $mysqli->connect_error);
        }

        // 色名から色IDを取得（プリペアドステートメント使用）
        $query_color_id = "SELECT color_id FROM colors WHERE color_name = ?";
        $stmt_color_id = $mysqli->prepare($query_color_id);
        if ($stmt_color_id === false) {
            die("プリペアドステートメントの準備に失敗しました: " . $mysqli->error);
        }
        $stmt_color_id->bind_param("s", $color_name);
        $stmt_color_id->execute();
        $stmt_color_id->store_result();

        if ($stmt_color_id->num_rows > 0) {
            $stmt_color_id->bind_result($color_id);
            $stmt_color_id->fetch();
        } else {
            // カラーが見つからない場合の処理
            die("Error: カラーが見つかりませんでした");
        }

        // 各画像ごとに処理を行う
        foreach ($images as $index => $image) {
            if ($image['error'] == UPLOAD_ERR_OK) {
                $img_name = "{$product_id}_{$color_id}_" . ($index + 1) . ".jpeg";
                $img_path = $upload_dir . $img_name;

                // ファイルをアップロードディレクトリに移動
                if (move_uploaded_file($image['tmp_name'], $img_path)) {
                    $image_paths[] = $img_path;

                    // データベースに画像のパスを保存（プリペアドステートメント使用）
                    $img_path_db = "ProductImageFile/$img_name";
                    $query = "INSERT INTO images (product_id, color_id, img_pass) VALUES (?, ?, ?)
                              ON DUPLICATE KEY UPDATE img_pass = VALUES(img_pass)";
                    $stmt = $mysqli->prepare($query);
                    if ($stmt === false) {
                        die("プリペアドステートメントの準備に失敗しました: " . $mysqli->error);
                    }
                    $stmt->bind_param("iis", $product_id, $color_id, $img_path_db);

                    // デバッグ用メッセージ
                    echo "Executing statement for product_id={$product_id}, color_id={$color_id}, img_path_db={$img_path_db}<br>";

                    if ($stmt->execute()) {
                        echo "新しいレコードを作成または更新しました<br>";
                    } else {
                        echo "エラー: " . $stmt->error . "<br>";
                    }
                    $stmt->close();
                } else {
                    echo "ファイルのアップロードに失敗しました: " . $image['error'] . "<br>";
                }
            } else {
                echo "アップロードエラー: " . $image['error'] . "<br>";
            }
        }

        $stmt_color_id->close();
        $mysqli->close();

        // 処理がすべて完了したらリダイレクト
        header("Location: item-image-list.php");
        exit;
    } else {
        echo "少なくとも1つの画像ファイルを選択してください。";
    }
}

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
        //親クラスのコンストラクタを呼ぶ
        parent::__construct();
    }
    //--------------------------------------------------------------------------------------
    /*!
    @brief 本体実行（表示前処理）
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function execute() {
    }
    //--------------------------------------------------------------------------------------
    /*!
    @brief 構築時の処理(継承して使用)
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function create() {
    }
    //--------------------------------------------------------------------------------------
    /*!
    @brief 表示(継承して使用)
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function display() {
        global $product_id, $product_name, $product_exp, $product_price, $bland_name, $genre_name, $season_name, $category_name, $color_name;
?>
<!-- コンテンツ -->
<div class="contents">
    <h1>商品画像を追加</h1>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="image1">画像1</label>
            <input type="file" name="image1" class="form-control-file" id="image1" required>
        </div>
        <div class="form-group">
            <label for="image2">画像2</label>
            <input type="file" name="image2" class="form-control-file" id="image2" required>
        </div>
        <div class="form-group">
            <label for="image3">画像3</label>
            <input type="file" name="image3" class="form-control-file" id="image3" required>
        </div>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>商品ID</th>
                    <th>商品名</th>
                    <th>説明</th>
                    <th>単価</th>
                    <th>ブランド</th>
                    <th>ジャンル</th>
                    <th>季節</th>
                    <th>カテゴリー</th>
                    <th>色</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo htmlspecialchars($product_id); ?></td>
                    <td><?php echo htmlspecialchars($product_name); ?></td>
                    <td><?php echo htmlspecialchars($product_exp); ?></td>
                    <td><?php echo htmlspecialchars($product_price); ?></td>
                    <td><?php echo htmlspecialchars($bland_name); ?></td>
                    <td><?php echo htmlspecialchars($genre_name); ?></td>
                    <td><?php echo htmlspecialchars($season_name); ?></td>
                    <td><?php echo htmlspecialchars($category_name); ?></td>
                    <td><?php echo htmlspecialchars($color_name); ?></td>
                </tr>
            </tbody>
        </table>
        <br>
        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>">
        <input type="hidden" name="product_exp" value="<?php echo htmlspecialchars($product_exp); ?>">
        <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($product_price); ?>">
        <input type="hidden" name="bland_name" value="<?php echo htmlspecialchars($bland_name); ?>">
        <input type="hidden" name="genre_name" value="<?php echo htmlspecialchars($genre_name); ?>">
        <input type="hidden" name="season_name" value="<?php echo htmlspecialchars($season_name); ?>">
        <input type="hidden" name="category_name" value="<?php echo htmlspecialchars($category_name); ?>">
        <input type="hidden" name="color_name" value="<?php echo htmlspecialchars($color_name); ?>">
        <button type="submit" class="btn btn-primary">送信</button>
    </form>
</div>

<?php 
    }
    //--------------------------------------------------------------------------------------
    /*!
    @brief デストラクタ
    */
    //--------------------------------------------------------------------------------------
    public function __destruct() {
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
