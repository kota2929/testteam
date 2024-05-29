$('nav').prepend('<div class="toggle"></div>');
$('.toggle').css({
    'width':'100%',
    'height':'50px',
    'background-color':'#fff',
    'color':'#fff',
    'text-align':'center',
    'line-height':'50px'
});
$(window).on('load resize',function(){
    var winWidth = $(window).width();
    if(winWidth < 900){
        $('.toggle').show();
        $('nav>ul').hide();
        $('main').css('margin-left', '0'); // 追加
    } else{
        $('.toggle').hide();
        $('nav>ul').show();
        $('main').css('margin-left', 'auto'); // 追加
    }
});

$(window).on('resize', function(){ // 追加
    var winWidth = $(window).width();
    if(winWidth >= 700){
        $('main').css('margin-left', 'auto');
    }
});


var opener = close;//flagでクリックしたときのアコーディオンの開くまでの時間を調節
//ウィンドウサイズ700px以下の時の動作
$('nav>ul>li>a').on('click',function(){
    var winWidth = $(window).width();
    if(winWidth < 700){//ウィンドウサイズ700px以下なら
        if($(this).hasClass('open')){//クリックした要素がopenクラスを持っているなら
            $(this).removeClass('open');
            $(this).next('ul').slideUp();
            opener = close;
        } else{//クリックした要素がopenクラスを持っていないなら
            var timer;//アコーディオンが開くまでの遅延時間
            console.log(opener);
            if(opener !== close){
                timer = 500;
            }else{
                timer = 0;
            }
            $('.open').removeClass('open');
            $('nav>ul>li>a').next('ul').slideUp();
            setTimeout(()=>{
                $(this).addClass('open');
                $(this).next('ul').slideDown();
            },timer);
            opener = open;
        }
        event.preventDefault();
    }else{//ウィンドウサイズ700px以上なら
        return false;
    }
});

//ウィンドウサイズ700px以上の時の動作
$('nav>ul>li').on('mouseover',function(){//マウスをのせたとき
    var winWidth = $(window).width();
    if(winWidth > 700){//ウィンドウサイズ700px以上なら
        if(!$(this).children('a').hasClass('open')){
            $(this).children('a').addClass('open');
            $(this).children('ul').stop().slideDown();
        }
    }else{//ウィンドウサイズ700px以下なら
        return false;
    }
}).on('mouseout',function(){
    var winWidth = $(window).width();
    if(winWidth > 700){//ウィンドウサイズ700px以上なら
        $(this).children('a').removeClass('open');
        $(this).children('ul').stop().slideUp();
    }else{//ウィンドウサイズ700px以下なら
        return false;
    }
});
$('nav>ul>li>a').on('click',function(){
    event.preventDefault();
});

document.addEventListener('DOMContentLoaded', function() {
    var navbarCollapse = document.getElementById('navbarNav');
    var mainContent = document.querySelector('main');

    navbarCollapse.addEventListener('show.bs.collapse', function() {
      mainContent.style.marginTop = '200px'; // Adjust this value based on the height of the expanded menu
    });

    navbarCollapse.addEventListener('hide.bs.collapse', function() {
      mainContent.style.marginTop = '0';
    });
  });