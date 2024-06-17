document.addEventListener('DOMContentLoaded', function() {
    // 1ページ戻る関数
    function BackForm(){
        document.getElementById('backButton').addEventListener('click', function () {
            window.history.back();
        });
    }

    // 2ページ戻る関数
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