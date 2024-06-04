document.addEventListener('DOMContentLoaded', function() {
    // history.back() を使用する関数
    function BackForm(){
        document.getElementById('backButton').addEventListener('click', function () {
            window.history.back();
        });
    }

    // 2つのhistory.back()を使用する関数
    function BackForm2(){
        document.getElementById('2backButton').addEventListener('click', function () {
            window.history.back();
            window.history.back();
        });
    }

    // 関数を呼び出してイベントリスナーを設定
    BackForm();
    BackForm2();
});
