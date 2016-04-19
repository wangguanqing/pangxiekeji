
$(function(){
	$.foucs({ direction: 'right' });
	//今日爆款
	var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        slidesPerView: 3,
        paginationClickable: true,
        spaceBetween: 30,
        loop : true,
        autoplay:3500,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        freeMode: true
    });
});








