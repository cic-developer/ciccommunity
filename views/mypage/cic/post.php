<div id="container-wrap">
	<div id="contents" class="div-cont">
		<!-- page start // -->
		<div class="board-wrap list">
			<div class="tab">
				<ul>
					<li class="active"><a href="#n"><span>작성글</span></a></li>
					<li><a href="#n"><span>작성댓글</span></a></li>
					<li><a href="#n"><span>행사한vp</span></a></li>
				</ul>
			</div>
			<div class="list record">
				<table>
					<colgroup>
						<col width="60" />
						<col width="70" />
						<col width="*" />
						<col width="100" />
						<col width="100" />
					</colgroup>
					<thead>
						<tr>
							<th>
								<p class="chk-check">
									<input type="checkbox" id="vsel-all" /><label for="vsel-all"><span
											class="blind">선택</span></label>
								</p>
							</th>
							<th>번호</th>
							<th>제목</th>
							<th>등록일</th>
							<th>조회</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach(element('list',element('data', $view)) as $post ) { ?>
							<tr>
								<td>
									<p class="chk-check">
										<input type="checkbox" id="vsel01" /><label for="vsel01"><span
												class="blind">선택</span></label>
									</p>
								</td>
								<td><span>11</span></td>
								<td class="l"><a href="#">한국인은 대출 안 나오는데 외국인은 80% 해주고 외국인 건물주 논 ... (10)</a></td>
								<td>2020-08-25</td>
								<td>12</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="lower r">
				<a href="#n" class="by-btn"><span>삭제</span></a>
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
			<div class="board-filter">
				<!-- <p class="chk-select">
					<select>
						<option value="">제목</option>
						<option value="">내용</option>
					</select>
				</p> -->
				<p class="chk-input">
					<input type="text" placeholder="검색어를 입력해주세요" autocomplete="off" />
					<a href="#n" class="search-btn"><span>검색</span></a>
				</p>
			</div>
			<!-- e: board-filter -->
		</div>
		<!-- page end // -->
	</div>
</div>
<!-- e: #container-wrap //-->