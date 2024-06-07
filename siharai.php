<link rel="stylesheet" href="css/siharai.css">
<?php
/*!
@file hinagata.php
@brief ページ作成の雛形ファイル
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

//ライブラリをインクルード
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
//PHPブロック終了
?>
<!-- コンテンツ　-->

<div class="container col-6">
      <h1 class="h1">お届け先・配送方法・お支払い方法</h1>
      <hr>
      
      <div class="left box"><p>お届け先</p></div>
      <div class="left box1"><input type="radio"  name="q1"  value=""><p>田中太郎</p>
        <p>〒XXX-XXXX</p>
        <p>東京都中央区XXXXXXXXX</p><input type="radio"  name="q1"  value=""><label>
  <span>住所変更</span>
  <input type="checkbox" name="checkbox">
<div id="popup">
<main class="container mt-4">
<main class="container mt-4">
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="postal_api.js"></script>

<head>
  
  
    <h1 style="text-align: center; margin-top: 2.4rem; margin-bottom: 1.6rem">入力フォーム</h1>
    <div>
      <form method="post" action="#" >
        郵便番号<br />
        <input type="text" name="zip_code"  id="zip_code">
        <input type="button" value="住所検索" id="search_address_btn">
        <input type="button" value="クリア" id="search_clear_btn">
        <br />
        都道府県<br />
        <input type="text" name="address1"  id="address1"><br />
        市区町村<br />
        <input type="text" name="address2"  id="address2"><br />
        その他<br />
        <input type="text" name="address3"  id="address3"><br />
        建物名など<br />
        <input type="text" name="address4" ><br />
        <br />
        <div class="submit_button_right" >
          <input type="submit"><br />
        </div>
      </form>
    </div>
  </div>
  </head>
</div>
</label>
		
        </div>
        <div class="left box3"><p>小計</p>
                               <p>￥7,480</p>
                               <button class="submit-btn" type="submit" onclick="submitForm()">
                                会計へ
                            </button>

        </div>
      
    
        
        <div class="clear">
            <hr>
        <div class="left box"><p>配送方法</p></div>
        <div class="left box2"> <input type="radio"  name="q2"  value="通常配送">通常配送 <p1>○月×日～○月△日 発送予定</p1><div> 
            <input type="radio"  name="q2"  value="日時指定">日時指定</div>
          
            <select class=" huj" name="name" id="dateSelector"></select>
            <script>
document.addEventListener("DOMContentLoaded", function() {
  var select = document.getElementById("dateSelector");
  var today = new Date();
  
  // 今日から一週間後までの日付をループして追加
  for (var i = 0; i < 7; i++) {
    var date = new Date();
    date.setDate(today.getDate() + i);
    var month = date.getMonth() + 1; // 月は0から始まるため
    var day = date.getDate();
    
    var option = document.createElement("option");
    option.text = month + "月 " + day + "日";
    option.value = date.toISOString(); // オプションの値としてISO 8601形式の日付を使用
    select.add(option);
  }
});
</script>
            <select class=" huj"name="name" id="name">
              <option  value="who">--- 午前--午後 ---</option>
              <option value="午前中">午前中</option>
              <option value="午後中">午後中</option>
             
            </select>
          </div>
    </div>
    <div class="clear"></div>
            <hr>
        <div class="left box"><p>配送方法</p></div>
        <div class="left box2"> <input type="radio"  name="q3"  value="通常配送">クレジットカード <br>
            <p1>+クレジットカードの追加</p1><div> 
            <input type="radio"  name="q3"  value="日時指定">コンビニ払い</div>
                
            
            
                
    </div>
	<div class="clear"></div>
      <!-- 他のコンテンツがここに入ります -->
    </main>
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

?>

