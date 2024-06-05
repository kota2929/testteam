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
<main class="container mt-4">

    
      <h1 class="h1">お届け先・配送方法・お支払い方法</h1>
      <hr>
      
      <div class="left box"><p>お届け先</p></div>
      <div class="left box1"><p>田中太郎</p>
        <p>〒XXX-XXXX</p>
        <p>東京都中央区XXXXXXXXX</p>
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
        <div class="left box2"> <input type="radio"  name="q1"  value="通常配送">通常配送 <p1>○月×日～○月△日 発送予定</p1><div> 
            <input type="radio"  name="q1"  value="日時指定">日時指定</div>
          
            <select class=" huj" name="name" id="nme">
              <option  value="who">--- ×月○日 ---</option>
              <option value="1月">1月</option>
              <option value="2月">2月</option>
              <option value="3月">3月</option>
              <option value="4月">4月</option>
              <option value="5月">5月</option>
              <option value="6月">6月</option>
              <option value="7月">7月</option>
             
            </select>
           
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
        <div class="left box2"> <input type="radio"  name="q1"  value="通常配送">クレジットカード <br>
            <p1>+クレジットカードの追加</p1><div> 
            <input type="radio"  name="q1"  value="日時指定">コンビニ払い</div>
                
            
            
                
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

