document.addEventListener("DOMContentLoaded", function() {
    // エラーメッセージを表示する
    const errors = window.errors || {};
    for (const field in errors) {
        if (errors.hasOwnProperty(field)) {
            const errorMessage = errors[field];
            document.getElementById(field + "-error").textContent = errorMessage;
        }
    }
    if (window.emailError) {
        document.getElementById("global-error").textContent = window.emailError;
    }

    // 登録ボタンとスキップボタンのイベントリスナーを追加
    document.getElementById("show-body-info-form").addEventListener("click", function() {
        document.getElementById("body-info-form").style.display = "block";
    });

    document.getElementById("skip-body-info").addEventListener("click", function() {
        window.location.href = "rogin.php"; // スキップの場合の遷移先を指定
    });
});
