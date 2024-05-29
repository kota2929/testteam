function toggleFavorite(event, element) {
  event.stopPropagation(); // イベントの伝播を停止
  event.preventDefault(); // デフォルトの動作を停止（必要なら）

  // お気に入りのトグル処理をここに追加
  element.classList.toggle('favorite');
}