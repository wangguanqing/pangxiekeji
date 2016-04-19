//回到顶部插件
;(function($){
	$.fn.moveTop=function(iTarget,callBackFn){
		iTarget = iTarget || 0;
   		var obj = this;

   		clearInterval(obj.timer);
        var curScrollTop= $(document).scrollTop();
        obj.timer=setInterval(function(){
            var speed = (iTarget-curScrollTop)/6;
            speed=speed>0?Math.ceil(speed):Math.floor(speed);
            curScrollTop+=speed;
            $(document).scrollTop(curScrollTop);
            if(curScrollTop==iTarget){
                clearInterval(obj.timer);
                lock=false;
                callBackFn && callBackFn();
            }
        },30);
    }
})(jQuery);
$(function(){
    $(window).scroll(function(){
        var scrollH = $(window).scrollTop();
        var height = $(window).height();
        if(scrollH > height){
            $('.r-menu').fadeIn();
        }else{
            $('.r-menu').fadeOut();
        }
    });
	$(".go-top").on("click",function(){
		$(this).moveTop();
	});
});








