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
                        메일 및 전화번호 :
                        <br><br>
                        기타 메시지 : `,
                        ]);
                    } else if (path === "/write/userforum") {
                        oEditors.getById[get_id].exec("PASTE_HTML", [
                            `<p><span style="color: rgb(154, 154, 154);">예시)&nbsp;</span></p><span style="color: rgb(154, 154, 154);">
                            </span><p><br></p><span style="color: rgb(154, 154, 154);">
                            </span><p><span style="color: rgb(154, 154, 154);">포럼 주제 : 비트코인은 10만달러에 도달할수 있을까요? (2021년 12월 31일 18:00시 까지)</span></p><span style="color: rgb(154, 154, 154);">
                            </span><p><br></p><span style="color: rgb(154, 154, 154);">
                            </span><p><span style="color: rgb(154, 154, 154);">A.의견 : 도달한다&nbsp;</span></p><span style="color: rgb(154, 154, 154);">
                            </span><p><span style="color: rgb(154, 154, 154);">B.의견 : 도달하지 못한다</span></p><span style="color: rgb(154, 154, 154);">
                            </span><p><br></p><span style="color: rgb(154, 154, 154);">
                            </span><p><span style="color: rgb(154, 154, 154);">내용)</span></p><span style="color: rgb(154, 154, 154);">
                            </span><p><span style="color: rgb(154, 154, 154);">비트코인은 2021년 역사적인 고점을 달성한 뒤 현재 하락세를 이어나가고 있습니다</span></p><span style="color: rgb(154, 154, 154);">
                            </span><p><span style="color: rgb(154, 154, 154);">마이크로 스트렛지나 테슬라 같은 상장기업들이 비트코인을 매수/보유 하고 있을 정도로</span></p><span style="color: rgb(154, 154, 154);">
                            </span><p><span style="color: rgb(154, 154, 154);">비트코인의 위상도 과거와는 많이 달라졌지만 국제적인 규제 움직임, 그리고 중국발 악재등</span></p><span style="color: rgb(154, 154, 154);">
                            </span><p><span style="color: rgb(154, 154, 154);">비트코인은 호재와 악재가 팽팽히 맞서는 중입니다</span></p><span style="color: rgb(154, 154, 154);">
                            </span><p><br></p><span style="color: rgb(154, 154, 154);">
                            </span><p><span style="color: rgb(154, 154, 154);">과연 비트코인은 국내시간 기준 2021년 12월 31일 18:00까지&nbsp;</span></p><span style="color: rgb(154, 154, 154);">
                            </span><p><span style="color: rgb(154, 154, 154);">코인베이스 거래소 기준 100,000 달러에 도달할수 있을까요?</span></p>`,
                        ]);
                    } else if (path === "/contactus") {
                        oEditors.getById[get_id].exec("PASTE_HTML", [
                            `답변 받으실 이메일 주소 : <br><br>
                            문의 내용 :`,
                        ]);
                    }
                },
                fCreator: "createSEditor2",
            });
        });
    });
})(jQuery);