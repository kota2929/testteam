<?php
/*!
@file contents_node.php
@brief 共有するノード
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

////////////////////////////////////


//--------------------------------------------------------------------------------------
///	ヘッダノード
//--------------------------------------------------------------------------------------

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($mysqli->connect_error) {
    die("データベース接続失敗: " . $mysqli->connect_error);
} else {
    echo "データベース接続成功<br>";
}

class cheader extends cnode {
    public $user_id;
    public $user_name;
    public $user_email;

    public function __construct() {
        //親クラスのコンストラクタを呼ぶ
        parent::__construct();
        $this->user_id = null;
        $this->user_name = null;
        $this->user_email = null;
    }

    public function execute() {
        global $mysqli;

        // user_idをGETパラメータから取得
        $this->user_id = isset($_GET['id']) ? intval($_GET['id']) : null;

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Check connection
        

        // user_idが取得できた場合、ユーザー情報を取得する
        if ($this->user_id) {
            $stmt = $mysqli->prepare("SELECT user_name, user_email FROM users WHERE user_id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $this->user_id);
                $stmt->execute();
                $stmt->bind_result($this->user_name, $this->user_email);
                $stmt->fetch();
                $stmt->close();
            } else {
                die("Statement preparation failed: " . $mysqli->error);
            }
        }

        $mysqli->close();
    }

    public function create() {
    }

    public function display() {
        $echo_str = <<<END_BLOCK
        <!doctype html>
        <html lang="en">
          <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>ECサイト</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
            <link rel="stylesheet" href="css/index.css">
          </head>
          <body>
            <!-- ヘッダー -->
            <header class="bg-light border-bottom">
              <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">
                  <a class="navbar-brand nav-center" href="item-home.php">
                    <img src="img/rogo(仮).png" alt="ブランドロゴ" style="height: 50px;"> <!-- ここで画像を挿入 -->
                  </a>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav-center">
                      <li class="nav-item">
                        <a class="nav-link active nav-text" aria-current="page" href="item-home.php">ホーム</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link nav-text" href="アンケート.php">コーデ相談</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link nav-text" href="FAQ.php">FAQ</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link nav-text" href="toiawase.php">お問い合わせ</a>
                      </li>
                    </ul>
                    <ul class="navbar-nav ms-3">
                      <li class="nav-item">
                        <a class="nav-link" href="mypage.php">
                          <img src="img/kkrn_icon_user_13.png" alt="ユーザアイコン" class="user-img">
                          <!-- Display username if available -->
                          <?php if ($this->user_name): ?>
                            <span class="navbar-text">ようこそ, <?php echo htmlspecialchars($this->user_name); ?> さん</span>
                          <?php endif; ?>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link star-text" href="okini.php">☆</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="kart.php">
                          <img src="img/1223676.png" alt="カートアイコン" class="kart-img">
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </nav>
            </header>
END_BLOCK;
        echo $echo_str;
    }

    //
    
    public function display2() {
        $echo_str = <<<END_BLOCK
        <!doctype html>
        <html lang="en">
          <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>ECサイト</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
            <link rel="stylesheet" href="css/index.css">
          </head>
          <body>
            <!-- ヘッダー -->
            <header class="bg-light border-bottom">
              <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">
                  <a class="navbar-brand nav-center" href="item-home.php">
                    <img src="img/rogo(仮).png" alt="ブランドロゴ" style="height: 50px;"> <!-- ここで画像を挿入 -->
                  </a>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav-center">
                      <li class="nav-item">
                        <a class="nav-link active nav-text" aria-current="page" href="item-home.php">ホーム</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link nav-text" href="アンケート.php">コーデ相談</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link nav-text" href="FAQ.php">FAQ</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link nav-text" href="toiawase.php">お問い合わせ</a>
                      </li>
                    </ul>
                    <ul class="navbar-nav ms-3">
                      <li class="nav-item">
                        <a class="nav-link" href="mypage.php">
                          <img src="img/kkrn_icon_user_13.png" alt="ユーザアイコン" class="user-img">
                          <!-- Display username if available -->
                          <?php if ($this->user_name): ?>
                            <span class="navbar-text">ようこそ, <?php echo htmlspecialchars($this->user_name); ?> さん</span>
                          <?php endif; ?>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link star-text" href="okini.php">☆</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="kart.php">
                          <img src="img/1223676.png" alt="カートアイコン" class="kart-img">
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </nav>
            </header>
END_BLOCK;
        echo $echo_str;
    }
}




//--------------------------------------------------------------------------------------
///	フッターノード
//--------------------------------------------------------------------------------------
class cfooter extends cnode {
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
		$echo_str = <<< END_BLOCK

		<!-- フッター -->
		<footer class="bg-light text-center text-lg-start border-top mt-auto">
		  <div class="container p-4">
			<div class="row">
			  <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
				<h5 class="text-uppercase">会社情報</h5>
				<p>
				  ここに会社の説明文を入れます。お客様に対するメッセージや、会社のビジョンなど。
				</p>
			  </div>
			  <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
				<h5 class="text-uppercase">サポート</h5>
				<ul class="list-unstyled mb-0">
				  <li>
					<a href="toiawase.php" class="text-dark">お問い合わせ</a>
				  </li>
				  <li>
					<a href="FAQ.php" class="text-dark">よくある質問</a>
				  </li>
				  <li>
					<a href="purapo.php" class="text-dark" >プライバシーポリシー</a>
				  </li>
				</ul>
			  </div>
			  <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
				<h5 class="text-uppercase">フォローする</h5>
				<ul>
				<li>
				  <a href="#" class="text-dark sns-text">
					<img class="sns-img" src="img/icons8-フェイスブック-50.png" alt="Facebook">
					<i class="bi bi-facebook"></i> Facebook
				  </a>
				</li>
				<li>
				  <a href="#" class="text-dark sns-text">
					<img src="img\icons8-ツイッターx-50.png" alt="X(旧Twitter)" class="sns-img">
					<i class="bi bi-twitter"></i> X(旧Twitter)
				  </a>
				</li>
				<li>
				  <a href="#" class="text-dark sns-text">
					<img src="img\icons8-インスタグラム-50 (1).png" alt="Instagram" class="sns-img">
					<i class="bi bi-instagram"></i> Instagram
				  </a>
				</li>
			  </ul>
			  
			  </div>
			</div>
		  </div>
		  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
			© 2024 会社名
		  </div>
		</footer>
	
		<!-- 必要なスクリプトの読み込み順序を修正 -->
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/"></script>
		<script src="js\index.js"></script>
	  
	  </body>
	</html>
	
END_BLOCK;
		echo $echo_str;
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


//--------------------------------------------------------------------------------------
///	住所ノード
//--------------------------------------------------------------------------------------
class caddress extends cnode {
	public $param_arr;
	//--------------------------------------------------------------------------------------
	/*!
	@brief	コンストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __construct($param_arr) {
		$this->param_arr = $param_arr;
		//親クラスのコンストラクタを呼ぶ
		parent::__construct();
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	パラメータのチェック
	@return	なし（エラーの場合はエラーフラグを立てる）
	*/
	//--------------------------------------------------------------------------------------
	public function paramchk(){
		global $err_array;
		global $err_flag;
		if($this->param_arr['cntl_header_name'] == 'par' && $_POST['member_minor'] == 0 ){
			//保護者は未成年の時だけ必須
			return;
		}
		/// 名前の存在と空白チェック
		if(cutil_ex::chkset_err_field($err_array,"{$this->param_arr['cntl_header_name']}_name","{$this->param_arr['head']}名",'isset_nl')){
			$err_flag = 1;
		}
		/// 都道府県チェック
		if(cutil_ex::chkset_err_field($err_array,"{$this->param_arr['cntl_header_name']}_prefecture_id","{$this->param_arr['head']}都道府県",'isset_num_range',1,47)){
			$err_flag = 1;
		}
		/// 住所の存在と空白チェック
		if(cutil_ex::chkset_err_field($err_array,"{$this->param_arr['cntl_header_name']}_address","{$this->param_arr['head']}市区郡町村以下",'isset_nl')){
			$err_flag = 1;
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
	@brief  POST変数のデフォルト値をセット
	@return なし
	*/
	//--------------------------------------------------------------------------------------
	public function post_default(){
		cutil::post_default("{$this->param_arr['cntl_header_name']}_prefecture_id",0);
		cutil::post_default("{$this->param_arr['cntl_header_name']}_name",'');
		cutil::post_default("{$this->param_arr['cntl_header_name']}_address",'');
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	名前コントロールの取得
	@return	名前コントロール
	*/
	//--------------------------------------------------------------------------------------
	function get_name(){
		global $err_array;
		$ret_str = '';
		$tgt = new ctextbox("{$this->param_arr['cntl_header_name']}_name",
				$_POST["{$this->param_arr['cntl_header_name']}_name"],'size="70"');
		$ret_str = $tgt->get($_POST['func'] == 'conf');
		if(isset($err_array["{$this->param_arr['cntl_header_name']}_name"])){
			$ret_str .=  '<br /><span class="text-danger">' 
			. cutil::ret2br($err_array["{$this->param_arr['cntl_header_name']}_name"]) 
			. '</span>';
		}
		return $ret_str;
	}

	//--------------------------------------------------------------------------------------
	/*!
	@brief	都道府県プルダウンの取得
	@return	都道府県プルダウン文字列
	*/
	//--------------------------------------------------------------------------------------
	function get_prefecture_select(){
		global $err_array;
		//都道府県の一覧を取得
		$prefecture_obj = new cprefecture();
		$allcount = $prefecture_obj->get_all_count(false);
		$prefecture_rows = $prefecture_obj->get_all(false,0,$allcount);
		$tgt = new cselect("{$this->param_arr['cntl_header_name']}_prefecture_id");
		$tgt->add(0,'選択してください',$_POST["{$this->param_arr['cntl_header_name']}_prefecture_id"] == 0);
		foreach($prefecture_rows as $key => $val){
			$tgt->add($val['prefecture_id'],$val['prefecture_name'],
			$val['prefecture_id'] == $_POST["{$this->param_arr['cntl_header_name']}_prefecture_id"]);
		}
		$ret_str = $tgt->get($_POST['func'] == 'conf');
		if(isset($err_array["{$this->param_arr['cntl_header_name']}_prefecture_id"])){
			$ret_str .=  '<br /><span class="text-danger">' 
			. cutil::ret2br($err_array["{$this->param_arr['cntl_header_name']}_prefecture_id"]) 
			. '</span>';
		}
		return $ret_str;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	住所の取得
	@return	住所文字列
	*/
	//--------------------------------------------------------------------------------------
	function get_address(){
		global $err_array;
		$tgt = new ctextbox("{$this->param_arr['cntl_header_name']}_address",
				$_POST["{$this->param_arr['cntl_header_name']}_address"],'size="80"');
		$ret_str = $tgt->get($_POST['func'] == 'conf');
		if(isset($err_array["{$this->param_arr['cntl_header_name']}_address"])){
			$ret_str .=  '<br /><span class="text-danger">' 
			. cutil::ret2br($err_array["{$this->param_arr['cntl_header_name']}_address"]) 
			. '</span>';
		}
		return $ret_str;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief  表示(継承して使用)
	@return なし
	*/
	//--------------------------------------------------------------------------------------
	public function display(){
		$name_str = "{$this->param_arr['head']}名";
		$prefec_str = "{$this->param_arr['head']}都道府県";
		$address_str = "{$this->param_arr['head']}市区郡町村以下";
//PHPブロック終了
?>
<tr>
<th class="text-center"><?= $name_str ?></th>
<td width="70%"><?= $this->get_name(); ?></td>
</tr>
<tr>
<th class="text-center"><?= $prefec_str ?></th>
<td width="70%"><?= $this->get_prefecture_select(); ?></td>
</tr>
<tr>
<th class="text-center"><?= $address_str ?></th>
<td width="70%"><?= $this->get_address(); ?></td>
</tr>
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




