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
        <!-- page start / -->
        <div class="board-wrap list">
            <div class="forums">
                <h3>진행중인 <span>BEST</span> 포럼</h3>
                <div class="cont">
                    <a href="#n" class="prev"><span class="blind">이전</span></a>
                    <div class="forum-slide">
                        <div class="item active">
                            <div class="img"><img src="<?php echo base_url('assets/images/forum-img01.jpg')?>" alt="" /></div>
                            <div class="ov">
                                <div class="txt">
                                    <p class="btxt">“ 도지 코인” <br />1,000원 간다!</p>
                                </div>
                                <p class="stxt">총 3,145,789VP</p>
                                <a href="#n"><span>참여하기!</span></a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="img"><img src="<?php echo base_url('assets/images/forum-img02.jpg')?>" alt="" /></div>
                            <div class="ov">
                                <div class="txt">
                                    <p class="btxt">“ 도지 코인” <br />1,000원 간다!</p>
                                </div>
                                <p class="stxt">총 3,145,789VP</p>
                                <a href="#n"><span>참여하기!</span></a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="img"><img src="<?php echo base_url('assets/images/forum-img03.jpg')?>" alt="" /></div>
                            <div class="ov">
                                <div class="txt">
                                    <p class="btxt">“ 도지 코인” <br />1,000원 간다!</p>
                                </div>
                                <p class="stxt">총 3,145,789VP</p>
                                <a href="#n"><span>참여하기!</span></a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="img"><img src="<?php echo base_url('assets/images/forum-img04.jpg')?>" alt="" /></div>
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
                    <li><a href="<?php echo base_url('board/forum')?>"><span>진행중 포럼</span></a></li>
                    <li class="active"><a href="<?php echo base_url('board/userforum')?>"><span>승인대기 포럼</span></a></li>
                    <li><a href="#n"><span>마감된 포럼</span></a></li>
                </ul>
            </div>
            <div class="gap20"></div>
            <div class="forum-filter">
                <div class="sel-box c03">
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
                        <col width="170" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th>제안자</th>
                            <th>제목</th>
                            <th>등록일</th>
                            <th><span class="cyellow">좋아요</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="my-info">
                                    <p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt="" /></p>
                                    <p class="rtxt">코알못259 코알못259</p>
                                </div>
                            </td>
                            <td class="l"><a href="#n">정치 자료, 성인물은 엄격하게 금지하며 강력하게 제재합니다. <span
                                        class="reply">(12)</span></a></td>
                            <td>방금</td>
                            <td>
                                <p class="cyellow">10,000,000</p>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="lower r">
                <div class="ov">
                    <a href="#n" class="by-btn"><span>예치금 넣기<!-- 예치금이 넣어져있으면 예치금 빼기로 변경 --></span></a>
                    <a href="#n" class="by-btn"><span>글쓰기</span></a>
                    <p class="ex-cp">보유 예치금 : <?php echo number_format(element('mem_deposit', $view)); ?> CP</p>
                </div>
            </div>
            <!-- s: paging-wrap -->
            <div class="paging-wrap">
                <!-- <a href="#" class="prev ctrl"><span>이전</span></a> -->
                <ul>
                    <li><a href="#" class="active">1</a></li>
                    <li><a href="#n">2</a></li>
                    <li><a href="#n">3</a></li>
                    <li><a href="#n">4</a></li>
                    <li><a href="#n">5</a></li>
                </ul>
                <p class="num"><span>1</span> / 10 </p>
                <a href="#" class="next ctrl"><span>다음</span></a>
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
                <div class="ov">
                    <div class="sel-box">
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
                    </p>
                </div>
            </div>
            <!-- e: board-filter -->
        </div>
        <!-- page end / -->
    </div>
</div>