<div id="container-wrap">
    <div id="contents" class="div-cont">
        <!-- page start // -->
        <div class="price-wrap">
            <h3>시세표 설정</h3>
            <div class="cont">
                <div class="set-list">
                    <div class="item fl">
                        <h4><span>거래소</span> 종류</h4>
                        <div class="c01">
                            <ul>
                                <li><a href="#n" class="ibtn"><span>빗썸</span></a></li>
                                <li><a href="#n" class="ibtn"><span>업비트</span></a></li>
                                <li><a href="#n" class="ibtn"><span>핫빗코리아</span></a></li>
                                <li><a href="#n" class="ibtn"><span>코인빗</span></a></li>
                                <li class="active"><a href="#n" class="ibtn"><span>코인원</span></a></li>
                                <li><a href="#n" class="ibtn"><span>코빗</span></a></li>
                                <li><a href="#n" class="ibtn"><span>비트플라이어</span></a></li>
                                <li><a href="#n" class="ibtn"><span>바이낸스</span></a></li>
                                <li><a href="#n" class="ibtn"><span>비트파이넥스</span></a></li>
                                <li><a href="#n" class="ibtn"><span>오케이코인 </span></a></li>
                                <li><a href="#n" class="ibtn"><span>후오비</span></a></li>
                                <li><a href="#n" class="ibtn"><span>비트렉스</span></a></li>
                                <li><a href="#n" class="ibtn"><span>폴로닉스</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <a href="#n" class="vsel-btn"><span>선택</span></a>
                    <div class="item fr">
                        <h4>선택한 거래소</h4>
                        <a href="#n" class="up-btn"><span class="blind">위로<span></span></span></a>
                        <a href="#n" class="down-btn"><span class="blind">아래로<span></span></span></a>
                        <div class="c02">
                            <ul>
                                <li><a href="#n" class="ibtn"><span>빗썸</span></a><button class="delete"><span
                                            class="blind">삭제</span></button></li>
                                <li class="active"><a href="#n" class="ibtn"><span>업비트</span></a><button
                                        class="delete"><span class="blind">삭제</span></button></li>
                                <li><a href="#n" class="ibtn"><span>핫빗코리아</span></a><button class="delete"><span
                                            class="blind">삭제</span></button></li>
                                <li><a href="#n" class="ibtn"><span>비트렉스</span></a><button class="delete"><span
                                            class="blind">삭제</span></button></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="gap50"></div>
                <div class="set-list">
                    <div class="item fl">
                        <h4><span>암호화폐</span></h4>
                        <div class="c01">
                            <ul>
                                <li><a href="#n" class="ibtn"><span>BTC (비트코인)</span></a></li>
                                <li><a href="#n" class="ibtn"><span>ETC (이더리움)</span></a></li>
                                <li><a href="#n" class="ibtn"><span>LTC (라이트코인)</span></a></li>
                                <li><a href="#n" class="ibtn"><span>ETC (이더리움 클래식)</span></a></li>
                                <li class="active"><a href="#n" class="ibtn"><span>XLM (스텔라루멘)</span></a></li>
                                <li><a href="#n" class="ibtn"><span>KLAY (클레이튼)</span></a></li>
                                <li><a href="#n" class="ibtn"><span>BCH (비트코인 캐시)</span></a></li>
                                <li><a href="#n" class="ibtn"><span>EOS (이오스)</span></a></li>
                                <li><a href="#n" class="ibtn"><span>ADA (에이다)</span></a></li>
                                <li><a href="#n" class="ibtn"><span>DOT (폴카닷) </span></a></li>
                                <li><a href="#n" class="ibtn"><span>BSV (비트코인에스브이)</span></a></li>
                                <li><a href="#n" class="ibtn"><span>XMR (모네로)</span></a></li>
                                <li><a href="#n" class="ibtn"><span>QTUM (퀸텀)</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <a href="#n" class="vsel-btn"><span>선택</span></a>
                    <div class="item fr">
                        <h4>선택한 암호화폐</h4>
                        <a href="#n" class="up-btn"><span class="blind">위로<span></span></span></a>
                        <a href="#n" class="down-btn"><span class="blind">아래로<span></span></span></a>
                        <div class="c02">
                            <ul>
                                <li><a href="#n" class="ibtn"><span>BTC (비트코인)</span></a><button class="delete"><span
                                            class="blind">삭제</span></button></li>
                                <li class="active"><a href="#n" class="ibtn"><span>ETC (이더리움)</span></a><button
                                        class="delete"><span class="blind">삭제</span></button></li>
                                <li><a href="#n" class="ibtn"><span>핫빗코리아</span></a><button class="delete"><span
                                            class="blind">삭제</span></button></li>
                                <li><a href="#n" class="ibtn"><span>LTC (라이트코인)</span></a><button class="delete"><span
                                            class="blind">삭제</span></button></li>
                                <li><a href="#n"><span>PER (퍼토큰)</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <script>
                    $(function () {
                        $('.set-list').find('.vsel-btn').click(function () {
                            var cachk = $(this).closest('.set-list').find('.c01').find('li.active')
                                .length;
                            var h4txt = $(this).closest('.set-list').find('.item.fl').find('h4 > span')
                                .text();
                            if (cachk > 0) {
                                var istxt = $(this).closest('.set-list').find('.c01').find(
                                    'li.active > a > span').text();
                                $(this).closest('.set-list').find('.c01').find('li.active').remove();
                                $(this).closest('.set-list').find('.c02 > ul > li').removeClass(
                                    'active');
                                $(this).closest('.set-list').find('.c02 > ul').append(
                                    '<li class="active"><a href="#n" class="ibtn"><span>' + istxt +
                                    '</span></a><button class="delete"><span class="blind">삭제</span></button></li>'
                                );
                            } else {
                                alert('선택된 항목이 없습니다.');
                            }
                        });
                        $(document).on("click", ".delete", function () {
                            $(this).closest('li').remove();
                        });
                        $(document).on("click", ".ibtn", function () {
                            if ($(this).parent().hasClass('active')) {
                                $(this).parent().removeClass('active');
                            } else {
                                $(this).parent().addClass('active');
                            }
                            $(this).parent().siblings('li').removeClass('active');
                        });

                        $('.up-btn').click(function () {
                            var cachkv = $(this).closest('.item').find('li.active').length;
                            if (cachkv > 0) {
                                var isThis = $(this).closest('.item').find('li.active').index();
                                var $vtem = $(this).closest('.item').find('li.active');
                                if (isThis == 0) {
                                    alert('처음입니다.');
                                } else {
                                    $vtem.prev().before($vtem);
                                }
                            } else {
                                alert('선택된 항목이 없습니다.');
                            }
                        });
                        $('.down-btn').click(function () {
                            var cachkv = $(this).closest('.item').find('li.active').length;
                            if (cachkv > 0) {
                                var isThis = $(this).closest('.item').find('li.active').index() + 1;
                                var isThisLength = $(this).closest('.item').find('li').length;
                                var $vtem = $(this).closest('.item').find('li.active');
                                if (isThis == isThisLength) {
                                    alert('마지막입니다.');
                                } else {
                                    $vtem.next().after($vtem);
                                }
                            } else {
                                alert('선택된 항목이 없습니다.');
                            }
                        });

                    })
                </script>
                <div class="item unit">
                    <h4>화폐단위</h4>
                    <ul>
                        <li>
                            <p class="chk-radio"><input type="radio" name="dsel01Group" id="dsel01" checked=""><label
                                    for="dsel01">KRW</label></p>
                        </li>
                        <li>
                            <p class="chk-radio"><input type="radio" name="dsel01Group" id="dsel02"><label
                                    for="dsel02">USD</label></p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="lower">
                <p class="ex">※ 가상화폐는 최대 8개까지 선택할 수 있으며, PER 코인은 고정입니다.</p>
                <a href="#n" class="save-btn"><span>저장</span></a>
                <a href="#n" class="refresh-btn"><span>초기화</span></a>
            </div>
        </div>
        <!-- page end // -->
    </div>
</div>