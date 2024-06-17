// JavaScriptで郵便番号から住所を自動入力する関数
function fillAddressByZip() {
    var zipcode = document.getElementById("zipcode").value;
    // 郵便番号のAPIを呼び出して、都道府県、市区町村、番地、建物名・部屋番号を取得する処理をここに追加する
    // ここでは、例として郵便番号APIのURLを示します（実際のURLに置き換える必要があります）
    var apiUrl = "https://example.com/api/zipcode/" + zipcode;
    
    // 郵便番号APIにリクエストを送る
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            // APIから取得したデータを使ってフォームに自動入力する
            document.getElementById("prefecture").value = data.prefecture;
            document.getElementById("city").value = data.city;
            document.getElementById("street").value = data.street;
            document.getElementById("building").value = data.building;
        })
        .catch(error => {
            console.error('郵便番号APIからのデータ取得エラー:', error);
            // エラーが発生した場合の処理を追加する（例：エラーメッセージを表示するなど）
        });
}


// フォームの送信時に入力をチェックする関数
function validateForm() {
    // 入力された値を取得
    var name = document.getElementById("name").value;
    var furigana = document.getElementById("furigana").value;
    var username = document.getElementById("username").value;
    var zipcode = document.getElementById("zipcode").value;
    var prefecture = document.getElementById("prefecture").value;
    var city = document.getElementById("city").value;
    var street = document.getElementById("street").value;
    var building = document.getElementById("building").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    // 入力が不足している場合にアラートを表示してフォームの送信を中止する
    if (name === "" || furigana === "" || username === "" || zipcode === "" || 
        prefecture === "" || city === "" || street === "" || building === "" || 
        email === "" || password === "") {
        alert("全ての項目を入力してください");
        return false; // フォームの送信を中止
    }
    // ここで他の入力チェックを追加することもできます（例：メールアドレスの形式チェックなど）
    return true; // フォームの送信を継続
}
