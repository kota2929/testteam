document.addEventListener('DOMContentLoaded', function () {
    // 1ページ戻る
    function backOnePage() {
        window.history.back();
    }

    // イベントリスナーを追加
    var button1 = document.getElementById('backButton');
    if (button1) {
        // イベントリスナーが重複しないように、一度だけ追加する
        button1.removeEventListener('click', backOnePage); // 既存のリスナーを削除
        button1.addEventListener('click', backOnePage);
    }


    // 2ページ戻る
    function backTwoPages() {
        window.history.go(-2);
    }

    // 3ページ戻る
    function backThreePages() {
        window.history.go(-3);
    }

    // イベントリスナーを追加
    var button1 = document.getElementById('backButton');
    if (button1) {
        button1.addEventListener('click', backOnePage);
    }

    var button2 = document.getElementById('2backButton');
    if (button2) {
        button2.addEventListener('click', backTwoPages);
    }

    var button3 = document.getElementById('3backButton');
    if (button3) {
        button3.addEventListener('click', backThreePages);
    }
});


function deleteProduct(productId) {
    if (confirm('本当にこの商品を削除しますか？')) {
        fetch('delete_product.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'product_id=' + productId,
        })
            .then(response => response.text())
            .then(data => {
                alert(data);
                // 削除成功後、該当行を削除
                document.getElementById('row_' + productId).remove();
            })
            .catch(error => console.error('Error:', error));
    }
}