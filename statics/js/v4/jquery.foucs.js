; (function ($) {
    $.extend({
        'foucs': function (con) {
            var $container = $('#indexSlide')
                , $imgs = $container.find('li.hero')
            , $leftBtn = $container.find('a.prev')
            , $rightBtn = $container.find('a.next')
            , config = {
                interval: con && con.interval || 3500,
                animateTime: con && con.animateTime || 500,
                direction: con && (con.direction === 'right'),
                _imgLen: $imgs.length,
                slideWid: con && con.slideWid || 960
            }
            , i = 0
            , getNextIndex = function (y) { 
                return i + y >= config._imgLen ? i + y - config._imgLen : i + y; 
            }
            , getPrevIndex = function (y) { 
                return i - y < 0 ? config._imgLen + i - y : i - y; 
            }
            , silde = function (d) {

                $imgs.eq((d ? getPrevIndex(2) : getNextIndex(2))).css('left', (d ? '-'+ config.slideWid * 2 +'px' : config.slideWid * 2 +'px'));
                $imgs.eq((d ? getPrevIndex(3) : getNextIndex(3))).css('left', (d ? '-'+ config.slideWid * 3 +'px' : config.slideWid * 3 +'px'));
                $imgs.animate({
                    'left': (d ? '+' : '-') + '='+ config.slideWid +'px'
                }, config.animateTime);
                i = d ? getPrevIndex(1) : getNextIndex(1);
            }
            , s = setInterval(function () { silde(config.direction); }, config.interval);
            $imgs.eq(i).css('left', 0).end().eq(i + 1).css('left', config.slideWid+'px').end().eq(i - 1).css('left', '-' +config.slideWid+ 'px');
            if(config._imgLen > 5){
                $imgs.eq(i+2).css('left',config.slideWid*2+'px').end().eq(i-2).css('left','-' +config.slideWid*2+'px');
            };
            $container.find('.hero-wrap').add($leftBtn).add($rightBtn).hover(function () { clearInterval(s); }, function () { s = setInterval(function () { silde(config.direction); }, config.interval); });
            $leftBtn.click(function () {
                if ($(':animated').length === 0) {
                    silde(false);
                }
            });
            $rightBtn.click(function () {
                if ($(':animated').length === 0) {
                    silde(true);
                }
            });
        }
    });
}(jQuery));