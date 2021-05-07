<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<div id="container-wrap">
	<div id="top-vis">
		<div class="txt">
			<h2>community</h2>
		</div>
		<div class="img"><img src="<?php echo base_url('assets/images/top-vis04.jpg') ?>" alt=""></div>
	</div>
	<div id="contents" class="div-cont">
		<!-- page start // -->
		<div class="board-wrap detail">

			<div class="detail">
				<div class="binfo">
					<h4><span>자유게시판</span> 입니다.</h4>
					<p>유저들의 의견을 자유롭게 공유할 수 있는 공간입니다. 단, 사이트 내에 명시 된 ‘운영정책’ 을 따릅니다. </p>
					<p>게시글에 대해서 up / down으로 의견을 표출할 수 있습니다. 작성자는 보팅에 따라 지급 포인트를 받습니다.</p>
				</div>
				<div class="gap30"></div>
				<div class="upper r">
					<a href="<?php echo element('list_url', $view); ?>" class="bw-btn"><span>목록</span></a>
					<a href="<?php echo element('url', element('prev_post', $view)); ?>" class="bw-btn"><span>이전</span></a>
					<a href="<?php echo element('url', element('next_post', $view)); ?>" class="bw-btn"><span>다음</span></a>
				</div>
				<div class="tits vp">
					<!-- <p class="logo"><img src="<?php echo base_url('assets/images/record-logo.jpg') ?>" alt=""/></p> -->
					<h3><?php echo html_escape(element('post_title', element('post', $view))); ?></h3>
					<ul>
						<li>
							<div class="my-info">
								<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
										alt="">
								</p>
								<p class="rtxt"><?php echo element('post_nickname', element('post', $view)); ?></p>
							</div>
						</li>
						<li>등록일 : <?php echo element('display_datetime', element('post', $view)); ?> </li>
						<li>조회 : <?php echo number_format(element('post_hit', element('post', $view))); ?> </li>
					</ul>
					<div class="abr">
						<?php 
						if(element('level',element('post', $view))) {
						?>
						<p <?php echo (element('mlc_level',element('level',element('post', $view))) >= 0) ? 'style="color:#444;"' : '' ?>>
							<?php echo element('mlc_level',element('level',element('post', $view))).' '.html_escape(element('mlc_title',element('level',element('post', $view)))); ?>
						</p>
						<?php 
						} 
						?>
						<div class="vp-point">
							<ul>
								<li><a href="#n" class="up"><?php echo number_format(element('post_like_point', element('post', $view))); ?></a></li>
								<li><a href="#n" class="down"><?php echo number_format(element('post_dislike_point', element('post', $view))); ?></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="cons">
					<!-- 본문 내용 시작 -->
					<div class="txt">
						<?php echo element('content', element('post', $view)); ?>
					</div>
					<!-- 본문 내용 끝 -->
					<div class="vp-point">
						<ul>
							<li><a href="#n" class="up"><?php echo number_format(element('post_like_point', element('post', $view))); ?></a></li>
							<li><a href="#n" class="down"><?php echo number_format(element('post_dislike_point', element('post', $view))); ?></a></li>
						</ul>
					</div>
					<!-- <div class="modify">
						<?php //if (element('modify_url', $view)) { ?>
						<a href="<?php //echo element('modify_url', $view); ?>" class="mo-btn">
							<span>수정<span>
						</a>
						<?php //} ?>
						<?php //	if (element('delete_url', $view)) { ?>
						<a href="javascript:void(0);" class="mo-btn btn-one-delete" data-one-delete-url="<?php // echo element('delete_url', $view); ?>">
							<span>삭제<span>
						</a>
						<?php // } ?>
					</div> -->
				</div>
				<!-- <div class="files">
			<ul>
				<li><a href="#">2020년 여성과 문화 지원사업 공모.pdf</a></li>
				<li><a href="#">2020년 개성상인 지원사업 공모.pdf</a></li>
			</ul>
		</div>
		<div class="others">
			<ul>
				<li>
					<p class="btxt">다음글</p>
					<a href="#">다음 글이 없습니다.</a>
				</li>
				<li>
					<p class="btxt">이전글</p>
					<a href="#">"축" 대통령 및 국토교통부 장관 표창 수상</a>
				</li>
			</ul>
		</div> -->
			</div>
			<div class="lower r">
				<?php if(element('modify_url', $view)){ ?>
				<a href="<?php echo element('modify_url', $view); ?>" class="bw-btn"><span>수정</span></a>
				<?php } ?>
				<?php if(element('delete_url', $view)){ ?>
				<a href="javascript:void(0);" class="bw-btn btn-one-delete" data-one-delete-url="<?php echo element('delete_url', $view); ?>"><span>삭제</span></a>
				<?php } ?>
			</div>
			<div class="gap60"></div>
			<div class="best">
				<div class="fl">
					<h4>BEST VP UP</h4>
					<ul>
						<li>
							<a href="#n">
								<span class="num">1</span>
								<div class="my-info">
									<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
											alt=""></p>
									<p class="rtxt">코린이1235</p>
								</div>
								<span class="txt">[스압] 월급루팡이 만들어지는 과정 (5)</span>
								<span class="vp">102,522</span>
							</a>
						</li>
						<li>
							<a href="#n">
								<span class="num">2</span>
								<div class="my-info">
									<p class="pimg"><img src="<?php echo base_url('assets/images/like-popo.png') ?>"
											alt="">
									</p>
									<p class="rtxt">가즈아</p>
								</div>
								<span class="txt">[스압] 월급루팡이 만들어지는 과정 (5)</span>
								<span class="vp">102,522</span>
							</a>
						</li>
						<li>
							<a href="#n">
								<span class="num">3</span>
								<div class="my-info">
									<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
											alt=""></p>
									<p class="rtxt">코린이1235</p>
								</div>
								<span class="txt">[스압] 월급루팡이 만들어지는 과정 (5)</span>
								<span class="vp">102,522</span>
							</a>
						</li>
						<li>
							<a href="#n">
								<span class="num">4</span>
								<div class="my-info">
									<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
											alt=""></p>
									<p class="rtxt">코린이1235</p>
								</div>
								<span class="txt">[스압] 월급루팡이 만들어지는 과정 (5)</span>
								<span class="vp">102,522</span>
							</a>
						</li>
						<li>
							<a href="#n">
								<span class="num">5</span>
								<div class="my-info">
									<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
											alt=""></p>
									<p class="rtxt">코알못259</p>
								</div>
								<span class="txt">[스압] 월급루팡이 만들어지는 과정 (5)</span>
								<span class="vp">102,522</span>
							</a>
						</li>
						<li>
							<a href="#n">
								<span class="num">6</span>
								<div class="my-info">
									<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
											alt=""></p>
									<p class="rtxt">코린이1235</p>
								</div>
								<span class="txt">[스압] 월급루팡이 만들어지는 과정 (5)</span>
								<span class="vp">102,522</span>
							</a>
						</li>
						<li>
							<a href="#n">
								<span class="num">7</span>
								<div class="my-info">
									<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
											alt=""></p>
									<p class="rtxt">코알못259</p>
								</div>
								<span class="txt">[스압] 월급루팡이 만들어지는 과정 (5)</span>
								<span class="vp">102,522</span>
							</a>
						</li>
						<li>
							<a href="#n">
								<span class="num">8</span>
								<div class="my-info">
									<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
											alt=""></p>
									<p class="rtxt">코알못259</p>
								</div>
								<span class="txt">[스압] 월급루팡이 만들어지는 과정 (5)</span>
								<span class="vp">102,522</span>
							</a>
						</li>
						<li>
							<a href="#n">
								<span class="num">9</span>
								<div class="my-info">
									<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
											alt=""></p>
									<p class="rtxt">코알못259</p>
								</div>
								<span class="txt">[스압] 월급루팡이 만들어지는 과정 (5)</span>
								<span class="vp">102,522</span>
							</a>
						</li>
					</ul>
				</div>
				<div class="fr">
					<h4>BEST VP DOWN</h4>
					<ul>
						<li>
							<a href="#n">
								<span class="num">1</span>
								<div class="my-info">
									<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
											alt=""></p>
									<p class="rtxt">코린이1235</p>
								</div>
								<span class="txt">[스압] 월급루팡이 만들어지는 과정 (5)</span>
								<span class="vp">102,522</span>
							</a>
						</li>
						<li>
							<a href="#n">
								<span class="num">2</span>
								<div class="my-info">
									<p class="pimg"><img src="<?php echo base_url('assets/images/like-popo.png') ?>"
											alt="">
									</p>
									<p class="rtxt">가즈아</p>
								</div>
								<span class="txt">[스압] 월급루팡이 만들어지는 과정 (5)</span>
								<span class="vp">102,522</span>
							</a>
						</li>
						<li>
							<a href="#n">
								<span class="num">3</span>
								<div class="my-info">
									<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
											alt=""></p>
									<p class="rtxt">코린이1235</p>
								</div>
								<span class="txt">[스압] 월급루팡이 만들어지는 과정 (5)</span>
								<span class="vp">102,522</span>
							</a>
						</li>
						<li>
							<a href="#n">
								<span class="num">4</span>
								<div class="my-info">
									<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
											alt=""></p>
									<p class="rtxt">코린이1235</p>
								</div>
								<span class="txt">[스압] 월급루팡이 만들어지는 과정 (5)</span>
								<span class="vp">102,522</span>
							</a>
						</li>
						<li>
							<a href="#n">
								<span class="num">5</span>
								<div class="my-info">
									<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
											alt=""></p>
									<p class="rtxt">코알못259</p>
								</div>
								<span class="txt">[스압] 월급루팡이 만들어지는 과정 (5)</span>
								<span class="vp">102,522</span>
							</a>
						</li>
						<li>
							<a href="#n">
								<span class="num">6</span>
								<div class="my-info">
									<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
											alt=""></p>
									<p class="rtxt">코린이1235</p>
								</div>
								<span class="txt">[스압] 월급루팡이 만들어지는 과정 (5)</span>
								<span class="vp">102,522</span>
							</a>
						</li>
						<li>
							<a href="#n">
								<span class="num">7</span>
								<div class="my-info">
									<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
											alt=""></p>
									<p class="rtxt">코알못259</p>
								</div>
								<span class="txt">[스압] 월급루팡이 만들어지는 과정 (5)</span>
								<span class="vp">102,522</span>
							</a>
						</li>
						<li>
							<a href="#n">
								<span class="num">8</span>
								<div class="my-info">
									<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
											alt=""></p>
									<p class="rtxt">코알못259</p>
								</div>
								<span class="txt">[스압] 월급루팡이 만들어지는 과정 (5)</span>
								<span class="vp">102,522</span>
							</a>
						</li>
						<li>
							<a href="#n">
								<span class="num">9</span>
								<div class="my-info">
									<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
											alt=""></p>
									<p class="rtxt">코알못259</p>
								</div>
								<span class="txt">[스압] 월급루팡이 만들어지는 과정 (5)</span>
								<span class="vp">102,522</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="gap60"></div>
		<!-- s: cmmt -->
		<div class="cmmt-wrap">
			<div class="comment">
				<h4>댓글 <span>49</span></h4>
				<div class="ov">
					<textarea placeholder="인터넷은 우리가 함께 만들어가는 소중한 공간입니다. 답글 작성시 타인에 대한 배려와 책임을 담아주세요."></textarea>
					<div class="btns">
						<a href="#n" class="write-btn"><span>댓글등록</span></a>
					</div>
				</div>
			</div>
			<div class="cmmt">
				<!-- <p class="total">댓글 <span>49</span></p> -->
				
				<div class="list">
					<ul>
						<li class="item">
							<div class="vcon">
								<div class="info">
									<a href="#n" class="nickname">
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
												alt=""></p>
										<p class="txt">힘을내포포</p>
									</a>
									<div class="vp-point">
										<ul>
											<li>
												<p class="up">12</p>
											</li>
											<li>
												<p class="down">35</p>
											</li>
										</ul>

									</div>
									
								</div>
								<div class="vtxt">
									<p>포겔요정 바로싼 등장!! 감사합니다~ </p>
								</div>
								<div class="ctrls">
									<ul>
										<li>
											<p class="date">21. 03. 04 19:08</p>
										</li>
										<li><a href="#n" class="cmmt-btn"><span>답글</span></a></li>
										<li><a href="#n" class="singo-btn"><span>신고</span></a></li>
									</ul>
								</div>
								<div class="comment">
									<textarea
										placeholder="인터넷은 우리가 함께 만들어가는 소중한 공간입니다. 답글 작성시 타인에 대한 배려와 책임을 담아주세요."></textarea>
									<div class="btns">
										<a href="#n" class="write-btn"><span>답글등록</span></a>
									</div>
								</div>
							</div>
							<div class="reply cdepth1">
								<div class="info">
									<a href="#n" class="nickname">
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
												alt=""></p>
										<p class="txt">힘을내포포</p>
									</a>
									<div class="vp-point">
										<ul>
											<li>
												<p class="up">12</p>
											</li>
											<li>
												<p class="down">35</p>
											</li>
										</ul>
									</div>
								</div>
								<div class="vtxt">
									<p>머야 준다는건가용? 사랑합니당 </p>
								</div>
								<div class="ctrls">
									<ul>
										<li>
											<p class="date">21. 03. 04 19:08</p>
										</li>
										<li><a href="#n" class="cmmt-btn"><span>답글</span></a></li>
										<li><a href="#n" class="singo-btn"><span>신고</span></a></li>
									</ul>
								</div>
								<div class="comment">
									<textarea
										placeholder="인터넷은 우리가 함께 만들어가는 소중한 공간입니다. 답글 작성시 타인에 대한 배려와 책임을 담아주세요."></textarea>
									<div class="btns">
										<a href="#n" class="write-btn"><span>답글등록</span></a>
									</div>
								</div>
							</div>
							<div class="reply cdepth2">
								<div class="info">
									<a href="#n" class="nickname">
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
												alt=""></p>
										<p class="txt">힘을내포포</p>
									</a>
									<div class="vp-point">
										<ul>
											<li>
												<p class="up">12</p>
											</li>
											<li>
												<p class="down">35</p>
											</li>
										</ul>
									</div>
								</div>
								<div class="vtxt">
									<p>회원님께서는 이미 답글 컨텐츠의 긍정적인 영향을 미친 회원으로 선정되어 최초 1회에 한해 보상을 받으신것으로 확인됩니다.^^;;; </p>
								</div>
								<div class="ctrls">
									<ul>
										<li>
											<p class="date">21. 03. 04 19:08</p>
										</li>
										<li><a href="#n" class="cmmt-btn"><span>답글</span></a></li>
										<li><a href="#n" class="singo-btn"><span>신고</span></a></li>
									</ul>
								</div>
								<div class="comment">
									<textarea
										placeholder="인터넷은 우리가 함께 만들어가는 소중한 공간입니다. 답글 작성시 타인에 대한 배려와 책임을 담아주세요."></textarea>
									<div class="btns">
										<a href="#n" class="write-btn"><span>답글등록</span></a>
									</div>
								</div>
							</div>
						</li>
						<li class="item">
							<div class="vcon">
								<div class="info">
									<a href="#n" class="nickname">
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
												alt=""></p>
										<p class="txt">힘을내포포</p>
									</a>
									<div class="vp-point">
										<ul>
											<li>
												<p class="up">12</p>
											</li>
											<li>
												<p class="down">35</p>
											</li>
										</ul>
									</div>
								</div>
								<div class="vtxt">
									<p>....혼자 진지했네요 민망 </p>
								</div>
								<div class="ctrls">
									<ul>
										<li>
											<p class="date">21. 03. 04 19:08</p>
										</li>
										<li><a href="#n" class="cmmt-btn"><span>답글</span></a></li>
										<li><a href="#n" class="singo-btn"><span>신고</span></a></li>
									</ul>
								</div>
								<div class="comment">
									<textarea
										placeholder="인터넷은 우리가 함께 만들어가는 소중한 공간입니다. 답글 작성시 타인에 대한 배려와 책임을 담아주세요."></textarea>
									<div class="btns">
										<a href="#n" class="write-btn"><span>답글등록</span></a>
									</div>
								</div>
							</div>
						</li>
						<li class="item">
							<div class="vcon">
								<div class="info">
									<a href="#n" class="nickname">
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
												alt=""></p>
										<p class="txt">힘을내포포</p>
									</a>
									<div class="vp-point">
										<ul>
											<li>
												<p class="up">12</p>
											</li>
											<li>
												<p class="down">35</p>
											</li>
										</ul>
									</div>
								</div>
								<div class="vtxt">
									<p>채팅창지킴이 아쟈르가 딱이닷!!! 깔깔 </p>
								</div>
								<div class="ctrls">
									<ul>
										<li>
											<p class="date">21. 03. 04 19:08</p>
										</li>
										<li><a href="#n" class="cmmt-btn"><span>답글</span></a></li>
										<li><a href="#n" class="singo-btn"><span>신고</span></a></li>
									</ul>
								</div>
								<div class="comment">
									<textarea
										placeholder="인터넷은 우리가 함께 만들어가는 소중한 공간입니다. 답글 작성시 타인에 대한 배려와 책임을 담아주세요."></textarea>
									<div class="btns">
										<a href="#n" class="write-btn"><span>답글등록</span></a>
									</div>
								</div>
							</div>
							<div class="reply cdepth1">
								<div class="info">
									<a href="#n" class="nickname">
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
												alt=""></p>
										<p class="txt">힘을내포포</p>
									</a>
									<div class="vp-point">
										<ul>
											<li>
												<p class="up">12</p>
											</li>
											<li>
												<p class="down">35</p>
											</li>
										</ul>
									</div>
								</div>
								<div class="vtxt">
									<p>제 닉네임은 너무 유니크해서 바꿔준다고 해도 안바꿀래요 하하 </p>
								</div>
								<div class="ctrls">
									<ul>
										<li>
											<p class="date">21. 03. 04 19:08</p>
										</li>
										<li><a href="#n" class="cmmt-btn"><span>답글</span></a></li>
										<li><a href="#n" class="singo-btn"><span>신고</span></a></li>
									</ul>
								</div>
								<div class="comment">
									<textarea
										placeholder="인터넷은 우리가 함께 만들어가는 소중한 공간입니다. 답글 작성시 타인에 대한 배려와 책임을 담아주세요."></textarea>
									<div class="btns">
										<a href="#n" class="write-btn"><span>답글등록</span></a>
									</div>
								</div>
							</div>
						</li>
						<li class="item">
							<div class="vcon">
								<div class="info">
									<a href="#n" class="nickname">
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
												alt=""></p>
										<p class="txt">힘을내포포</p>
									</a>
									<div class="vp-point">
										<ul>
											<li>
												<p class="up">12</p>
											</li>
											<li>
												<p class="down">35</p>
											</li>
										</ul>
									</div>
								</div>
								<div class="vtxt">
									<p>내 닉넴은 유니크한거라 바꿔준대도 싫음 </p>
								</div>
								<div class="ctrls">
									<ul>
										<li>
											<p class="date">21. 03. 04 19:08</p>
										</li>
										<li><a href="#n" class="cmmt-btn"><span>답글</span></a></li>
										<li><a href="#n" class="singo-btn"><span>신고</span></a></li>
									</ul>
								</div>
								<div class="comment">
									<textarea
										placeholder="인터넷은 우리가 함께 만들어가는 소중한 공간입니다. 답글 작성시 타인에 대한 배려와 책임을 담아주세요."></textarea>
									<div class="btns">
										<a href="#n" class="write-btn"><span>답글등록</span></a>
									</div>
								</div>
							</div>
						</li>
						<li class="item vfm">
							<div class="vcon">
								<div class="info">
									<a href="#n" class="nickname">
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
												alt=""></p>
										<p class="txt">힘을내포포</p>
									</a>
									<div class="vp-point">
										<ul>
											<li>
												<p class="up">12</p>
											</li>
											<li>
												<p class="down">35</p>
											</li>
										</ul>
									</div>
								</div>
								<div class="vtxt">
									<p>내 닉넴은 유니크한거라 바꿔준대도 싫음 </p>
								</div>
								<div class="ctrls">
									<ul>
										<li>
											<p class="date">21. 03. 04 19:08</p>
										</li>
										<li><a href="#n" class="cmmt-btn"><span>답글</span></a></li>
										<li><a href="#n" class="singo-btn"><span>신고</span></a></li>
									</ul>
								</div>
								<div class="comment">
									<textarea
										placeholder="인터넷은 우리가 함께 만들어가는 소중한 공간입니다. 답글 작성시 타인에 대한 배려와 책임을 담아주세요."></textarea>
									<div class="btns">
										<a href="#n" class="write-btn"><span>답글등록</span></a>
									</div>
								</div>
							</div>
						</li>
						<li class="item vfm">
							<div class="vcon">
								<div class="info">
									<a href="#n" class="nickname">
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
												alt=""></p>
										<p class="txt">힘을내포포</p>
									</a>
									<div class="vp-point">
										<ul>
											<li>
												<p class="up">12</p>
											</li>
											<li>
												<p class="down">35</p>
											</li>
										</ul>
									</div>
								</div>
								<div class="vtxt">
									<p>내 닉넴은 유니크한거라 바꿔준대도 싫음 </p>
								</div>
								<div class="ctrls">
									<ul>
										<li>
											<p class="date">21. 03. 04 19:08</p>
										</li>
										<li><a href="#n" class="cmmt-btn"><span>답글</span></a></li>
										<li><a href="#n" class="singo-btn"><span>신고</span></a></li>
									</ul>
								</div>
								<div class="comment">
									<textarea
										placeholder="인터넷은 우리가 함께 만들어가는 소중한 공간입니다. 답글 작성시 타인에 대한 배려와 책임을 담아주세요."></textarea>
									<div class="btns">
										<a href="#n" class="write-btn"><span>답글등록</span></a>
									</div>
								</div>
							</div>
						</li>
						<li class="item vfm">
							<div class="vcon">
								<div class="info">
									<a href="#n" class="nickname">
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
												alt=""></p>
										<p class="txt">힘을내포포</p>
									</a>
									<div class="vp-point">
										<ul>
											<li>
												<p class="up">12</p>
											</li>
											<li>
												<p class="down">35</p>
											</li>
										</ul>
									</div>
								</div>
								<div class="vtxt">
									<p>내 닉넴은 유니크한거라 바꿔준대도 싫음 </p>
								</div>
								<div class="ctrls">
									<ul>
										<li>
											<p class="date">21. 03. 04 19:08</p>
										</li>
										<li><a href="#n" class="cmmt-btn"><span>답글</span></a></li>
										<li><a href="#n" class="singo-btn"><span>신고</span></a></li>
									</ul>
								</div>
								<div class="comment">
									<textarea
										placeholder="인터넷은 우리가 함께 만들어가는 소중한 공간입니다. 답글 작성시 타인에 대한 배려와 책임을 담아주세요."></textarea>
									<div class="btns">
										<a href="#n" class="write-btn"><span>답글등록</span></a>
									</div>
								</div>
							</div>
						</li>
						<li class="item vfm">
							<div class="vcon">
								<div class="info">
									<a href="#n" class="nickname">
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png') ?>"
												alt=""></p>
										<p class="txt">힘을내포포</p>
									</a>
									<div class="vp-point">
										<ul>
											<li>
												<p class="up">12</p>
											</li>
											<li>
												<p class="down">35</p>
											</li>
										</ul>
									</div>
								</div>
								<div class="vtxt">
									<p>내 닉넴은 유니크한거라 바꿔준대도 싫음 </p>
								</div>
								<div class="ctrls">
									<ul>
										<li>
											<p class="date">21. 03. 04 19:08</p>
										</li>
										<li><a href="#n" class="cmmt-btn"><span>답글</span></a></li>
										<li><a href="#n" class="singo-btn"><span>신고</span></a></li>
									</ul>
								</div>
								<div class="comment">
									<textarea
										placeholder="인터넷은 우리가 함께 만들어가는 소중한 공간입니다. 답글 작성시 타인에 대한 배려와 책임을 담아주세요."></textarea>
									<div class="btns">
										<a href="#n" class="write-btn"><span>답글등록</span></a>
									</div>
								</div>
							</div>
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
				<!-- s: layer-wrap.singo -->
				<div class="layer-wrap singo">
					<div class="is-top">
						<h2>신고하기</h2>
						<a href="#n" class="close singo-close"><span class="blind">닫기</span></a>
					</div>
					<div class="is-con">
						<div class="sel">
							<p class="chk-radio">
								<input type="radio" name="jselGroup" id="jsel01" checked=""><label
									for="jsel01">욕설/비방</label>
							</p>
							<p class="chk-radio">
								<input type="radio" name="jselGroup" id="jsel02"><label for="jsel02">홍보/상업성</label>
							</p>
							<p class="chk-radio">
								<input type="radio" name="jselGroup" id="jsel03"><label for="jsel03">기타</label>
							</p>
						</div>
						<textarea placeholder="신고내용을 작성해주세요"></textarea>
					</div>
					<div class="is-btm">
						<a href="#n" class="enter-btn singo-close"><span>확인</span></a>
						<a href="#n" class="cancel-btn singo-close"><span>취소</span></a>
					</div>
				</div>
				<!-- s: layer-wrap.singo -->
				<script>
					$(function () {
						var istotal = $('.cmmt').find('.item').length;
						var ischk = (istotal / 2) + 1
						$('.cmmt').find('.item:nth-child(n+' + ischk + ')').addClass('vfm');
						$('.ctrls').find('.cmmt-btn').click(function () {
							$('.cmmt-wrap').find('.singo-btn').removeClass('active');
							if ($(this).hasClass('active')) {
								$(this).removeClass('active');
								$(this).closest('.vcon').removeClass('active');
								$(this).closest('.reply').removeClass('active');
								$(this).closest('.ctrls').removeClass('active');
							} else {
								$(this).addClass('active');
								$(this).closest('.vcon').addClass('active');
								$(this).closest('.reply').addClass('active');
								$(this).closest('.ctrls').addClass('active');
							}
							$('.layer-wrap.singo').bPopup({
								speed: 0,
								follow: [false, false],
								position: [false, false],
								modalColor: false,
								modal: false,
								onClose: function () {
									$('.cmmt').find('.cread').removeClass('cread')
								},
							}).close();
						});
						$('.cmmt-wrap').find('.singo-btn').click(function () {
							$('.cmmt-wrap').find('.singo-btn').removeClass('active');
							$(this).addClass('active');
							$('.layer-wrap.singo').bPopup({
								speed: 0,
								follow: [false, false],
								position: [false, false],
								modalColor: false,
								modal: false,
								onClose: function () {
									$('.cmmt').find('.cread').removeClass('cread')
								},
							}).close();
							var obj = $(this).position();
							var abj = $(this).position();
							var thispar = $(this).closest('.ctrls');
							$(this).closest('.ctrls').parent().addClass('cread');
							$(this).closest('.ctrls').parent().parent('li').addClass('cread');
							$('.layer-wrap.singo').css({
								'top': obj.top,
								'left': obj.left,
								'margin-top': '20px',
								'margin-left': '0'
							});
							$('.layer-wrap.singo').bPopup({
								closeClass: "singo-close",
								speed: 0,
								appendTo: $(thispar),
								onClose: function () {
									$('.cmmt').find('.cread').removeClass('cread')
								},
								follow: [false, false],
								position: [false, false],
								modalColor: false,
								modal: false,
							});
						});
					})
				</script>
			</div>
			<!-- e: cmmt -->
			<!-- page end // -->
		</div>
	</div>
</div>
