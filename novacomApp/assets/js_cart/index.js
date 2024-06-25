var cart = $('.b-cart'),
    cartCountCont = cart.find('.b-cart__count'),
    cartCount = parseInt(cartCountCont.text(), 10),
    addToCart = $('.b-items__item__add-to-cart');

addToCart.on('click', function (evt) {
  evt.preventDefault();
  evt.stopPropagation();
  
 
  
  var el = $(this),
      item = el.parent(),
      img = item.find('.b-items__item__img'),
      cartTopOffset = cart.offset().top - item.offset().top,
      cartLeftOffset = cart.offset().left - item.offset().left;
  
  var flyingImg = $('<img class="b-flying-img">');
 
 // flyingImg.attr('src', img.attr('src'));
  flyingImg.attr('src','http://demo1.igainspark.com/mobile/img/added.jpg');
  flyingImg.css('width', '200').css('height', '200');
  cartCount += 1;

 flyingImg.animate({
    top: cartTopOffset,
    left: cartLeftOffset,
    width: 50,
    height: 50,
	margin: 160,
    opacity: 0.1
  }, 800, function () {
    flyingImg.remove();
    cartCountCont.text(cartCount);
  });
  
  el.parent().append(flyingImg);
});