<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrapで<a>タグをボタンにする</title>
    <!-- BootstrapのCSSをインクルード -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>リンクをボタンのようにスタイリングする</h2>
        
        <!-- Bootstrapのボタンスタイルを適用した<a>タグ -->
        <a href="https://example.com" class="btn btn-primary">Primary Button</a>
        <a href="https://example.com" class="btn btn-secondary">Secondary Button</a>
        <a href="https://example.com" class="btn btn-success">Success Button</a>
        <a href="https://example.com" class="btn btn-danger">Danger Button</a>
        <a href="https://example.com" class="btn btn-warning">Warning Button</a>
        <a href="https://example.com" class="btn btn-info">Info Button</a>
        <a href="https://example.com" class="btn btn-light">Light Button</a>
        <a href="https://example.com" class="btn btn-dark">Dark Button</a>
        <a href="https://example.com" class="btn btn-link">Link Button</a>
    </div>

    <!-- BootstrapのJavaScriptと依存するポッパーとjQueryをインクルード -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
