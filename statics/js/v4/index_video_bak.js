
$(function(){
	var swiper = new Swiper('.swiper1', {
        pagination: '.swiper-pagination',
        slidesPerView: 3,
        paginationClickable: true,
        spaceBetween: 10,
        loop : true,
        autoplay:3500,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        freeMode: true
    });
    $(".column-nav a").mouseenter(function(event) {
        var index = $(this).index();
        $(".column-nav a").removeClass('active');
        $(".column-box .column-list").removeClass("show").addClass('hide');
        $(this).addClass('active');
        $(".column-box .column-list").eq(index).removeClass('hide').addClass('show');
    });
});








