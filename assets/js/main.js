$(function() {
    // tab
    $(".tab")
        .find("li > a")
        .click(function() {
            var tabv = $(this).attr("data-tabs");
            $(this).parent().addClass("active");
            $(this).parent().siblings("li").removeClass("active");
            $(this).closest(".tab-ov").find(".tab-con").addClass("hide");
            $(this)
                .closest(".tab-ov")
                .find(".tab-con" + tabv)
                .removeClass("hide");
        });

    // visual-slide
    $(".visual-slide").owlCarousel({
        items: 4,
        autoHeight: false,
        loop: true,
        margin: 30,
        mouseDrag: true,
        touchDrag: true,
        nav: false,
        autoplay: true,
        dots: true,
        autoplayTimeout: 6000,
        autoplayHoverPause: false,
        autoWidth: false,
        responsiveRefreshRate: 5,
        responsive: {
            0: {
                items: 1,
                margin: 25,
            },
            480: {
                items: 2,
                margin: 35,
            },
            780: {
                items: 3,
                margin: 35,
            },
            999: {
                items: 4,
                margin: 35,
            },
        },
    });
    // banner 슬라이드 수정
    $(".vis")
        .find(".next")
        .click(function() {
            $(".visual-slide").trigger("next.owl.carousel");
            $(".visual-slide").trigger('play.owl.autoplay', [6000]);
        });
    $(".vis")
        .find(".prev")
        .click(function() {
            $(".visual-slide").trigger("prev.owl.carousel", [600]);
        });

    // forum-slide
    $(".forum-slide").owlCarousel({
        items: 3,
        autoHeight: false,
        loop: true,
        margin: 30,
        mouseDrag: true,
        touchDrag: true,
        nav: false,
        autoplay: true,
        dots: true,
        autoplayTimeout: 6000,
        autoplayHoverPause: false,
        autoWidth: false,
        responsiveRefreshRate: 5,
        responsive: {
            0: {
                items: 1,
                margin: 20,
            },
            480: {
                items: 2,
                margin: 20,
            },
            780: {
                items: 2,
                margin: 30,
            },
            999: {
                items: 3,
                margin: 30,
            },
        },
    });
    // 메인 포럼(forum 슬라이드) 포럼 슬라이드
    $(".msec-03")
        .find(".next")
        .click(function() {
            $(".forum-slide").trigger("next.owl.carousel");
        });
    $(".msec-03")
        .find(".prev")
        .click(function() {
            $(".forum-slide").trigger("prev.owl.carousel", [600]);
        });
});

function sizeControlMain(width) {
    width = parseInt(width);
    var bodyHeight = document.documentElement.clientHeight;
    var bodyWidth = document.documentElement.clientWidth;
    var chkHeader = $("#header-wrap").outerHeight();
    var chkFooter = $("#footer").outerHeight();
    var docW = window.innerWidth;
}
jQuery(function($) {
    sizeControlMain($(this).width());
    $(window).resize(function() {
        if (this.resizeTO) {
            clearTimeout(this.resizeTO);
        }
        this.resizeTO = setTimeout(function() {
            $(this).trigger("resizeEnd");
        }, 10);
    });
});
$(window).on("resizeEnd", function() {
    sizeControlMain($(this).width());
});
$(window).load(function() {
    sizeControlMain($(this).width());
});