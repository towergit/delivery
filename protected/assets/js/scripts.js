$(document).ready(function () {
    $('.nav').children('.dropdown').hover(function () {
        $(this).addClass('open');
    }, function () {
        $(this).removeClass('open');
    });

    function scroll() {
        $(window).scroll(function () {
            var top = $(this).scrollTop();
            if (top > 150)
                $('.menu-panel').css('position', 'fixed').addClass('animated fadeInDown menu-block');
            $('.menu-panel').css('top', 0);
            if (top < 130)
                $('.menu-panel').css('position', 'relative').removeClass('animated fadeInDown menu-block');

            if ($('.navigation').length) {
                if (top > 250) {
                    var nleft = $('.navigation').offset().left
                    $('.navigation').css({'position': 'fixed', 'top': '25px', 'left': nleft});
                }
                if (top < 250) {
                    $('.navigation').css({'position': 'relative', 'top': '0', 'left': '0'});
                }
                var nbottom = ($('.navigation').parents().height() + $('.navigation').parents().offset().top) - $('.navigation').height();
                if (top > nbottom) {
                    ntop = nbottom - top;
                    $('.navigation').css({'top': ntop});
                }
            }


        });
    }
    scroll();

    $('.dropdown-menu li.active').parents('li').addClass('active');

    $(".anchor-coments").click(function () {
        var id = $(this).attr('href'),
                top = $(id).offset().top;
        $('body,html').animate({scrollTop: top}, 1500);
    });

});