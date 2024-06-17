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


function toggleFavorite(event, button) {
    // Toggle favorite class to change color
    button.classList.toggle('favorite-active');
    
    // Display message
    if (button.classList.contains('favorite-active')) {
        alert('お気に入りに登録しました');
    }
    
    // Prevent default button behavior
    event.preventDefault();
}