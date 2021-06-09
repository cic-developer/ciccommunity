<div id="container-wrap">
    <div id="top-vis">
        <div class="txt">
            <h2>Forum</h2>
            <p>이슈에 관련해서 투표를 진행하거나 PER 생태계에 대한 의사결정을 하며 의견을 교환할 수 있는 공간입니다. <br />포인트로 투표에 참여할 수 있으며 ‘운영정책’에 따라 지급 포인트를
                지출하거나 받게 됩니다. </p>
        </div>
        <div class="img forum"><img src="<?php echo base_url('assets/images/top-vis05.jpg')?>" alt="" /></div>
    </div>
    <div id="contents" class="div-cont">
        <!-- page start // -->
        <div class="board-wrap list">
            <div class="forums">
                <h3>진행중인 <span>BEST</span> 포럼</h3>
                <div class="cont">
                    <a href="#n" class="prev"><span class="blind">이전</span></a>
                    <div class="forum-slide">

                        <?php
                        if (element('list',element('banner', $view))) {
                            foreach (element('list',element('banner', $view)) as $banner) {
                        ?>
                            <div class="item">
                                <div class="img"><img src="<?php echo base_url('uploads/forum_banner/'.element('frm_image', $banner)) ?>" alt="" />
                                </div>

                                <div class="ov">
                                    <div class="txt">
                                        <p class="btxt"><?php echo html_escape(element('post_title', $banner)); ?></p>
                                    </div>
                                    <p class="stxt">총 <?php echo rs_number_format(element('cic_forum_total_cp', $banner), 2, 0); ?> CP</p>
                                    <a href="<?php echo element('post_url', $banner); ?>"><span>참여하기!</span></a>
                                </div>
                            </div>
                        <?php
                            }
                        }
                        ?>

                        <!-- 포럼 기본 이미지 입니다. 승인대기포럼 승인시 설정된 포럼 이미지가 없을 경우 해당 기본 이미지가 보여집니다 -->
                        <!-- 슬라이드바에 보여지는 포럼은, 마감되지 않은 진행중인 포럼에 한해서만 보여집니다 -->
                        <!-- 현재 기본이미지 경로는 두 경우가 있습니다. 편하신대로 사용하시면 됩니다. -->
                        <!-- 1. assets/images/forum-img01.jpg -->
                        <!-- 2. uploads/forum_banner/2021/06/forum-img01.jpg ( 이 이미지의 경로는 대기포럼 승인시 설정한 이미지가 저장되는 경로입니다 ) -->
                        <?php for($i=0; $i<element('banner_noimage_count', $view); $i=$i+1){ ?>
                            <div class="item">
                                <div class="img"><img src="<?php echo base_url('uploads/forum_banner/2021/06/forum-img01.jpg') ?>" alt="" />
                                <!-- <div class="img"><img src="<?php echo base_url('assets/images/noimage.jpg') ?>" alt="" /> -->
                                </div>

                                <div class="ov">
                                    <div class="txt">
                                        <p class="btxt">빈 게시물 입니다 :)</p>
                                    </div>
                                    <p class="stxt">총 0 CP</p>
                                    <a href="#n"><span>참여불가!</span></a>
                                </div>
                            </div>
                        <?php }?>
                        
                    </div>
                    <a href="#n" class="next"><span class="blind">다음</span></a>
                </div>
            </div>
            <div class="gap50"></div>
            <div class="ftab">
                <ul>
                    <li class="<?php echo element('type', $view) == 1 ? 'active' : ';' ?>"><a href="<?php echo base_url('board/forum?type=1')?>"><span>진행중 포럼</span></a></li>
                    <li><a href="<?php echo base_url('board/userforum')?>"><span>승인대기 포럼</span></a></li>
                    <li class="<?php echo element('type', $view) == 2 ? 'active' : ';' ?>"><a href="<?php echo base_url('board/forum?type=2')?>"><span>마감된 포럼</span></a></li>
                </ul>
            </div>
            <div class="gap20"></div>
            <div class="forum-filter">
                <div class="sel-box c02">
                    <a href="#n" class="sel-btn"><span>포럼마감순</span></a>
                    <ul>
                        <!-- <li class="active"><a href="#n"><span>포럼진행순</span></a></li> -->
                        <li><a href="<?php echo element('cic_forum_info.frm_close_datetime', element('sort', $view)); ?>"><span>포럼마감순</span></a></li>
                    </ul>
                </div>
                <div class="sel-box">
                    <a href="#n" class="sel-btn"><span>
                    <?php if(element('sorted', $view) == 'post_id') { ?>
                        최신순
                    <?php } else if(element('sorted', $view) == 'post_title') { ?>
                        관련도순
                    <?php } else if(element('sorted', $view) == 'cic_forum_total_cp') { ?>
                        인기순
                    <?php } else {?>
                        최신순
                    <?php } ?>
                    </span></a>
                    <ul>
                        <li class="<?php echo element('sorted', $view) == 'post_id' ? 'active' : '' ?>"><a href="<?php echo element('post_id', element('sort', $view)); ?>"><span>최신 순</span></a></li>
                        <li class="<?php echo element('sorted', $view) == 'post_title' ? 'active' : '' ?>"><a href="<?php echo element('post_title', element('sort', $view)); ?>"><span>관련도 순</span></a></li>
                        <li class="<?php echo element('sorted', $view) == 'cic_forum_total_cp' ? 'active' : '' ?>"><a href="<?php echo element('cic_forum_total_cp', element('sort', $view)); ?>"><span>인기 순</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="list forum">
                <table>
                    <colgroup>
                        <col width="170" />
                        <col width="*" />
                        <col width="100" />
                        <col width="100" />
                        <col width="170" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th>제안자</th>
                            <th>제목</th>
                            <th>참여마감<!-- 일:시:분 단위입니다. 일 시:분 이게 나을까요??--></th>
                            <th>포럼마감<!-- 위와 마찬가지이나 마감된 포럼 리스트에서는 연.월.일 형식으로 표시되었으면 합니다.--></th>
                            <th><span class="cyellow">참여금액</span></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    
                    if (element('list', element('data', element('list', $view)))) {
                        foreach (element('list', element('data', element('list', $view))) as $result) {
                    ?>
                        <tr>
                            <td>
                                <div class="my-info">
                                    <p class="pimg"><img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', $result), 30, 30); ?>"
                                            alt="<?php echo element('mlc_title', $result); ?>"></p>
                                    <p class="rtxt"><?php echo html_escape(element('post_nickname', $result)); ?></p>
                                </div>
                            </td>
                            <td class="l">
                                <a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('title', $result)); ?>"><?php echo html_escape(element('title', $result)); ?>
                                    <span class="reply">(<?php echo element('post_comment_count', $result); ?>)</span>
                                </a>
                            </td>
                            <td><?php echo display_datetime(element('frm_bat_close_datetime', $result), 'full'); ?></td>
                            <td><?php echo display_datetime(element('frm_close_datetime', $result), 'full'); ?></td>
                            <td><p class="cyellow"><?php echo rs_number_format(element('cic_forum_total_cp', $result), 2, 0); ?></p></td>
                        </tr>
                        <!-- <tr>
                            <td>
                                <div class="my-info">
                                    <p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png')?>"
                                            alt="" /></p>
                                    <p class="rtxt">코알못259 코알못259</p>
                                </div>
                            </td>
                            <td class="l"><a href="<?php echo base_url('post/4')?>">정치 자료, 성인물은 엄격하게 금지하며 강력하게 제재합니다. <span
                                        class="reply">(12)</span></a></td>
                            <td>13:33:59</td>
                            <td>13:33:59</td>
                            <td>
                                <p class="cyellow">10,000,000</p>
                            </td>
                        </tr> -->
                    <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <!-- s: paging-wrap -->
            <div class="paging-wrap">
                <?php echo element('paging', element('list', $view)); ?>
            </div>
            <!-- e: paging-wrap -->
            <!-- s: board-filter -->
            <div class="board-filter sel">
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
            <!-- e: board-filter -->
        </div>
        <!-- page end // -->
    </div>
</div>