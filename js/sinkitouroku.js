function fetchAddress() {
    const postcode = document.getElementById('postcode').value;
    if (postcode.length === 7) {
        fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${postcode}`)
            .then(response => response.json())
            .then(data => {
                if (data.results) {
                    const result = data.results[0];
                    document.getElementById('prefecture').value = result.address1;
                    document.getElementById('city').value = result.address2;
                    document.getElementById('address').value = result.address3;
                }
            })
            .catch(error => console.error('Error:', error));
    }
}

function submitForm() {
    // 未記入のテキストボックスがあるかどうかをチェック
    var inputs = document.querySelectorAll('.input-text');
    var incompleteFields = [];

    inputs.forEach(function(input) {
        if (input.value === "") {
            incompleteFields.push(input);
        }
    });

    // 未記入のテキストボックスのタイトルに赤文字でメッセージを表示
    incompleteFields.forEach(function(field) {
        var label = field.parentElement.querySelector('label');
        label.style.color = 'red';
    });

    // 未記入の項目があればフォームの送信をキャンセル
    if (incompleteFields.length > 0) {
        alert("未記入の項目があります。赤色で表示されています。");
        return false;
    }

    // 未記入の項目がなければフォームを送信
    document.querySelector('form').submit();
}

