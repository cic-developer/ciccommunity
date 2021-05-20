<div id="container-wrap">
		<div id="contents" class="div-cont">
		<!-- page start // -->
		<div class="search-wrap list">
			<div class="filter">
				<div class="sel-box c01">
					<a href="#n" class="sel-btn"><span>통합검색</span></a>
					<ul>
						<li class="active"><a href="#n"><span>통합검색</span></a></li>
						<li><a href="#n"><span>제목</span></a></li>
						<li><a href="#n"><span>내용</span></a></li>
						<li><a href="#n"><span>작성자</span></a></li>
					</ul>
				</div>
				<div class="field search">
                    <?php 
						$attributes = array('class' => 'search_box', 'name' => 'searchForm', 'id' => 'searchForm', 'action' => base_url('/search'));
						echo form_open(current_full_url(), $attributes);
					?>
					<p class="chk-input"><input type="text" placeholder="검색어를 입력해주세요" autocomplete="off"></p>
					<button class="enter"><span class="blind">검색</span></button>
                    <?php echo form_close(); ?>
				</div>
				<div class="abr">
					<div class="sel-box c02">
						<a href="#n" class="sel-btn"><span>제목만</span></a>
						<ul>
							<li class="active"><a href="#n"><span>제목만</span></a></li>
							<li><a href="#n"><span>내용만</span></a></li>
						</ul>
					</div>
					<div class="sel-box c03">
						<a href="#n" class="sel-btn"><span>최신순</span></a>
						<ul>
							<li class="active"><a href="#n"><span>최신 순</span></a></li>
							<li><a href="#n"><span>관련도 순</span></a></li>
							<li><a href="#n"><span>인기 순</span></a></li>
						</ul>
					</div>
				</div>
				
			</div>
			<div class="result">
				<p class="btxt"><span> “ <?php echo $korean; ?>”</span> 에 대한 통합검색 총</p>
				<p class="stxt">2,547건</p>
			</div>
			<!-- HERE THE PRICE -->
			<div class="result">
				<p class="btxt"><span style="color:red" ><?php echo $korean; ?></span></p>
				<p class="stxt display-4"> <?php echo $trade; ?></p>
				<p class="stxt"> <?php echo $low; ?></p>
				<p class="stxt"> <?php echo $high; ?></p>				
			</div>
			<!-- PRICE UNTIL HERE -->


			<div class="gap35"></div>
			<div class="cont">
				<div class="tits">
					<h3>자유게시판</h3>
					<a href="#n" class="more"><span>more</span></a>
				</div>
				<div class="list community">
					<table>
						<colgroup>
							<col width="170">
							<col width="*">
							<col width="100">
							<col width="100">
							<col width="100">
						</colgroup>
						<thead>
							<tr>
								<th>글쓴이</th>
								<th>제목</th>
								<th>등록일</th>
								<th>조회</th>
								<th><span class="cyellow">VP</span></th>
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
                            <td class="l file">
                                <a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('title', $result)); ?>"><?php echo html_escape(element('title', $result)); ?>
                                    <span class="reply">(<?php echo element('post_comment_count', $result); ?>)</span>
                                </a>
                            </td>
                            <td><?php echo element('display_datetime', $result); ?></td>
                            <td><?php echo number_format(element('post_hit', $result)); ?></td>
                            <td>
                                <p class="cyellow"><?php echo number_format(element('post_like_point', $result)-element('post_dislike_point', $result)); ?></p>
                            </td>
                        </tr>
                    <?php
                        }
                    }
                    if ( ! element('notice_list', element('list', $view)) && ! element('list', element('data', element('list', $view)))) {
                    ?>
                        <tr>
                            <td colspan="5" class="nopost">게시물이 없습니다</td>
                        </tr>
                    <?php } ?>
                    </tbody>
						</tbody>
					</table>
				</div>
				<div class="gap75"></div>
				<div class="tits">
					<h3>WRITER</h3>
					<a href="#n" class="more"><span>more</span></a>
				</div>
				<div class="list vimg vp">
					<ul>
						<li>
							<a href="#n">
								<div class="img"><img src="<?php echo base_url('assets/images/news-img02.png')?>" alt=""></div>
								<div class="txt">
									<div class="vc">
										<p class="btxt">김창룡 경찰청장 “공직자 부동산 투기는 <span class="yellow-bg">리플</span>수사 <span>(5)</span></p>	
										<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ... </p>
										<p class="ctxt">
											<span>블록미디어</span>
											<span>02:18</span>
											<span>조회 82</span>
										</p>
									</div>
								</div>
								<div class="abr">
									<div class="photo">
										<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt=""></p>
										<p class="rtxt">코알못259</p>
									</div>
									<p class="vp">256 VP</p>
								</div>	
							</a>
						</li>
						<li>
							<a href="#n">
								<div class="img"><img src="<?php echo base_url('assets/images/news-img02.png')?>" alt=""></div>
								<div class="txt">
									<div class="vc">
										<p class="btxt">김창룡 경찰청장 “공직자 부동산 투기는 구속수사 <span>(5)</span></p>	
										<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ... </p>
										<p class="ctxt">
											<span>블록미디어</span>
											<span>02:18</span>
											<span>조회 82</span>
										</p>
									</div>
								</div>
								<div class="abr">
									<div class="photo">
										<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt=""></p>
										<p class="rtxt">코알못259</p>
									</div>
									<p class="vp">256 VP</p>
								</div>	
							</a>
						</li>
						<li>
							<a href="#n">
								<div class="img"><img src="<?php echo base_url('assets/images/news-img02.png')?>" alt=""></div>
								<div class="txt">
									<div class="vc">
										<p class="btxt">김창룡 경찰청장 “공직자 <span class="yellow-bg">리플</span> 투기는 구속수사 <span>(5)</span></p>	
										<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ... </p>
										<p class="ctxt">
											<span>블록미디어</span>
											<span>02:18</span>
											<span>조회 82</span>
										</p>
									</div>
								</div>
								<div class="abr">
									<div class="photo">
										<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt=""></p>
										<p class="rtxt">코알못259</p>
									</div>
									<p class="vp">256 VP</p>
								</div>	
							</a>
						</li>
						<li class="no-img">
							<a href="#n">
								<div class="txt">
									<div class="vc">
										<p class="btxt">김창룡 경찰청장 “공직자 부동산 <span class="yellow-bg">리플</span>은 구속수사 <span>(5)</span></p>	
										<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ... </p>
										<p class="ctxt">
											<span>블록미디어</span>
											<span>02:18</span>
											<span>조회 82</span>
										</p>
									</div>
								</div>
								<div class="abr">
									<div class="photo">
										<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt=""></p>
										<p class="rtxt">코알못259</p>
									</div>
									<p class="vp">256 VP</p>
								</div>	
							</a>
						</li>
						<li>
							<a href="#n">
								<div class="img"><img src="<?php echo base_url('assets/images/news-img02.png')?>" alt=""></div>
								<div class="txt">
									<div class="vc">
										<p class="btxt">김창룡 경찰청장 “공직자 부동산 투기는 구속수사 <span>(5)</span></p>	
										<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ... </p>
										<p class="ctxt">
											<span>블록미디어</span>
											<span>02:18</span>
											<span>조회 82</span>
										</p>
									</div>
								</div>
								<div class="abr">
									<div class="photo">
										<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt=""></p>
										<p class="rtxt">코알못259</p>
									</div>
									<p class="vp">256 VP</p>
								</div>	
							</a>
						</li>
						<li>
							<a href="#n">
								<div class="img"><img src="<?php echo base_url('assets/images/news-img02.png')?>" alt=""></div>
								<div class="txt">
									<div class="vc">
										<p class="btxt">김창룡 경찰청장 “공직자 부동산 투기는 구속수사 <span>(5)</span></p>	
										<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ... </p>
										<p class="ctxt">
											<span>블록미디어</span>
											<span>02:18</span>
											<span>조회 82</span>
										</p>
									</div>
								</div>
								<div class="abr">
									<div class="photo">
										<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt=""></p>
										<p class="rtxt">코알못259</p>
									</div>
									<p class="vp">256 VP</p>
								</div>	
							</a>
						</li>
					</ul>
					<script>
						$(function(){
							$('.list.vimg').find('li').each(function(){
								var chkimg = $(this).find('.img').length;
								if(chkimg<1){
									$(this).addClass('no-img');
								}
							})
						})
					</script>
				</div>
				<div class="gap75"></div>
				<div class="tits">
					<h3>NEWS</h3>
					<a href="#n" class="more"><span>more</span></a>
				</div>
				<div class="list vimg">
				<ul>
					<li>
						<a href="#n">
							<div class="img"><img src="<?php echo base_url('assets/images/news-img02.png')?>" alt=""></div>
							<div class="txt">
								<div class="vc">
									<p class="btxt">김창룡 경찰청장 “공직자 부동산 투기는 구속수사 <span>(5)</span></p>	
									<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ... </p>
									<p class="ctxt">
										<span>블록미디어</span>
										<span>02:18</span>
										<span>조회 82</span>
									</p>
								</div>
							</div>
						</a>
					</li>
					<li>
						<a href="#n">
							<div class="img"><img src="<?php echo base_url('assets/images/news-img02.png')?>" alt=""></div>
							<div class="txt">
								<div class="vc">
									<p class="btxt">김창룡 경찰청장 “공직자 부동산 투기는 구속수사 <span>(5)</span></p>	
									<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ... </p>
									<p class="ctxt">
										<span>블록미디어</span>
										<span>02:18</span>
										<span>조회 82</span>
									</p>
								</div>
							</div>
						</a>
					</li>
					<li>
						<a href="#n">
							<div class="img"><img src="<?php echo base_url('assets/images/news-img02.png')?>" alt=""></div>
							<div class="txt">
								<div class="vc">
									<p class="btxt">김창룡 경찰청장 “공직자 부동산 투기는 구속수사 <span>(5)</span></p>	
									<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ... </p>
									<p class="ctxt">
										<span>블록미디어</span>
										<span>02:18</span>
										<span>조회 82</span>
									</p>
								</div>
							</div>
						</a>
					</li>
					<li class="no-img">
						<a href="#n">
							<div class="txt">
								<div class="vc">
									<p class="btxt">김창룡 경찰청장 “공직자 부동산 투기는 구속수사 <span>(5)</span></p>	
									<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ... </p>
									<p class="ctxt">
										<span>블록미디어</span>
										<span>02:18</span>
										<span>조회 82</span>
									</p>
								</div>
							</div>
						</a>
					</li>
					<li>
						<a href="#n">
							<div class="img"><img src="<?php echo base_url('assets/images/news-img02.png')?>" alt=""></div>
							<div class="txt">
								<div class="vc">
									<p class="btxt">김창룡 경찰청장 “공직자 부동산 투기는 구속수사 <span>(5)</span></p>	
									<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ... </p>
									<p class="ctxt">
										<span>블록미디어</span>
										<span>02:18</span>
										<span>조회 82</span>
									</p>
								</div>
							</div>
						</a>
					</li>
					<li>
						<a href="#n">
							<div class="img"><img src="<?php echo base_url('assets/images/news-img02.png')?>" alt=""></div>
							<div class="txt">
								<div class="vc">
									<p class="btxt">김창룡 경찰청장 “공직자 부동산 투기는 구속수사 <span>(5)</span></p>	
									<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ... </p>
									<p class="ctxt">
										<span>블록미디어</span>
										<span>02:18</span>
										<span>조회 82</span>
									</p>
								</div>
							</div>
						</a>
					</li>
				</ul>
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
		</div>		
		<!-- page end // -->
		</div>
	</div>
	<!-- e: #container-wrap //-->
</div>