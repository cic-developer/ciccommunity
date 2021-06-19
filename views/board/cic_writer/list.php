<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>

<div id="container-wrap">
    <div id="top-vis">
        <div class="txt">
            <h2>Writer</h2>
            <p>등록된 회원들이 양질의 정보전달 글, 본인의 칼럼을 게시하는 공간 입니다.</p>
            <?php if($this->member->is_member()) {?>
                <p style="margin-top: 14px;"><a href="<?php echo base_url('/contactus/apply')?>">신청하기</a> </p>
            <?php } ?>
        </div>
        <div class="img"><img src="<?php echo base_url('assets/images/top-vis03.jpg')?>" alt=""></div>
    </div>
    <div id="contents" class="div-cont">
        <div class="board-wrap list">
            <div class="list vnews">
                <h3>BEST</h3>
                <div class="vnews-slide owl-loaded owl-drag">
                    <div class="owl-stage-outer">
                        <div class="owl-stage"
                            style="transform: translate3d(-1040px, 0px, 0px); transition: all 0s ease 0s; width: 3900px; margin-bottom: 10px;">
                                <?php
                                if (element('list',element('bestpost', $view))) {
                                    foreach (element('list',element('bestpost', $view)) as $bestpost) {
                                        ?>
                                        <div class="owl-item" style="width: 240px; margin-right: 20px;">
                                            <div class="item">
                                                <a href="<?php echo goto_url(element('posturl', $bestpost)); ?>">
                                                    <div class="img"><img src="<?php echo element('thumb_url',$bestpost)?>" alt="">
                                                    </div>
                                                    <div class="txt">
                                                        <p class="btxt"><?php echo html_escape(cut_str(str_replace("&nbsp;"," ",strip_tags(element('post_title', $bestpost))), 15)); ?></p>
                                                        <p class="stxt"><?php echo html_escape(cut_str(str_replace("&nbsp;"," ",strip_tags(element('post_content', $bestpost))), 20)); ?></p>
                                                        <p class="ctxt vp"><?php echo number_format(element("post_like_point",$bestpost))?></p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                $list_count = count(element('list', element('bestpost', $view)));
                                $max = 4 - $list_count;
                                if($list_count <= 4) {
                                    for($i = 0; $i < $max; $i++){
                                ?>
                                    <div class="owl-item" style="width: 240px; margin-right: 20px;">
                                        <div class="item">
                                            <a>
                                                <div class="img"><img src="<?php echo base_url('/assets/images/news-img01.png') ?>" alt="">
                                                </div>
                                                <div class="txt">
                                                    <p class="btxt">선택된 자료가 없습니다.</p>
                                                    <p class="stxt">선택된 자료가 없습니다.</p>
                                                    <p class="ctxt vp"><?php echo number_format(element("post_like_point",$bestpost))?></p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <div class="owl-nav disabled">
                        <button type="button" role="presentation" class="owl-prev">
                            <span aria-label="Previous">‹</span>
                        </button>
                        <button type="button" role="presentation" class="owl-next">
                            <span aria-label="Next">›</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="gap60"></div>
            <div class="list vimg vp">
                <ul>
                    <?php
                        if (element('list', element('data', element('list', $view)))) {
                            foreach (element('list', element('data', element('list', $view))) as $result) {
                    ?>
                    <li>
                        <a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('title', $result)); ?>">
                            <div class="img"><img src="<?php echo element('thumb_url',$result)?>" alt="">
                            </div>
                            <div class="txt">
                                <div class="vc">
                                    <p class="btxt"><?php echo html_escape(element('title', $result)); ?> <span>(<?php echo element('post_comment_count', $result); ?>)</span></p>
                                    <p class="stxt"><?php echo html_escape(cut_str(str_replace("&nbsp;"," ",strip_tags(element('post_content', $result))), 60)); ?>
                                    </p>
                                    <p class="ctxt">
                                        <span><?php echo html_escape(element('post_nickname', $result)); ?></span>
                                        <span><?php echo element('display_datetime', $result); ?></span>
                                        <span>조회 <?php echo number_format(element('post_hit', $result)); ?></span>
                                    </p>
                                </div>
                            </div>
                        </a>
                            <div class="abr">
                                <div class="photo">
                                    <p class="pimg"><img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', $result), 140, 140);?>"
                                            alt="<?php echo element('mlc_title', $result); ?>"></p>
                                    <p class="rtxt popup_menuu"><?php echo element('post_nickname', $result); ?></p>
                                </div>
                                <p class="vp"><?php echo number_format(element('post_like_point', $result)-element('post_dislike_point', $result)); ?> VP</p>
                            </div>
                        
                    </li>
                    <?php
                        }
                    } else {
                    ?>
                        <li>
                            <div class="nopost" style="text-align:center;">자료가 없습니다</div>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
                <script>
                    $(function () {
                        $('.list.vimg').find('li').each(function () {
                            var chkimg = $(this).find('.img').length;
                            if (chkimg < 1) {
                                $(this).addClass('no-img');
                            }
                        })
                    })
                </script>
            </div>
		    <?php if (element('write_url', element('list', $view))) { ?>
            <div class="lower r">
                <a href="<?php echo element('write_url', element('list', $view)); ?>" class="by-btn">글쓰기</a>
            </div>
            <?php }?>
            <!-- s: paging-wrap -->
            <div class="paging-wrap">
                <?php echo element('paging', element('list', $view)); ?>
            </div>
            <!-- e: paging-wrap -->
            <!-- s: board-filter -->
            <div class="board-filter">
                <form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
                        <div class="board-filter">
                            <p class="chk-select">
                                <select name="sfield">
                                    <?php echo element('search_option',  element('list', $view)); ?>
                                </select>
                            </p>
                            <p class="chk-input">
                                <input type="text" name="skeyword" value="<?php echo html_escape(element('skeyword',  element('list', $view))); ?>" placeholder="검색어를 입력해주세요" autocomplete="off" />
                                <button class="search-btn" name="search_submit" type="submit"></button>
                            </p>
                        </div>
                    </form>
            </div>
            <!— e: board-filter —>
        </div>
        <!— page end // —>
    </div>
    <!-- 작성 글 보기-->
<div class="popupLayer" style="display:none; z-index:1200">
	<a href="" class="layer_link"> 작성 글 보기</a>
</div>
<script>
    $(function(){
        /* 클릭 클릭시 클릭을 클릭한 위치 근처에 레이어가 나타난다. */
        $('.popup_menuu').click(function(e)
        {
            var sWidth = window.innerWidth;
            var sHeight = window.innerHeight;

            var oWidth = $('.popupLayer').width();
            var oHeight = $('.popupLayer').height();

            // 레이어가 나타날 위치를 셋팅한다.
            var divLeft = e.clientX + 10;
            var divTop = e.clientY + 5;

            // 레이어 위치를 바꾸었더니 상단기준점(0,0) 밖으로 벗어난다면 상단기준점(0,0)에 배치하자.
            if( divLeft < 0 ) divLeft = 0;
            if( divTop < 0 ) divTop = 0;
            
            // $('.layer_link').prop('href', 'https://dev.ciccommunity.com/board/freetalk?sfield=post_nickname&skeyword='+ $(this).text() +'&search_submit=');
            $('.layer_link').prop('href', `<?php echo base_url('board/cicwriter').'?sfield=post_nickname&skeyword='?>${$(this).text()}`);
            $('.popupLayer').css({
                "top": divTop,
                "left": divLeft,
                "display" : "block"
            }).show();
        });
    });
    $(document).mouseup(function (e){
        var container = $('.popupLayer');
        if( container.has(e.target).length === 0){
        container.css('display','none');
        }
    });
    $(window).on("wheel", function (event){
        $('.popupLayer').css('display','none');
    });
</script>