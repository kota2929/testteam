$(document).ready(function() {
  // サムネイル画像のクリックイベントを設定
  $('.thumb-image').on('click', function() {
    // 選択されたサムネイル
    var $selectedThumbnail = $(this);
    // 現在のメイン画像のソース
    var currentMainImageSrc = $('#mainImage').attr('src');
    // クリックされたサムネイルのソース
    var newMainImageSrc = $selectedThumbnail.attr('src');

    // 選択されたサムネイルが現在のメイン画像でない場合のみメイン画像を変更
    if (currentMainImageSrc !== newMainImageSrc) {
      $('#mainImage').attr('src', newMainImageSrc);
    }
  });
});
