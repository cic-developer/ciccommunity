<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<div id="container-wrap">
    <div id="top-vis">
        <div class="txt">
            <h2>Notice</h2>
            <!-- <p>각 코인의 주요뉴스를 보여드립니다</p> -->
        </div>
        <div class="img"><img src="<?php echo base_url('assets/images/top-vis01.jpg') ?>" alt=""></div>
    </div>
    <div id="contents" class="div-cont mb-nopad">
        <!-- page start // -->
        <div class="board-wrap list">
            <div class="list notice">
                <table>
                    <colgroup>
                        <col width="100">
                        <col width="*">
                        <col width="100">
                        <col width="100">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>번호</th>
                            <th>제목</th>
                            <th>등록일</th>
                            <th>조회</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="notice">
                            <td><span>공지</span></td>
                            <td class="l" style="padding-left: 48px;"><a href="<?php echo base_url('post/8')?>">씨아이씨 멤버쉽 혜택 안내</a></td>
                            <td>2020-08-25</td>
                            <td>112</td>
                        </tr>
                        <tr class="notice">
                            <td><span>공지</span></td>
                            <td class="l" style="padding-left: 48px;"><a href="<?php echo base_url('post/8')?>">씨아이씨 멤버쉽 혜택 안내</a></td>
                            <td>2020-08-25</td>
                            <td>112</td>
                        </tr>
                        <tr>
                            <td><span>11</span></td>
                            <td class="l"><a href="<?php echo base_url('post/8')?>">한국인은 대출 안 나오는데 외국인은 80% 해주고 외국인 건물주 논 ... (10)</a></td>
                            <td>2020-08-25</td>
                            <td>12</td>
                        </tr>
                        <tr>
                            <td><span>10</span></td>
                            <td class="l"><a href="<?php echo base_url('post/8')?>">운전하는게 점점 힘들어지고 하기 싫어지네요... (6)</a></td>
                            <td>2020-08-25</td>
                            <td>12</td>
                        </tr>
                        <tr>
                            <td><span>9</span></td>
                            <td class="l"><a href="<?php echo base_url('post/8')?>">담금주인데 안에 들어간 것이 뭔지 아시는 분 계실까요? ... (3)</a></td>
                            <td>2020-08-25</td>
                            <td>12</td>
                        </tr>
                        <tr>
                            <td><span>8</span></td>
                            <td class="l"><a href="<?php echo base_url('post/8')?>">한국인은 대출 안 나오는데 외국인은 80% 해주고 외국인 건물주 논 ... (10)</a></td>
                            <td>2020-08-25</td>
                            <td>12</td>
                        </tr>
                        <tr>
                            <td><span>7</span></td>
                            <td class="l"><a href="<?php echo base_url('post/8')?>">운전하는게 점점 힘들어지고 하기 싫어지네요... (6)</a></td>
                            <td>2020-08-25</td>
                            <td>12</td>
                        </tr>
                        <tr>
                            <td><span>6</span></td>
                            <td class="l"><a href="<?php echo base_url('post/8')?>">담금주인데 안에 들어간 것이 뭔지 아시는 분 계실까요? ... (3)</a></td>
                            <td>2020-08-25</td>
                            <td>12</td>
                        </tr>
                        <tr>
                            <td><span>5</span></td>
                            <td class="l"><a href="<?php echo base_url('post/8')?>">한국인은 대출 안 나오는데 외국인은 80% 해주고 외국인 건물주 논 ... (10)</a></td>
                            <td>2020-08-25</td>
                            <td>12</td>
                        </tr>
                        <tr>
                            <td><span>4</span></td>
                            <td class="l"><a href="<?php echo base_url('post/8')?>">운전하는게 점점 힘들어지고 하기 싫어지네요... (6)</a></td>
                            <td>2020-08-25</td>
                            <td>12</td>
                        </tr>
                        <tr>
                            <td><span>2</span></td>
                            <td class="l"><a href="<?php echo base_url('post/8')?>">담금주인데 안에 들어간 것이 뭔지 아시는 분 계실까요? ... (3)</a></td>
                            <td>2020-08-25</td>
                            <td>12</td>
                        </tr>
                        <tr>
                            <td><span>1</span></td>
                            <td class="l"><a href="<?php echo base_url('post/8')?>">담금주인데 안에 들어간 것이 뭔지 아시는 분 계실까요? ... (3)</a></td>
                            <td>2020-08-25</td>
                            <td>12</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- s: paging-wrap -->
            <div class="paging-wrap">
                <!-- <a href="<?php echo base_url('post/8')?>" class="prev ctrl"><span>이전</span></a> -->
                <ul>
                    <li><a href="<?php echo base_url('post/8')?>" class="active">1</a></li>
                    <li><a href="#n">2</a></li>
                    <li><a href="#n">3</a></li>
                    <li><a href="#n">4</a></li>
                    <li><a href="#n">5</a></li>
                </ul>
                <p class="num"><span>1</span> / 10 </p>
                <a href="<?php echo base_url('post/8')?>" class="next ctrl"><span>다음</span></a>
            </div>
            <!-- e: paging-wrap -->
            <!-- s: board-filter -->
            <div class="board-filter">
                <!-- <p class="chk-select">
					<select>
						<option value="">제목</option>
						<option value="">내용</option>
					</select>
				</p> -->
                <p class="chk-input">
                    <input type="text" placeholder="검색어를 입력해주세요" autocomplete="off">
                    <a href="#n" class="search-btn"><span>검색</span></a>
                </p>
            </div>
            <!-- e: board-filter -->
        </div>
        <!-- page end // -->
    </div>
</div>