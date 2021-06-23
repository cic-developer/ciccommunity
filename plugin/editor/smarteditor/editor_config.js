(function($) {
    $(document).ready(function() {
        $(".smarteditor").each(function(index) {
            var get_id = $(this).attr("id");
            if (!get_id || $(this).prop("nodeName") != "TEXTAREA") return true;
            nhn.husky.EZCreator.createInIFrame({
                oAppRef: oEditors,
                elPlaceHolder: get_id,
                sSkinURI: editor_url + "/SmartEditor2Skin.html",
                htParams: {
                    bUseToolbar: true, // 툴바 사용 여부 (true:사용/ false:사용하지 않음)
                    bUseVerticalResizer: true, // 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
                    bUseModeChanger: true, // 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
                    bSkipXssFilter: true, // client-side xss filter 무시 여부 (true:사용하지 않음 / 그외:사용)
                    //aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
                    fOnBeforeUnload: function() {
                        //alert("완료!");
                    },
                }, //boolean
                fOnAppLoad: function() {
                    //예제 코드
                    let path = window.location.pathname;
                    if (path === "/contactus/apply") {
                        oEditors.getById[get_id].exec("PASTE_HTML", [
                            `[다음의 사항을 기재해주시기 바랍니다]
                        <br><br>
                        인플루언서 활동이름 :
                        <br><br>
                        인플루언서 활동 영역 : (ex: 유튜브, 블로그 등)
                        <br><br>
                        활동 URL :
                        <br><br>
                        연락처(메일 or 전화번호) :
                        <br><br>
                        기타 메시지 : `,
                        ]);
                    }
                },
                fCreator: "createSEditor2",
            });
        });
    });
})(jQuery);