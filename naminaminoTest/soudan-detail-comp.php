<?php
/*!
@file hinagata.php
@brief ページ作成の雛形ファイル
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

//管理者用ライブラリをインクルード
require_once("../Uru_test/URUCOMMON/common/libs.php");
//mng.jsはcommonのcontents_nodes.phpに読み込むよう書いてある

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
		<div class="contents">
			<main class="container mt-4">
				<!--pageタイトル-->
				<h1>回答が送信されました</h1>

				<div class="center">
					<p>
						<button type="button" onclick="window.location.href='mypage-admin.php'" class="btn btn-outline-success">管理者マイページへ戻る</button>
					</p>
					<!-- 修正後 -->
					<p>
						<button id="2backButton" class="btn btn-outline-success">相談一覧ページへ戻る</button>
					</p>
					<p>
						<button id="3backButton" class="btn btn-outline-success">管理者マイページへ戻る</button>
					</p>

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