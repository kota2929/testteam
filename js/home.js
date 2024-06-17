$('.slider').slick({
  autoplay: true,
  infinite: true,
  speed: 500,
  slidesToShow: 3,
  slidesToScroll: 1,
  prevArrow: '<div class="slick-prev"></div>',
  nextArrow: '<div class="slick-next"></div>',
  centerMode: true,
  variableWidth: true,
  dots: true,
});
function updateProductList(filter, value) {
  $.get('your_php_file.php', { filter: filter, value: value }, function(response) {
      $('.product-card-container').html($(response).find('.product-card-container').html());
  });
}
