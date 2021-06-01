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
                        <div class="item active">
                            <div class="img"><img src="<?php echo base_url('assets/images/forum-img01.jpg')?>" alt="" />
                            </div>
                            <div class="ov">
                                <div class="txt">
                                    <p class="btxt">“ 도지 코인” <br />1,000원 간다!</p>
                                </div>
                                <p class="stxt">총 3,145,789VP</p>
                                <a href="#n"><span>참여하기!</span></a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="img"><img src="<?php echo base_url('assets/images/forum-img02.jpg')?>" alt="" />
                            </div>
                            <div class="ov">
                                <div class="txt">
                                    <p class="btxt">“ 도지 코인” <br />1,000원 간다!</p>
                                </div>
                                <p class="stxt">총 3,145,789VP</p>
                                <a href="#n"><span>참여하기!</span></a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="img"><img src="<?php echo base_url('assets/images/forum-img03.jpg')?>" alt="" />
                            </div>
                            <div class="ov">
                                <div class="txt">
                                    <p class="btxt">“ 도지 코인” <br />1,000원 간다!</p>
                                </div>
                                <p class="stxt">총 3,145,789VP</p>
                                <a href="#n"><span>참여하기!</span></a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="img"><img src="<?php echo base_url('assets/images/forum-img04.jpg')?>" alt="" />
                            </div>
                            <div class="ov">
                                <div class="txt">
                                    <p class="btxt">“ 도지 코인” <br />1,000원 간다!</p>
                                </div>
                                <p class="stxt">총 3,145,789VP</p>
                                <a href="#n"><span>참여하기!</span></a>
                            </div>
                        </div>
                    </div>
                    <a href="#n" class="next"><span class="blind">다음</span></a>
                </div>
            </div>
            <div class="gap50"></div>
            <div class="ftab">
                <ul>
                    <li class="active"><a href="<?php echo base_url('board/forum?findex=&category_id=1')?>"><span>진행중 포럼</span></a></li>
                    <li><a href="<?php echo base_url('board/userforum')?>"><span>승인대기 포럼</span></a></li>
                    <li><a href="<?php echo base_url('board/forum?findex=&category_id=2')?>"><span>마감된 포럼</span></a></li>
                </ul>
            </div>
            <div class="gap20"></div>
            <div class="forum-filter">
                <div class="sel-box c02">
                    <a href="#n" class="sel-btn"><span>포럼마감순</span></a>
                    <ul>
                        <li class="active"><a href="#n"><span>포럼진행순</span></a></li>
                        <li><a href="#n"><span>포럼마감순</span></a></li>
                    </ul>
                </div>
                <div class="sel-box">
                    <a href="#n" class="sel-btn"><span>최신순</span></a>
                    <ul>
                        <li class="active"><a href="#n"><span>최신 순</span></a></li>
                        <li><a href="#n"><span>관련도 순</span></a></li>
                        <li><a href="#n"><span>인기 순</span></a></li>
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
                            <td>13:33:59</td>
                            <td>13:33:59</td>
                            <td> <p class="cyellow">10,000,000</p></td>
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
                <!-- <p class="chk-select">
					<select>
						<option value="">제목</option>
						<option value="">내용</option>
					</select>
				</p> -->
                <!-- <div class="ov"> -->
                    <!-- <div class="sel-box">
                        <a href="#n" class="sel-btn"><span>제목</span></a>
                        <ul>
                            <li class="active"><a href="#n"><span>제목+내용</span></a></li>
                            <li><a href="#n"><span>제목</span></a></li>
                            <li><a href="#n"><span>내용</span></a></li>
                            <li><a href="#n"><span>닉네임</span></a></li>
                        </ul>
                    </div>
                    <p class="chk-input">
                        <input type="text" placeholder="검색어를 입력해주세요" autocomplete="off" />
                        <a href="#n" class="search-btn"><span>검색</span></a>
                    </p> -->
                <!-- </div> -->
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