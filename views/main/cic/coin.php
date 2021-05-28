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
                                <?php
                                    $i = 0;
                                    foreach(element('except_exchange_list',$view) as $l){
                                ?>
                                    <li <?php echo $i == 0 ? 'class="active"' : '' ?>>
                                        <a href="#n" class="ibtn">
                                            <span><?php echo element('cme_korean_nm', $l); ?></span>
                                        </a>
                                    </li>
                                <?php
                                        $i++;
                                    }
                                ?>
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
                                <?php
                                    $i = 0;
                                    foreach(element('my_exchange_list',$view) as $l){
                                ?>
                                    <li <?php echo $i == 0 ? 'class="active"' : '' ?> data-value="<?php echo element('cme_idx', $l) ?>">
                                        <a href="#n" class="ibtn">
                                            <span><?php echo element('cme_korean_nm', $l); ?></span>
                                        </a>
                                        <button class="delete">
                                            <span class="blind">삭제</span>
                                        </button>
                                    </li>
                                <?php
                                        $i++;
                                    }
                                ?>
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
                                <?php
                                    $i = 0;
                                    foreach(element('except_coin_list',$view) as $l){
                                ?>
                                <li <?php echo $i == 0 ? 'class="active"' : '' ?>>
                                    <a href="#n" class="ibtn">
                                        <span><?php echo element('cmc_symbol', $l); ?> (<?php echo element('cmc_korean_nm', $l); ?>)</span>
                                    </a>
                                </li>
                                <?php
                                        $i++;
                                    }
                                ?>
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
                                <?php
                                    $i = 0;
                                    foreach(element('my_coin_list',$view) as $l){
                                ?>
                                <li <?php echo $i == 0 ? 'class="active"' : '' ?> data-value="<?php echo element('cmc_symbol', $l) ?>">
                                    <a href="#n" class="ibtn">
                                        <span><?php echo element('cmc_symbol', $l); ?> (<?php echo element('cmc_korean_nm', $l); ?>)</span>
                                    </a>
                                    <button class="delete">
                                        <span class="blind">삭제</span>
                                    </button>
                                </li>
                                <?php
                                        $i++;
                                    }
                                ?>
                                <li class="per"><a href="#n"><span>PER (퍼토큰)</span></a></li>
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
                                var is_there_per = $(this).closest('.set-list').find('.c02 > ul > .per').length > 0;
                                if(is_there_per){
                                    var per_html = $(this).closest('.set-list').find('.c02 > ul > .per').html();
                                    $(this).closest('.set-list').find('.c02 > ul > .per').remove();
                                    $(this).closest('.set-list').find('.c02 > ul').append(
                                        '<li class="active"><a href="#n" class="ibtn"><span>' + istxt +
                                        '</span></a><button class="delete"><span class="blind">삭제</span></button></li>'
                                    );
                                    $(this).closest('.set-list').find('.c02 > ul').append(
                                        '<li class="per">' + per_html +
                                        '</li>'
                                    );
                                } else {
                                    $(this).closest('.set-list').find('.c02 > ul').append(
                                        '<li class="active"><a href="#n" class="ibtn"><span>' + istxt +
                                        '</span></a><button class="delete"><span class="blind">삭제</span></button></li>'
                                    );
                                }
                            } else {
                                alert('선택된 항목이 없습니다.');
                            }
                        });
                        $(document).on("click", ".delete", function () {
                            var istxt = $(this).closest('li').find('a.ibtn > span').text();
                            $(this).closest('.set-list').find('.c01 > ul').append(
                                '<li><a href="#n" class="ibtn"><span>' + istxt +
                                '</span></a></li>'
                            );
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
                                var $is_per = $vtem.prev().attr('class') == 'per';
                                if (isThis == 0 || $is_per) {
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
                                var $is_per = $vtem.next().find('a > span').text().indexOf('퍼토큰') > -1
                                if (isThis == isThisLength || $is_per) {
                                    alert('마지막입니다.');
                                } else {
                                    $vtem.next().after($vtem);
                                }
                            } else {
                                alert('선택된 항목이 없습니다.');
                            }
                        });

                    });

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