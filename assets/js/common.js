var nowScrollTop = 0;
var prevScrollTop = 0;
$(window).load(function() {
    setTimeout(function() {
        $("#doc").addClass("show");
    }, 0);
});

$(function() {


    // top search
    $(".bt-search").click(function() {
        if ($(".top-search").hasClass("over")) {
            $(this).removeClass("over");
            $(".top-search").removeClass("over");
        } else {
            $(this).addClass("over");
            $(".top-search").addClass("over");
        }
    });
    $(".top-search")
        .find(".close")
        .click(function() {
            $(".top-search, .bt-search").removeClass("over");
        });

    // top-btn & scroll
    if ($(".top-btn").length < 1)
        $(
            "<a href='#n' class='top-btn'><span class='blind'>top</span></a>"
        ).appendTo($("#doc"));
    $(".top-btn").click(function() {
        $("body, html").animate({
                scrollTop: 0,
            },
            500
        );
    });
});

$(window).scroll(function() {
    var position = $(window).scrollTop();
    var bodyWidth = document.documentElement.clientWidth;
    if (position > 0) {
        $("#header-wrap").addClass("fix");
    } else {
        $("#header-wrap").removeClass("fix");
    }
    if (position > 200) {
        $(".top-btn").addClass("over");
    } else {
        $(".top-btn").removeClass("over");
    }
});
$(window).load(function() {
    var position = $(window).scrollTop();
    var bodyWidth = document.documentElement.clientWidth;
    if (position > 0) {
        $("#header-wrap").addClass("fix");
    } else {
        $("#header-wrap").removeClass("fix");
    }
    if (position > 200) {
        $(".top-btn").addClass("over");
    } else {
        $(".top-btn").removeClass("over");
    }
});

function sizeControlCommon(width) {
    width = parseInt(width);
    var bodyHeight = document.documentElement.clientHeight;
    var bodyWidth = document.documentElement.clientWidth;
    var chkHeader = $("#header-wrap").outerHeight();
    var chkFooter = $("#footer").outerHeight();
    var docW = window.innerWidth;

    if (docW > 999) {
        $(".top-search").find("input").attr("placeholder", "");
    } else {
        $(".top-search").find("input").attr("placeholder", "???????????? ??????????????????");
    }
}
jQuery(function($) {
    sizeControlCommon($(this).width());
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
    sizeControlCommon($(this).width());
});
$(window).load(function() {
    sizeControlCommon($(this).width());
});

function wheelDelta() {
    return prevScrollTop - nowScrollTop > 0 ? "up" : "down";
}

