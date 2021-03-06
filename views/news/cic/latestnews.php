<!-- e : #header-warp //-->
<!-- s : #container-wrap //-->
<div id="container-wrap">
	<div id="top-vis">
		<div class="txt">
			<h2>News</h2>
			<!-- <p>각 코인의 주요뉴스를 보여드립니다</p> -->
		</div>
		<div class="img"><img src="<?php echo base_url('assets/images/top-vis02.jpg') ?>" alt=""></div>
	</div>
	<div id="contents" class="div-cont">
		<!-- page start // -->
		<div class="board-wrap list">
			<div class="list vnews">
                <h3>많이 본 뉴스</h3>
                <div class="vnews-slide owl-loaded owl-drag">
                    <div class="owl-stage-outer">
                        <div class="owl-stage"
                            style="transform: translate3d(-1040px, 0px, 0px); transition: all 0s ease 0s; width: 3900px;">
                                <?php
									if (element('list', element('most_view', $view))) {
                                        foreach (element('list', element('most_view', $view)) as $most_view) {
                                            ?>
                                            <div class="owl-item" style="width: 240px; margin-right: 20px;">
											<div class="item">
												<a href="<?php echo site_url('/news/news_url/'.element('news_id', $most_view)); ?>"  target="_blank">
													<div class="img"><img
															src="<?php echo html_escape(element('news_image', $most_view) ? element('news_image', $most_view) : base_url('assets/images/news-img01.png')) ?>" alt="">
													</div>
													<div class="txt">
														<p class="btxt"><?php echo html_escape(cut_str(str_replace("&nbsp;"," ",strip_tags(element('news_title', $most_view))), 10)); ?></p>
														<p class="stxt"><?php echo html_escape(cut_str(str_replace("&nbsp;"," ",strip_tags(element('news_contents', $most_view))), 10)); ?></p>
														<p class="ctxt"><?php echo html_escape(element('comp_name', element('company', $most_view))); ?>
															<span><?php echo display_datetime(element('news_wdate', $most_view)); ?></span>
														</p>
													</div>
												</a>
											</div>
										</div>
									<?php
										}
									}
									$list_count = count(element('list', element('most_view', $view)));
									$max = 4 - $list_count;
									if($list_count <= 4) {
										for($i = 0; $i < $max; $i++){
									?>
                                    <div class="owl-item" style="width: 240px; margin-right: 20px;">
                                        <div class="item">
                                            <a>
                                                <div class="img"><img src="<?php echo base_url('/assets/images/news-img01.png'); ?>" alt="">
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
			<div class="gap60"></div>
			<div class="vtab">
				<ul>
					<li class="active"><a href="javascript:void(0);"><span>최신뉴스</span></a></li>
					<li><a href="/news"><span>주요뉴스</span></a></li>
				</ul>
			</div>
			<div class="list vimg">
				<ul>
					<!-- <li>
						<a href="javascript:void(0);">
							<div class="img"><img src="<?php echo base_url('assets/images/news-img02.png') ?>" alt="">
							</div>
							<div class="txt">
								<div class="vc">
									<p class="btxt">김창룡 경찰청장 “공직자 부동산 투기는 구속수사 <span>(5)</span></p>
									<p class="stxt">세종 경찰관 투기 의혹 내사 착수 [더백트 | 장우성 기자] 김창룡 경찰청장은 내부정보를 예시 텍스트 입니다 ...
									</p>
									<p class="ctxt">
										<span>블록미디어</span>
										<span>02:18</span>
										<span>조회 82</span> 
									</p>
								</div>
							</div>
						</a>
					</li> -->
					<?php
						if (element('list', element('data', $view))) {
							foreach (element('list', element('data', $view)) as $result) {
								$image_url = element('news_image', $result) ? element('news_image', $result) : base_url('assets/images/news-img02.png');
								?>
							<li>
								<a href="<?php echo site_url('/news/news_url/'.element('news_id', $result)); ?>" target="_blank">
									<div class="img"><img src="<?php echo $image_url ?>" alt="">
									</div>
									<div class="txt">
										<div class="vc">
												<p class="btxt"><?php echo html_escape(element('news_title', $result)); ?><!--<span>(<?php echo number_format(element('news_reviews', $result)); ?>)</span>--></p>
												<p class="stxt"><?php echo html_escape(element('news_contents', $result)); ?></p>
												<p class="ctxt">
													<span><?php echo html_escape(element('comp_name', element('company', $result))); ?></span>
													<span><?php echo display_datetime(element('news_wdate', $result)); ?></span>
													<span>조회 <?php echo number_format(element('news_reviews', $result)); ?></span>
												</p>
										</div>
									</div>
								</a>
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
				<!-- <script>
					$(function () {
						$('.list.vimg').find('li').each(function () {
							var chkimg = $(this).find('.img').length;
							if (chkimg < 1) {
								$(this).addClass('no-img');
							}
						})
					})
				</script> -->
			</div>
			<!-- s: paging-wrap -->
			<!-- <div class="paging-wrap">
				<a href="#" class="prev ctrl"><span>이전</span></a>
				<ul>
					<li><a href="#" class="active">1</a></li>
					<li><a href="javascript:void(0);">2</a></li>
					<li><a href="javascript:void(0);">3</a></li>
					<li><a href="javascript:void(0);">4</a></li>
					<li><a href="javascript:void(0);">5</a></li>
				</ul>
				<p class="num"><span>1</span> / 10 </p>
				<a href="#" class="next ctrl"><span>다음</span></a>
			</div> -->
			 <div class="paging-wrap">
                <?php echo element('paging', $view); ?>
            </div>
			<!-- e: paging-wrap -->
			<!-- s: board-filter -->
			<div class="board-filter">
				<form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
					<p class="chk-select">
						<select name="sfield">
							<?php echo element('search_option', $view); ?>
						</select>
					</p>
					<p class="chk-input">
					<input type="text" name="skeyword" value="<?php echo html_escape(element('skeyword',  $view)); ?>" placeholder="검색어를 입력해주세요" autocomplete="off" />
						<button class="search-btn" name="search_submit" type="submit"></button>
					</p>
				</form>
			</div>
			<!-- e: board-filter -->
		</div>
		<!-- page end // -->
	</div>
</div>
<!-- e: #container-wrap //-->