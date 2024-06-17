<link rel="stylesheet" href="../css/sinkitouroku.css">
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


      <!-- コンテンツ -->
      <main class="container mt-4">

        <p class="p1">新規会員登録</p>

        <div class="ZXx">
          <table align="center">
            <tr>
              <th>メールアドレス</th>
              <td>
                <form action="#" method="post">

                  <input type="text" class="g1" name="name">
                </form>
              </td>
            </tr>
            <tr>
              <th>パスワード</th>
              <td>
                <form action="#" method="post">

                  <input type="text" class="g1" name="name">
                </form>
              </td>
            </tr>
            <tr>
              <th>郵便番号</th>
              <td>
                <form action="#" method="post">

                  <input type="text" class="g1" name="name">
                </form>
              </td>
            </tr>

          </table>
          <table align="center">
            <tr>
              <th class="fg">生年月日</th>
              <td>
                <form action="#" method="post">

                  <input type="text" class="g2" name="name">
                </form>
              <th class="hg">年</th>
              <td>
                <form action="#" method="post">

                  <input type="text" class="g2" name="name">
                </form>
              <th class="hg">月</th>
              <td>
                <form action="#" method="post">

                  <input type="text" class="g2" name="name">
                </form>
              <th>日</th>
              </td>
          </table>
          <table align="center">
            <tr>
              <th>年齢</th>
              <td>
                <form action="#" method="post">

                  <input type="text" class="g3" name="name">
                </form>
              </td>
            </tr>
            <tr>
              <th>身長</th>
              <td>
                <form action="#" method="post">

                  <input type="text" class="g3" name="name">
                </form>
              </td>
            </tr>
            <tr>
              <th>体重</th>
              <td>
                <form action="#" method="post">

                  <input type="text" class="g3" name="name">
                </form>
              </td>
              <th class="ug"></th>
            </tr>
            <tr>
              <th>ウエスト</th>
              <td>
                <form action="#" method="post">

                  <input type="text" class="g3" name="name">
                </form>
              </td>
            </tr>

          </table>
          <button onclick="">
            登録
          </button>
        </div>
        <br><br>
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