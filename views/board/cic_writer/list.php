<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>

<div id="container-wrap">
    <div id="top-vis">
        <div class="txt">
            <h2>Writer</h2>
            <p>등록된 회원들이 양질의 정보전달 글, 본인의 칼럼을 게시하는 공간 입니다.</p>
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
                            style="transform: translate3d(-1040px, 0px, 0px); transition: all 0s ease 0s; width: 3900px;">
                                <?php
                                if (element('list',element('writerbest', $view))) {
                                    foreach (element('list',element('writerbest', $view)) as $writerbest) {
                                        ?>
                                        <div class="owl-item" style="width: 240px; margin-right: 20px;">
                                            <div class="item">
                                                <a href="<?php echo goto_url(element('posturl', $writerbest)); ?>">
                                                    <div class="img"><img src="<?php echo element('thumb_url',$writerbest)?>" alt="">
                                                    </div>
                                                    <div class="txt">
                                                        <p class="btxt"><?php echo html_escape(cut_str(strip_tags(element('post_title', $writerbest)), 15)); ?></p>
                                                        <p class="stxt"><?php echo html_escape(cut_str(strip_tags(element('post_content', $writerbest)), 20)); ?></p>
                                                        <p class="ctxt vp"><?php echo number_format(element("post_like_point",$writerbest))?></p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                if (count(element('list', element('bestpost', $view))) < 4) {
                                    ?>
                                    <div class="owl-item" style="width: 240px; margin-right: 20px;">
                                        <div class="item">
                                            <a>
                                                <div class="img"><img src="https://dev.ciccommunity.com/assets/images/news-img01.png" alt="">
                                                </div>
                                                <div class="txt">
                                                    <p class="btxt">선택된 자료가 없습니다.</p>
                                                    <p class="stxt">선택된 자료가 없습니다.</p>
                                                    <p class="ctxt vp"><?php echo number_format(element("post_like_point",$writerbest))?></p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="owl-item" style="width: 240px; margin-right: 20px;">
                                        <div class="item">
                                            <a>
                                                <div class="img"><img src="https://dev.ciccommunity.com/assets/images/news-img01.png" alt="">
                                                </div>
                                                <div class="txt">
                                                    <p class="btxt">선택된 자료가 없습니다.</p>
                                                    <p class="stxt">선택된 자료가 없습니다.</p>
                                                    <p class="ctxt vp"><?php echo number_format(element("post_like_point",$writerbest))?></p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                                                        <div class="owl-item" style="width: 240px; margin-right: 20px;">
                                        <div class="item">
                                            <a>
                                                <div class="img"><img src="https://dev.ciccommunity.com/assets/images/news-img01.png" alt="">
                                                </div>
                                                <div class="txt">
                                                    <p class="btxt">선택된 자료가 없습니다.</p>
                                                    <p class="stxt">선택된 자료가 없습니다.</p>
                                                    <p class="ctxt vp"><?php echo number_format(element("post_like_point",$writerbest))?></p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="owl-item" style="width: 240px; margin-right: 20px;">
                                        <div class="item">
                                            <a>
                                                <div class="img"><img src="https://dev.ciccommunity.com/assets/images/news-img01.png" alt="">
                                                </div>
                                                <div class="txt">
                                                    <p class="btxt">선택된 자료가 없습니다.</p>
                                                    <p class="stxt">선택된 자료가 없습니다.</p>
                                                    <p class="ctxt vp"><?php echo number_format(element("post_like_point",$writerbest))?></p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="owl-item" style="width: 240px; margin-right: 20px;">
                                        <div class="item">
                                            <a>
                                                <div class="img"><img src="https://dev.ciccommunity.com/assets/images/news-img01.png" alt="">
                                                </div>
                                                <div class="txt">
                                                    <p class="btxt">선택된 자료가 없습니다.</p>
                                                    <p class="stxt">선택된 자료가 없습니다.</p>
                                                    <p class="ctxt vp"><?php echo number_format(element("post_like_point",$writerbest))?></p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="owl-item" style="width: 240px; margin-right: 20px;">
                                        <div class="item">
                                            <a>
                                                <div class="img"><img src="https://dev.ciccommunity.com/assets/images/news-img01.png" alt="">
                                                </div>
                                                <div class="txt">
                                                    <p class="btxt">선택된 자료가 없습니다.</p>
                                                    <p class="stxt">선택된 자료가 없습니다.</p>
                                                    <p class="ctxt vp"><?php echo number_format(element("post_like_point",$writerbest))?></p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="owl-item" style="width: 240px; margin-right: 20px;">
                                        <div class="item">
                                            <a>
                                                <div class="img"><img src="https://dev.ciccommunity.com/assets/images/news-img01.png" alt="">
                                                </div>
                                                <div class="txt">
                                                    <p class="btxt">선택된 자료가 없습니다.</p>
                                                    <p class="stxt">선택된 자료가 없습니다.</p>
                                                    <p class="ctxt vp"><?php echo number_format(element("post_like_point",$writerbest))?></p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php
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
                                    <p class="stxt"><?php echo html_escape(cut_str(strip_tags(element('post_content', $result)), 60)); ?>
                                    </p>
                                    <p class="ctxt">
                                        <span><?php echo html_escape(element('post_nickname', $result)); ?></span>
                                        <span><?php echo element('display_datetime', $result); ?></span>
                                        <span>조회 <?php echo number_format(element('post_hit', $result)); ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="abr">
                                <div class="photo">
                                    <p class="pimg"><img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', $result), 30, 30);?>"
                                            alt="<?php echo element('mlc_title', $result); ?>"></p>
                                    <p class="rtxt"><?php echo element('post_nickname', $result); ?></p>
                                </div>
                                <p class="vp"><?php echo number_format(element('post_like_point', $result)-element('post_dislike_point', $result)); ?> VP</p>
                            </div>
                        </a>
                    </li>
                    <?php
                        }
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
                <p class="chk-select">
                    <select>
                        <option value="">제목</option>
                        <option value="">내용</option>
                    </select>
                </p>
                <p class="chk-input">
                    <input type="text" placeholder="검색어를 입력해주세요" autocomplete="off">
                    <a href="<?php echo base_url('post/3')?>" class="search-btn"><span>검색</span></a>
                </p>
            </div>
            <!— e: board-filter —>
        </div>
        <!— page end // —>
    </div>