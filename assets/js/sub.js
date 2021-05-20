$(function() {
    // vnews-slide
    $(".vnews-slide").owlCarousel({
        items: 4,
        autoHeight: false,
        loop: $(".vnews-slide .owl-item").length > 4,
        // loop: true,
        margin: 15,
        mouseDrag: true,
        touchDrag: true,
        nav: false,
        autoplay: false,
        dots: true,
        autoplayTimeout: 3500,
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
                items: 3,
                margin: 20,
            },
            999: {
                items: 4,
                margin: 20,
            },
        },
    });

    $(".board-wrap")
        .find(".list.notice")
        .find("tbody > tr.notice")
        .each(function() {
            var firstTH = $(this).find("td:first-child > span").outerWidth();
            $(this)
                .find("td:nth-child(2)")
                .css({ "padding-left": firstTH + 20 });
        });

    $(".sel-btn").click(function() {
        $(".sel-box").find("ul").stop().slideUp();

        if ($(this).hasClass("active")) {
            $(".sel-box").find(".sel-btn").removeClass("active");
            $(this).removeClass("active");
            $(this).parent().find("ul").stop().slideUp();
        } else {
            $(".sel-box").find(".sel-btn").removeClass("active");
            $(this).addClass("active");
            $(this).parent().find("ul").stop().slideDown();
        }
    });

    $(".sel-box")
        .find("li > a")
        .click(function() {
            var istxt = $(this).find("span").text();
            $(this).closest(".sel-box").find(".sel-btn > span").text(istxt);
            $(this).parent().addClass("active");
            $(this).parent("li").siblings("li").removeClass("active");
            $(".sel-box").find(".sel-btn").removeClass("active");
            $(".sel-box").find("ul").stop().slideUp();
        });

    // forum-slide
    $(".forum-slide").owlCarousel({
        items: 4,
        autoHeight: false,
        loop: true,
        margin: 20,
        mouseDrag: true,
        touchDrag: true,
        nav: false,
        autoplay: false,
        dots: true,
        autoplayTimeout: 3500,
        autoplayHoverPause: false,
        autoWidth: false,
        responsiveRefreshRate: 5,
        responsive: {
            0: {
                items: 1,
                margin: 15,
            },
            480: {
                items: 2,
                margin: 15,
            },
            780: {
                items: 3,
                margin: 20,
            },
            999: {
                items: 4,
                margin: 20,
            },
        },
    });
    $(".forums")
        .find(".prev")
        .click(function() {
            $(".forum-slide").trigger("next.owl.carousel");
        });
    $(".forums")
        .find(".next")
        .click(function() {
            $(".forum-slide").trigger("prev.owl.carousel", [600]);
        });
});

function sizeControlSub(width) {
    width = parseInt(width);
    var bodyHeight = document.documentElement.clientHeight;
    var bodyWidth = document.documentElement.clientWidth;
    var chkHeader = $("#header-wrap").outerHeight();
    var chkFooter = $("#footer").outerHeight();
    var docW = window.innerWidth;
}

function myWidth(obj) {
    var isWidth = obj.naturalWidth;
    $(".natural-img").css({ "max-width": isWidth });
}

jQuery(function($) {
    sizeControlSub($(this).width());
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
    sizeControlSub($(this).width());
});
$(window).load(function() {
    sizeControlSub($(this).width());
});