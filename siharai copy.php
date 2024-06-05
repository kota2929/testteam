<?php
/*!
@file hinagata.php
@brief ページ作成の雛形ファイル
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

//ライブラリをインクルード


$err_array = array();
$err_flag = 0;
$page_obj = null;


//--------------------------------------------------------------------------------------
///	本体ノード
//--------------------------------------------------------------------------------------

//PHPブロック終了
?>
<!-- コンテンツ　-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>お支払い</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <style>
  
.left{
      float: left;
      
    }
    .clear{
      clear: both;
    }
 h1{
    font-size: 25px;
 }
 .right{
      float: right;

    }
.righ{
    /*コレ追加*/width: 30%;

}
.rih{
    
                padding: 0% 60% 
}
.box{width: 20%; border:#ffffff;}
.box1{
    width:45%;
      height:120px;
      border:#ffffff;
}
.box2{
    width: 80%;
      height:100px;
      border:#ffffff;
}
.box3{
    width: 13%;
      height:130px;
      background-color: rgb(181, 178, 176);
      border:#ffffff;
}
button{
    
    

    padding: 7px 20px;
  border-radius: 25px;
    font: bold 10px sans-serif;
    text-decoration:none;
    
    border:rgb(2, 229, 250) 2px solid;
    display: block;
    margin: auto;
    background: rgb(2, 229, 250);
    color: #FFF;
}

.huj{
    color: #000000;
    margin-left:20px;
}


  </style>
   <body>
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
					<a href="mahune/toiawase.php" class="text-dark">お問い合わせ</a>
				  </li>
				  <li>
					<a href="FAQ.php" class="text-dark">よくある質問</a>
				  </li>
				  <li>
					<a href="purapo.php" class="text-dark" >返品ポリシー</a>
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
		<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
		<script src="js\index.js"></script>
	  
	  </body>

    <!-- コンテンツ -->
    <main class="container mt-4">

    
      <h1>お届け先・配送方法・お支払い方法</h1>
      <hr>
      
      <div class="left box"><p>お届け先</p></div>
      <div class="left box1"><p>田中太郎</p>
        <p>〒XXX-XXXX</p>
        <p>東京都中央区XXXXXXXXX</p>
        </div>
        <div class="left box3"><p>小計</p>
                               <p>￥7,480</p>
                               <button onclick="">
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
                <a href="#" class="text-dark">お問い合わせ</a>
              </li>
              <li>
                <a href="#" class="text-dark">よくある質問</a>
              </li>
              <li>
                <a href="#" class="text-dark">返品ポリシー</a>
              </li>
            </ul>
          </div>
          <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
            <h5 class="text-uppercase">フォローする</h5>
            <ul class="list-unstyled mb-0">
              <li>
                <a href="#" class="text-dark"><i class="bi bi-facebook"></i> Facebook</a>
              </li>
              <li>
                <a href="#" class="text-dark"><i class="bi bi-twitter"></i> Twitter</a>
              </li>
              <li>
                <a href="#" class="text-dark"><i class="bi bi-instagram"></i> Instagram</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2024 会社名
      
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
  </body>
<div class="contents">

<h5><strong>雛形ファイル</strong></h5>
※このファイルは雛形ファイルです。
</div>
<!-- /コンテンツ　-->
<?php 
//PHPブロック再開
	
	//--------------------------------------------------------------------------------------
	/*!
	@brief	デストラクタ
	*/
	//--------------------------------------------------------------------------------------
	
?>
