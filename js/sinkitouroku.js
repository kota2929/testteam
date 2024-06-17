$(document).ready(function() {
    const form = document.querySelector(".register-form");
    const zipcodeInput = document.getElementById("zipcode");

    form.addEventListener("submit", function(event) {
        event.preventDefault();
        let isValid = true;

        // Clear previous error messages
        document.querySelectorAll(".error-message").forEach(function(error) {
            error.textContent = "";
        });

        // Validation functions
        function showError(inputId, message) {
            const inputElement = document.getElementById(inputId);
            const errorElement = document.getElementById(inputId + "-error");
            errorElement.textContent = message;
            if (isValid) {
                inputElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            isValid = false;
        }

        function isEmpty(value) {
            return value.trim() === "";
        }

        function isValidName(name) {
            return /\S+\s+\S+/.test(name);
        }

        function isValidZipcode(zipcode) {
            return /^\d{7}$/.test(zipcode);
        }

        // Form data
        const name = form.elements["name"].value.trim();
        const username = form.elements["username"].value.trim();
        const email = form.elements["email"].value.trim();
        const password = form.elements["password"].value.trim();
        const zipcode = form.elements["zipcode"].value.trim();
        const prefecture = form.elements["prefecture"].value.trim();
        const city = form.elements["city"].value.trim();
        const street = form.elements["street"].value.trim();
        const buildingRoom = form.elements["building-room"].value.trim();

        // Validate fields
        if (isEmpty(name)) {
            showError("name", "本名を入力してください");
        } else if (!isValidName(name)) {
            showError("name", "姓と名の間に半角スペースを入力してください");
        }

        if (isEmpty(username)) {
            showError("username", "ユーザーネームを入力してください");
        }

        if (isEmpty(email)) {
            showError("email", "メールアドレスを入力してください");
        } else if (!/\S+@\S+\.\S+/.test(email)) {
            showError("email", "正しいフォーマットで入力してください");
        }

        if (isEmpty(password)) {
            showError("password", "パスワードを入力してください");
        } else if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(password)) {
            showError("password", "８桁以上の英数字でパスワードを設定してください");
        }

        if (isEmpty(zipcode)) {
            showError("zipcode", "郵便番号を入力してください");
        } else if (!isValidZipcode(zipcode)) {
            showError("zipcode", "ハイフン無し、半角数字７桁で入力してください");
        }

        if (isEmpty(prefecture)) {
            showError("prefecture", "都道府県を選択してください");
        }

        if (isEmpty(city)) {
            showError("city", "市区町村を入力してください");
        }

        if (isEmpty(street)) {
            showError("street", "番地を入力してください");
        }

        if (isEmpty(buildingRoom)) {
            showError("building-room", "建物名・部屋番号を入力してください");
        }

        // If no errors, submit the form
        if (isValid) {
            form.submit();
        }
    });

   // Automatically fill address fields based on zipcode
   $('#zipcode').on('input', function() {
    var zipcode = $(this).val();
    // 郵便番号をAPIに送信して住所を取得する
    $.getJSON('https://api.zipaddress.net/?zipcode=' + zipcode, function(data) {
        // 取得した住所を表示する
        if (data.code === 200) {
            $('#prefecture').val(data.data.pref);
            $('#city').val(data.data.city);
            $('#street').val(data.data.town);
            // Reset building-room field
            $('#building-room').val('');
            clearErrorMessage(document.getElementById("zipcode"));
        } else {
            // エラーメッセージを表示する
            $('#prefecture').val('');
            $('#city').val('');
            $('#street').val('');
            $('#building-room').val('');
            displayErrorMessage(document.getElementById("zipcode"), "有効な郵便番号を入力してください。");
        }
    });
});

});