if (typeof COMMON_JS === "undefined") {
    var COMMON_JS = true;

    $(document).on("click", ".btn-history-back", function() {
        history.back();
    });

    $(document).on("click", ".alertclose", function() {
        $(this).closest(".alert").hide();
    });

    $(document).ready(function() {
        window.setTimeout(function() {
            $(".alert-auto-close").hide();
        }, 2500);
    });

    $(document).on("click", "#chkall", function() {
        var chk = document.getElementsByName("chk[]");
        for (i = 0; i < chk.length; i++) chk[i].checked = this.checked;
    });

    $(document).ready(function() {
        $(".datepicker").datepicker({
            format: "yyyy-mm-dd",
            language: "kr",
            autoclose: true,
            todayHighlight: true,
        });
    });

    function trim(s) {
        var t = "";
        var from_pos = (to_pos = 0);

        for (i = 0; i < s.length; i++) {
            if (s.charAt(i) === " ") {
                continue;
            } else {
                from_pos = i;
                break;
            }
        }

        for (i = s.length; i >= 0; i--) {
            if (s.charAt(i - 1) === " ") {
                continue;
            } else {
                to_pos = i;
                break;
            }
        }
        t = s.substring(from_pos, to_pos);
        return t;
    }

    function select_submit(f, acttype, actpage) {
        var str = "";

        if ($("input[name='chk[]']:checked", f).length < 1) {
            alert("????????? ?????? ?????? ???????????????.");
            return;
        }
        if (
            acttype === "delete" &&
            !confirm("????????? ????????? ?????? ?????? ???????????????????")
        )
            return;
        if (
            acttype === "update" &&
            !confirm("????????? ????????? ?????? ???????????? ???????????????????")
        )
            return;

        if (
            acttype === "recover" &&
            !confirm("????????? ????????? ?????? ?????? ???????????????????")
        )
            return;
        if (
            acttype === "trash" &&
            !confirm("????????? ????????? ?????? ??????????????? ?????????????????????????")
        )
            return;

        f.action = actpage;
        f.submit();
    }

    function deletecheck() {
        if (confirm("?????? ????????????????????????? ???????????? ????????? ????????? ??????????????????")) {
            return true;
        } else {
            return false;
        }
    }

    $(document).on("click", ".btn-list-update", function() {
        select_submit(
            document.flist,
            "update",
            $(this).attr("data-list-update-url")
        );
    });

    $(document).on("click", ".btn-list-delete", function() {
        select_submit(
            document.flist,
            "delete",
            $(this).attr("data-list-delete-url")
        );
    });

    $(document).on("click", ".btn-list-trash", function() {
        select_submit(document.flist, "trash", $(this).attr("data-list-trash-url"));
    });

    $(document).on("click", ".btn-list-recover", function() {
        select_submit(
            document.flist,
            "recover",
            $(this).attr("data-list-recover-url")
        );
    });

    $(document).on("click", ".btn-one-delete", function() {
        if (
            confirm(
                "?????? ????????? ????????? ????????? ????????? ????????????.\n\n?????? ?????????????????????????"
            )
        ) {
            document.location.href = $(this).attr("data-one-delete-url");
            return true;
        } else {
            return false;
        }
    });

    $(document).on("click", ".btn-list-truncate", function() {
        if (
            confirm(
                "????????? ????????? ????????????.\n\n?????? ????????? ?????? ????????? ??????????????????. \n\n????????? ?????????????????????????"
            )
        ) {
            document.location.href = $(this).attr("data-list-truncate-url");
            return true;
        } else {
            return false;
        }
    });

    $(document).on("click", ".btn-one-recover", function() {
        if (confirm("????????? ????????? ?????? ?????????????????????????")) {
            document.location.href = $(this).attr("data-one-recover-url");
            return true;
        } else {
            return false;
        }
    });

    $(document).on("click", ".btn-one-trash", function() {
        if (confirm("????????? ????????? ?????? ??????????????? ?????????????????????????")) {
            document.location.href = $(this).attr("data-one-trash-url");
            return true;
        } else {
            return false;
        }
    });

    $(document).on("click", ".list-chkbox, #chkall", function() {
        var $checkedCheckboxes = $(".list-chkbox:checked");
        var $checkboxes = $(".list-chkbox");
        if ($checkedCheckboxes.length) {
            $(".btn-list-update , .btn-list-selected").removeClass("disabled");
        } else {
            $(".btn-list-update , .btn-list-selected").addClass("disabled");
        }
    });

    $(document).on("click", ".view_full_image", function() {
        window.open(
            cb_url +
            "/helptool/viewimage?imgurl=" +
            encodeURIComponent($(this).attr("data-origin-image-url")),
            "large_image",
            "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no"
        );
        return false;
    });

    function post_like(post_id, like_type, classname) {
        var href;

        if (post_id == "") {
            return false;
        }

        href = cb_url + "/postact/post_like/" + post_id + "/" + like_type;

        $.ajax({
            url: href,
            type: "get",
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                    return false;
                } else if (data.success) {
                    //alert(data.success);
                    $("." + classname).text(number_format(String(data.count)));
                    $("#btn-" + classname).effect("highlight", { color: "#f37f60" }, 300);
                }
            },
        });
    }

    function comment_like(cmt_id, like_type, classname) {
        var href;

        if (cmt_id == "") {
            return false;
        }

        href = cb_url + "/postact/comment_like/" + cmt_id + "/" + like_type;

        $.ajax({
            url: href,
            type: "get",
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                    return false;
                } else if (data.success) {
                    //alert(data.success);
                    $("." + classname).text(number_format(String(data.count)));
                    $("#btn-" + classname).effect("highlight", { color: "#f37f60" }, 500);
                }
            },
        });
    }

    function post_scrap(post_id, classname) {
        var href;

        if (post_id == "") {
            return false;
        }

        href = cb_url + "/postact/post_scrap/" + post_id;
        var $that = $(this);
        $.ajax({
            url: href,
            type: "get",
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                    return false;
                } else if (data.success) {
                    //alert(data.success);
                    $("." + classname).text("+" + number_format(String(data.count)));
                    $("#btn-scrap").effect("highlight", { color: "#af75b2" }, 3000);
                }
            },
        });
    }

    function post_blame(post_id, classname) {
        var href;

        if (post_id == "") {
            return false;
        }

        if (!confirm(
                "??? ?????? ?????????????????????????\n\n?????? ???????????? ????????? ????????? ??????????????????"
            )) {
            return false;
        }

        href = cb_url + "/postact/post_blame/" + post_id;
        var $that = $(this);
        $.ajax({
            url: href,
            type: "get",
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                    return false;
                } else if (data.success) {
                    //alert(data.success);
                    $("." + classname).text("+" + number_format(String(data.count)));
                    $("#btn-blame").effect("highlight", { color: "#af75b2" }, 3000);
                }
            },
        });
    }

    function comment_blame(cmt_id, classname) {
        var href;

        if (cmt_id == "") {
            return false;
        }

        if (!confirm(
                "??? ????????? ?????????????????????????\n\n?????? ???????????? ????????? ????????? ??????????????????"
            )) {
            return false;
        }

        href = cb_url + "/postact/comment_blame/" + cmt_id;
        var $that = $(this);
        $.ajax({
            url: href,
            type: "get",
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                    return false;
                } else if (data.success) {
                    //alert(data.success);
                    $("." + classname).text("+" + number_format(String(data.count)));
                }
            },
        });
    }

    function post_action(action_type, action_id, flag, msg) {
        var href;
        if (action_type == "") {
            return false;
        }
        if (action_id == "") {
            return false;
        }
        if (msg) {
            if (!confirm(msg)) {
                return false;
            }
        }
        href = cb_url + "/postact/" + action_type + "/" + action_id + "/" + flag;
        var $that = $(this);
        $.ajax({
            url: href,
            type: "post",
            data: {
                csrf_test_name: cb_csrf_hash,
            },
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                    return false;
                } else if (data.success) {
                    alert(data.success);
                    if (data.url) {
                        document.location.href = data.url;
                    } else {
                        document.location.reload();
                    }
                }
            },
        });
    }

    function post_multi_action(action_type, flag, msg) {
        var href;
        if (action_type == "") {
            return false;
        }
        if (msg) {
            if (!confirm(msg)) {
                return false;
            }
        }
        href = cb_url + "/postact/" + action_type + "/" + flag;
        var $that = $(this);
        $.ajax({
            url: href,
            type: "post",
            data: $("#fboardlist").serialize() + "&csrf_test_name=" + cb_csrf_hash,
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                    return false;
                } else if (data.success) {
                    alert(data.success);
                    if (data.url) {
                        document.location.href = data.url;
                    } else {
                        document.location.reload();
                    }
                }
            },
        });
    }

    function makeSerializable(elem) {
        return $(elem).prop("elements", $("*", elem).andSelf().get());
    }

    function comment_multi_action(id, post_id, action_type, flag, msg) {
        var href;
        if (action_type == "") {
            return false;
        }
        if (msg) {
            if (!confirm(msg)) {
                return false;
            }
        }

        var sdata = makeSerializable("#viewcomment").serialize();

        href = cb_url + "/postact/" + action_type + "/" + flag;
        var $that = $(this);
        $.ajax({
            url: href,
            type: "post",
            data: sdata + "&csrf_test_name=" + cb_csrf_hash,
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                    return false;
                } else if (data.success) {
                    alert(data.success);
                    if (data.url) {
                        document.location.href = data.url;
                    } else {
                        view_comment(id, post_id, "1");
                    }
                }
            },
        });
    }

    function add_follow(userid, classname) {
        var href;

        if (userid == "") {
            return false;
        }

        href = cb_url + "/profile/add_follow/" + userid;
        var $that = $(this);
        $.ajax({
            url: href,
            type: "get",
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                    return false;
                } else if (data.success) {
                    alert(data.success);
                    if (classname)
                        $("." + classname).text(number_format(String(data.target_count)));
                }
            },
        });
    }

    function delete_follow(userid, classname) {
        var href;

        if (userid == "") {
            return false;
        }

        href = cb_url + "/profile/delete_follow/" + userid;
        var $that = $(this);
        $.ajax({
            url: href,
            type: "get",
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                    return false;
                } else if (data.success) {
                    alert(data.success);
                    if (classname)
                        $("." + classname).text(number_format(String(data.target_count)));
                }
            },
        });
    }

    $(document).on("mouseenter", ".admin-manage-post", function() {
        $manage_button = $(this);
        $(".admin-manage-post-layer").css("top", $manage_button.position().top);
        $(".admin-manage-post-layer").css(
            "left",
            $manage_button.position().left -
            ($(".admin-manage-post-layer").width() - $manage_button.width())
        );
        $(".admin-manage-post-layer").css("display", "block");
        $(document).on("mouseenter", ".admin-manage-post-layer .item", function() {
            $(this).css("background-color", "#DEDEDE");
        });
        $(document).on("mouseleave", ".admin-manage-post-layer .item", function() {
            $(this).css("background-color", "#FFFFFF");
        });
    });
    $(document).on("mouseenter", ".admin-manage-list", function() {
        $manage_button_list = $(this);
        $(".admin-manage-layer-list").css(
            "top",
            $manage_button_list.position().top
        );
        $(".admin-manage-layer-list").css(
            "left",
            $manage_button_list.position().left -
            ($(".admin-manage-layer-list").width() - $manage_button_list.width())
        );
        $(".admin-manage-layer-list").css("display", "block");
        $(document).on("mouseenter", ".admin-manage-layer-list .item", function() {
            $(this).css("background-color", "#DEDEDE");
        });
        $(document).on("mouseleave", ".admin-manage-layer-list .item", function() {
            $(this).css("background-color", "#FFFFFF");
        });
    });
    $(document).on("mouseenter", ".admin-manage-comment", function() {
        $manage_button_comment = $(this);
        $(".admin-manage-layer-comment").css(
            "top",
            $manage_button_comment.position().top
        );
        $(".admin-manage-layer-comment").css(
            "left",
            $manage_button_comment.position().left -
            ($(".admin-manage-layer-comment").width() -
                $manage_button_comment.width())
        );
        $(".admin-manage-layer-comment").css("display", "block");
        $(document).on(
            "mouseenter",
            ".admin-manage-layer-comment .item",
            function() {
                $(this).css("background-color", "#DEDEDE");
            }
        );
        $(document).on(
            "mouseleave",
            ".admin-manage-layer-comment .item",
            function() {
                $(this).css("background-color", "#FFFFFF");
            }
        );
    });
    $(document).on("mouseleave", ".btn-admin-manage-layer", function() {
        $(this).css("display", "none");
    });

    // ?????? ??????
    function set_cookie(name, value, expirehours, domain) {
        var today = new Date();
        today.setTime(today.getTime() + 60 * 60 * 1000 * expirehours);
        document.cookie =
            cookie_prefix +
            name +
            "=" +
            escape(value) +
            "; path=/; expires=" +
            today.toGMTString() +
            ";";
        if (domain) {
            document.cookie += "domain=" + domain + ";";
        }
    }

    // ?????? ??????
    function get_cookie(cookie_name) {
        var find_sw = false;
        var start, end;
        var i = 0;

        name = cookie_prefix + cookie_name;

        for (i = 0; i <= document.cookie.length; i++) {
            start = i;
            end = start + name.length;

            if (document.cookie.substring(start, end) == name) {
                find_sw = true;
                break;
            }
        }

        if (find_sw === true) {
            start = end + 1;
            end = document.cookie.indexOf(";", start);

            if (end < start) {
                end = document.cookie.length;
            }

            return document.cookie.substring(start, end);
        }
        return "";
    }

    // ?????? ??????
    function delete_cookie(name) {
        var today = new Date();

        today.setTime(today.getTime() - 1);
        var value = get_cookie(name);
        if (value) {
            document.cookie =
                cookie_prefix +
                name +
                "=" +
                value +
                "; path=/; expires=" +
                today.toGMTString();
        }
    }

    // ????????? , ??? ??????
    function number_format(data) {
        var tmp = "";
        var number = "";
        var cutlen = 3;
        var comma = ",";
        var i;

        var sign = data.match(/^[\+\-]/);
        if (sign) {
            data = data.replace(/^[\+\-]/, "");
        }

        len = data.length;
        mod = len % cutlen;
        k = cutlen - mod;
        for (i = 0; i < data.length; i++) {
            number = number + data.charAt(i);

            if (i < data.length - 1) {
                k++;
                if (k % cutlen === 0) {
                    number = number + comma;
                    k = 0;
                }
            }
        }

        if (sign !== null) {
            number = sign + number;
        }

        return number;
    }

    // ????????? ??????
    function check_byte(content, target) {
        var cont = $("#" + content).val();

        // ????????? ??????
        $("#" + target).text(cont.length);

        return cont.length;
    }

    function resize_textarea(id, mode) {
        if (mode === "down") {
            $("#" + id).height($("#" + id).height() + 50);
        } else if (mode === "up") {
            $("#" + id).height($("#" + id).height() - 50);
        } else {
            $("#" + id).height(mode);
        }
    }

    function note_write(userid) {
        window.open(
            cb_url + "/note/write/" + userid,
            "win_note",
            "left=100,top=100,width=730,height=500,scrollbars=1"
        );
        return false;
    }

    function note_list(note_id) {
        if (note_id) {
            note_url = cb_url + "/note/view/recv/" + note_id;
        } else {
            note_url = cb_url + "/note/lists/recv";
        }
        window.open(
            note_url,
            "win_note",
            "left=100,top=100,width=730,height=500,scrollbars=1"
        );
        return false;
    }

    function open_profile(userid) {
        window.open(
            cb_url + "/profile/" + userid,
            "win_profile",
            "left=100,top=100,width=720,height=500,scrollbars=1"
        );
        return false;
    }

    function email_write(userid) {
        window.open(
            cb_url + "/formmail/write/" + userid,
            "win_note",
            "left=100,top=100,width=720,height=500,scrollbars=1"
        );
        return false;
    }

    function post_print(post_id) {
        window.open(
            cb_url + "/print/" + post_id,
            "win_print",
            "left=100,top=100,width=900,height=600,scrollbars=1"
        );
        return false;
    }

    function post_history(post_id) {
        window.open(
            cb_url + "/helptool/post_history/" + post_id,
            "win_post_history",
            "left=100,top=100,width=620,height=500,scrollbars=1"
        );
        return false;
    }

    function download_log(post_id) {
        window.open(
            cb_url + "/helptool/download_log/" + post_id,
            "win_download_log",
            "left=100,top=100,width=620,height=500,scrollbars=1"
        );
        return false;
    }

    function link_click_log(post_id) {
        window.open(
            cb_url + "/helptool/link_click_log/" + post_id,
            "win_link_click_log",
            "left=100,top=100,width=620,height=500,scrollbars=1"
        );
        return false;
    }

    function post_copy(type, post_id) {
        window.open(
            cb_url + "/helptool/post_copy/" + type + "/" + post_id,
            "win_post_copy",
            "left=100,top=100,width=620,height=500,scrollbars=1"
        );
        return false;
    }

    function post_change_category(post_id) {
        window.open(
            cb_url + "/helptool/post_change_category/" + post_id,
            "win_post_change_category",
            "left=100,top=100,width=620,height=500,scrollbars=1"
        );
        return false;
    }

    function post_multi_copy(ptype) {
        var f = document.fboardlist;
        var sub_win = window.open(
            "",
            "move",
            "left=100, top=100, width=620, height=500, scrollbars=1"
        );

        f.target = "move";
        f.method = "post";
        f.action = cb_url + "/helptool/post_copy/" + ptype;
        f.submit();
    }

    function post_multi_change_category() {
        var f = document.fboardlist;
        var sub_win = window.open(
            "",
            "change_category",
            "left=100, top=100, width=620, height=500, scrollbars=1"
        );

        f.target = "change_category";
        f.method = "post";
        f.action = cb_url + "/helptool/post_change_category";
        f.submit();
    }

    function open_google_map() {
        window.open(
            cb_url + "/helptool/googlemap_search",
            "win_map",
            "left=100,top=100,width=720,height=500,scrollbars=1"
        );
        return false;
    }

    function all_boardlist_checked(flag) {
        var f = document.fboardlist;
        for (var i = 0; i < f.length; i++) {
            if (f.elements[i].name === "chk_post_id[]") {
                f.elements[i].checked = flag;
            }
        }
    }

    function all_commentlist_checked(flag) {
        checkboxes = document.getElementsByName("chk_comment_id[]");
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = flag;
        }
    }

    function auto_tempsave(brd_key) {
        var post_title = $("#post_title").val();
        if (typeof oEditors !== "undefined") {
            oEditors.getById["post_content"].exec("UPDATE_CONTENTS_FIELD", []);
        }
        var post_content = $("#post_content").val();

        $.ajax({
            url: cb_url + "/postact/tempsave",
            data: {
                brd_key: brd_key,
                post_title: encodeURIComponent(post_title),
                post_content: encodeURIComponent(post_content),
                csrf_test_name: cb_csrf_hash,
            },
            type: "post",
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                    return false;
                } else if (data.success) {
                    //alert(data.success);
                }
            },
        });
    }

    function get_tempsave(brd_key) {
        if (confirm("?????? ????????? ????????? ????????????.\n\n?????????????????????????")) {
            $.ajax({
                url: cb_url + "/postact/get_tempsave",
                data: {
                    brd_key: brd_key,
                    csrf_test_name: cb_csrf_hash,
                },
                type: "post",
                dataType: "json",
                success: function(data) {
                    if (data.error) {
                        alert(data.error);
                        return false;
                    } else if (data.success) {
                        //alert(data.success);
                        $("#post_title").val(data.tmp_title);
                        $("#post_content").val(data.tmp_content);
                    }
                },
            });
        }
    }

    function ajax_notification_load() {
        $.ajax({
            url: cb_url + "/notification/ajax_list",
            type: "post",
            data: {
                csrf_test_name: cb_csrf_hash,
            },
            success: function(data) {
                $(".notifications-menu").html(data);
                $(".notification_num").html($("#notification_count").text());
            },
        });
    }

    $(document).on("click", ".notifications", function() {
        var display = $(".notifications-menu").css("display");
        if (display === "none") {
            $(".notifications-menu").show();
            ajax_notification_load();
        } else {
            $(".notifications-menu").hide();
        }
    });
    $(document).on("click", ".notification_read.note", function() {
        $.ajax({
            url: cb_url + "/notification/readajax/" + $(this).attr("data-not-id"),
            type: "get",
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                    return false;
                } else if (data.success) {
                    //alert(data.success);
                }
            },
        });
    });
    $(document).on("click", ".noti-all-read", function() {
        $.ajax({
            url: cb_url + "/notification/readallajax/",
            type: "get",
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                    return false;
                } else if (data.success) {
                    //alert(data.success);
                    ajax_notification_load();
                }
            },
        });
    });

    $(document).on("click", ".url-qrcode", function() {
        var toggled = $(this).attr("data-toggled");
        if (toggled == "on") {
            $("#qrcode-content").hide("fast");
            $(".url-qrcode").attr("data-toggled", "off");
        } else {
            $("body").append("<div id='qrcode-content'></div>");
            var url = $(this).attr("data-qrcode-url");
            var x = $(this).offset().top;
            var y = $(this).offset().left;

            $("#qrcode-content").hide();
            $("#qrcode-content")
                .css("top", x + 20)
                .css("left", y);
            $("#qrcode-content")
                .html(
                    "<div class='qrcode_code'><img src='https://chart.googleapis.com/chart?cht=qr&chld=H|2&chs=100&chl=" +
                    url +
                    "'></div><div class='qrcode_info'>???????????? QR????????? ???????????? ?????? ????????? ?????? ????????? ??? ????????????.</div>"
                )
                .show("fast");
            $(".url-qrcode").attr("data-toggled", "off");
            $(this).attr("data-toggled", "on");
        }
    });

    /**
     * ???????????? ???
     **/
    var win_zip = function(
        frm_name,
        frm_zipcode,
        frm_address1,
        frm_address2,
        frm_address3,
        frm_address4
    ) {
        if (typeof daum === "undefined") {
            alert("?????? juso.js ????????? ???????????? ???????????????.");
            return false;
        }

        var zip_case = 1; //0?????? ?????????, 1?????? ???????????? ?????? ??????, 2?????? ??????

        var complete_fn = function(data) {
            // ???????????? ???????????? ????????? ??????????????? ????????? ????????? ???????????? ??????.

            // ??? ????????? ?????? ????????? ?????? ????????? ????????????.
            // ???????????? ????????? ?????? ?????? ????????? ??????('')?????? ????????????, ?????? ???????????? ?????? ??????.
            var fullAddr = ""; // ?????? ?????? ??????
            var extraAddr = ""; // ????????? ?????? ??????

            // ???????????? ????????? ?????? ????????? ?????? ?????? ?????? ?????? ????????????.
            if (data.userSelectedType === "R") {
                // ???????????? ????????? ????????? ???????????? ??????
                fullAddr = data.roadAddress;
            } else {
                // ???????????? ?????? ????????? ???????????? ??????(J)
                fullAddr = data.jibunAddress;
            }

            // ???????????? ????????? ????????? ????????? ???????????? ????????????.
            if (data.userSelectedType === "R") {
                //??????????????? ?????? ?????? ????????????.
                if (data.bname !== "") {
                    extraAddr += data.bname;
                }
                // ???????????? ?????? ?????? ????????????.
                if (data.buildingName !== "") {
                    extraAddr +=
                        extraAddr !== "" ? ", " + data.buildingName : data.buildingName;
                }
                // ?????????????????? ????????? ?????? ????????? ????????? ???????????? ?????? ????????? ?????????.
                extraAddr = extraAddr !== "" ? " (" + extraAddr + ")" : "";
            }

            // ??????????????? ?????? ????????? ?????? ????????? ??????, ????????? ???????????? ????????? ????????????.
            var of = document[frm_name];

            of[frm_zipcode].value = data.zonecode;

            of[frm_address1].value = fullAddr;
            of[frm_address3].value = extraAddr;

            if (of[frm_address4] !== undefined) {
                of[frm_address4].value = data.userSelectedType;
            }

            of[frm_address2].focus();
        };

        switch (zip_case) {
            case 1: //iframe??? ???????????? ???????????? ?????? ??????
                var daum_pape_id = "daum_juso_page" + frm_zipcode,
                    element_wrap = document.getElementById(daum_pape_id),
                    currentScroll = Math.max(
                        document.body.scrollTop,
                        document.documentElement.scrollTop
                    );
                if (element_wrap === null) {
                    element_wrap = document.createElement("div");
                    element_wrap.setAttribute("id", daum_pape_id);
                    element_wrap.style.cssText =
                        "display:none;border:1px solid;left:0;width:100%;height:300px;margin:5px 0;position:relative;-webkit-overflow-scrolling:touch;";
                    element_wrap.innerHTML =
                        '<img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-21px;z-index:1" class="close_daum_juso" alt="?????? ??????">';
                    jQuery('form[name="' + frm_name + '"]')
                        .find('input[name="' + frm_address1 + '"]')
                        .before(element_wrap);
                    jQuery("#" + daum_pape_id)
                        .off("click", ".close_daum_juso")
                        .on("click", ".close_daum_juso", function(e) {
                            e.preventDefault();
                            jQuery(this).parent().hide();
                        });
                }

                new daum.Postcode({
                    oncomplete: function(data) {
                        complete_fn(data);
                        // iframe??? ?????? element??? ???????????? ??????.
                        element_wrap.style.display = "none";
                        // ???????????? ?????? ????????? ????????? ???????????? scroll ????????? ????????????.
                        document.body.scrollTop = currentScroll;
                    },
                    // ???????????? ?????? ?????? ????????? ?????????????????? ????????? ????????? ???????????? ??????.
                    // iframe??? ?????? element??? ???????????? ????????????.
                    onresize: function(size) {
                        element_wrap.style.height = size.height + "px";
                    },
                    width: "100%",
                    height: "100%",
                }).embed(element_wrap);

                // iframe??? ?????? element??? ????????? ??????.
                element_wrap.style.display = "block";
                break;
            case 2: //???????????? ?????????
                new daum.Postcode({
                    oncomplete: function(data) {
                        complete_fn(data);
                    },
                }).open();
                break;
            default:
                //iframe??? ???????????? ????????? ?????????
                var rayer_id = "daum_juso_rayer" + frm_zipcode,
                    element_layer = document.getElementById(rayer_id);
                if (element_layer === null) {
                    element_layer = document.createElement("div");
                    element_layer.setAttribute("id", rayer_id);
                    element_layer.style.cssText =
                        "display:none;border:5px solid;position:fixed;width:300px;height:460px;left:50%;margin-left:-155px;top:50%;margin-top:-235px;overflow:hidden;-webkit-overflow-scrolling:touch;z-index:10000";
                    element_layer.innerHTML =
                        '<img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" class="close_daum_juso" alt="?????? ??????">';
                    document.body.appendChild(element_layer);
                    jQuery("#" + rayer_id)
                        .off("click", ".close_daum_juso")
                        .on("click", ".close_daum_juso", function(e) {
                            e.preventDefault();
                            jQuery(this).parent().hide();
                        });
                }

                new daum.Postcode({
                    oncomplete: function(data) {
                        complete_fn(data);
                        // iframe??? ?????? element??? ???????????? ??????.
                        element_layer.style.display = "none";
                    },
                    width: "100%",
                    height: "100%",
                }).embed(element_layer);

                // iframe??? ?????? element??? ????????? ??????.
                element_layer.style.display = "block";
        }
    };
}