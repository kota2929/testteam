$(document).ready(function(){

    // 住所検索ボタンを押すと外部apiを叩く処理が走る。
    $('#search_address_btn').click(function() {
        $.getJSON('http://zipcloud.ibsnet.co.jp/api/search?callback=?',
            {
            zipcode: $('#zip_code').val()
            }
        )
        .done(function(data) {
            if (!data.results) {
                alert('該当の住所がありません');
            } else {
                let result = data.results[0];
                $('#address1').val(result.address1);
                $('#address2').val(result.address2);
                $('#address3').val(result.address3);
            }
        }).fail(function(){
            alert('入力値を確認してください。');
        })
    })

    // クリアボタンを押すと、フォームの中身がリセットされる。
    $('#search_clear_btn').click(function(){
        $('#zip_code').val('');
        $('#address1').val('');
        $('#address2').val('');
        $('#address3').val('');
    })
})