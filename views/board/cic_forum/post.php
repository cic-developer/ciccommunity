<!-- s : #container-wrap //-->
<div id="container-wrap">
	<!-- <div id="top-vis" class="bg01">
	<h2>Notice</h2>
	<div class="img"><img src="<?php echo base_url('assets/images/top-vis01.jpg')?>" alt=""/></div>
</div> -->
	<div id="contents" class="div-cont">
		<!-- page start // -->
		<div class="board-wrap detail">
			<div class="detail">
				<div class="binfo">
					<h4><span>포럼</span> 입니다.</h4>
					<p>디지털 자산 관련 어떤 이슈가 주목 받을 때 혹은 커뮤니티 운영과 관련해 의사결정을 하는 투표를 진행 할 수 있습니다.</p>
					<p>보유 포인트를 이용해 투표에 참여 가능하고 투표 결과에 따라 <span class="cblack b">순차적</span>으로 보상 포인트를 지급 받습니다.</p>
				</div>
				<div class="gap30"></div>
				<div class="upper r">
					<a href="<?php echo element('list_url', $view); ?>" class="bw-btn"><span>목록</span></a>
					<a href="<?php echo element('url', element('prev_post', $view)); ?>" class="bw-btn"><span>이전</span></a>
					<a href="<?php echo element('url', element('next_post', $view)); ?>" class="bw-btn"><span>다음</span></a>
				</div>
				<div class="tits poll">
					<h3><?php echo html_escape(element('post_title', element('post', $view))); ?></h3>
					<ul>
						<li>
							<div class="my-info">
								<p class="pimg"><img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', element('level', element('post', $view))), 20, 20); ?>"
										alt="<?php echo element('mlc_title', element('level', element('post', $view))); ?>">
								</p>
								<p class="rtxt"><?php echo element('post_nickname', element('post', $view)); ?></p>
							</div>
						</li>
						<li>등록일 : <?php echo element('display_datetime', element('post', $view)); ?> </li>
						<li>조회 : <?php echo number_format(element('post_hit', element('post', $view))); ?> </li>
					</ul>
					<div class="poll-abr">
						<ul>
							<li>
								<p class="btxt">참여마감</p>
								<p class="stxt cred">07:14:20</p>
							</li>
							<li>
								<p class="btxt">포럼마감</p>
								<p class="stxt">21.05.17</p>
							</li>
							<li class="full">
								<p class="btxt">포인트마감</p>
								<p class="stxt">52,211,000 cp</p>
							</li>
						</ul>
					</div>
				</div>
				<div class="cons no-bd">
					<div class="txt">
						<p>일론머스크의한마디에 좌지우지되는 도지코인, <br />과연 1,000원을 넘을 것인가? 아니면 도또속으로 떨어질 것인가?</p>
						<p>당신의 선택은? </p>
					</div>
				</div>
			</div>
			<!-- <div class="lower r">
		<a href="#n" class="bb-btn"><span>목록</span></a>
		<a href="#n" class="bw-btn"><span>이전</span></a>
		<a href="#n" class="bw-btn"><span>다음</span></a>
	</div> -->
		</div>
		<div class="gap50"></div>
		<div class="poll-wrap">
			<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
			<script src="<?php echo base_url('assets/js/jquery/jquery.countup.js')?>"></script>
			<script>
				$(function () {
					$('.counter').countUp();
				});
			</script>
			<div class="cont">
				<h3>도지코인 1000원 갈까?</h3>
				<ul>
					<li>
						<div class="bar">
							<div class="vbar"></div>
							<p class="percent"><span>50%</span></p>
							<p class="nums"><i class="counter">52,213,578</i><span>cp</span></p>
							<p class="popo"><img src="<?php echo base_url('assets/images/forum_popo1.png')?>" alt="" style="cursor:pointer;" /></p>
							<a href="#n"><span>A. 간다</span></a>
							
						</div>
					</li>
					
					<li>
						<div class="bar">
							<div class="vbar"></div>
							<p class="percent"><span>50%</span></p>
							<p class="nums"><i class="counter">52,213,578</i><span>cp</span></p>
							<p class="popo"><img src="<?php echo base_url('assets/images/forum_popo2.png')?>" alt="" style="cursor:pointer;" /></p>
							<a href="#n"><span>B. 안간다</span></a>
						</div>
					</li>
				</ul>
			</div>
			<div class="result" style="display:none">
				<p class="btxt">A. 간다 <span>참여</span></p>
				<div class="abr">
					<p class="cp"><span>150</span> CP</p>
					<a href="#n"><span>추가 참여!</span></a>
					<a href="#n"><span>의견 변경</span></a>
				</div>
			</div>
			<div class="btns">
				<a href="#n" class="enter"><span>투표 참여하기</span></a>
			</div>
		</div>
		<div class="gap50"></div>
		<div class="gap50"></div>
		<!-- s: cmmt -->
		<div class="cmmt-upper">
			<a href="#n" class="cmmt-like">좋아요 <span>2,054</span></a>
			<a href="#n" class="cmmt-singo">신고</a>
			<script>
				$(function () {
					$('.poll-wrap').find('.cont').find('a').click(function () {
						if ($(this).closest('li').hasClass('active')) {
							$(this).closest('li').find('a').removeClass('active');
						} else {
							$(this).closest('li').find('a').addClass('active');
						}
						$(this).closest('li').siblings('li').find('a').removeClass('active');
					});

					$('.poll-wrap').find('.cont').find('li').each(function () {
						var isbar = $(this).find('.percent > span').text();
						$(this).find('.vbar').delay(300).animate({
							'height': isbar
						}, 450);
					});

					$('.poll-wrap').find('.btns > .enter').click(function () {
						if ($(this).closest('.poll-wrap').hasClass('active')) {
							$(this).closest('.poll-wrap').removeClass('active');
							$('.poll-wrap').find('.result').hide();
						} else {
							$(this).closest('.poll-wrap').addClass('active');
							$('.poll-wrap').find('.result').show();
						}

					});
					$('.cmmt-like').click(function () {
						if ($(this).hasClass('active')) {
							$(this).removeClass('active');
						} else {
							$(this).addClass('active');
						}
					})
				})
			</script>
		</div>
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
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt="" /></p>
										<p class="txt">힘을내포포</p>
									</a>
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
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt="" /></p>
										<p class="txt">힘을내포포</p>
									</a>
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
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt="" /></p>
										<p class="txt">힘을내포포</p>
									</a>
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
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt="" /></p>
										<p class="txt">힘을내포포</p>
									</a>
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
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt="" /></p>
										<p class="txt">힘을내포포</p>
									</a>
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
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt="" /></p>
										<p class="txt">힘을내포포</p>
									</a>
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
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt="" /></p>
										<p class="txt">힘을내포포</p>
									</a>
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
						<li class="item">
							<div class="vcon">
								<div class="info">
									<a href="#n" class="nickname">
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt="" /></p>
										<p class="txt">힘을내포포</p>
									</a>
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
						<li class="item">
							<div class="vcon">
								<div class="info">
									<a href="#n" class="nickname">
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt="" /></p>
										<p class="txt">힘을내포포</p>
									</a>
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
						<li class="item">
							<div class="vcon">
								<div class="info">
									<a href="#n" class="nickname">
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt="" /></p>
										<p class="txt">힘을내포포</p>
									</a>
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
						<li class="item">
							<div class="vcon">
								<div class="info">
									<a href="#n" class="nickname">
										<p class="ico"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt="" /></p>
										<p class="txt">힘을내포포</p>
									</a>
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
								<input type="radio" name="jselGroup" id="jsel01" checked /><label
									for="jsel01">욕설/비방</label>
							</p>
							<p class="chk-radio">
								<input type="radio" name="jselGroup" id="jsel02" /><label for="jsel02">홍보/상업성</label>
							</p>
							<p class="chk-radio">
								<input type="radio" name="jselGroup" id="jsel03" /><label for="jsel03">기타</label>
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
				<!-- s: layer-wrap userInfo -->
				<div class="layer-wrap userInfo">
					<p>포럼 전적 <span>7승3패</span></p>
				</div>
				<!-- e: layer-wrap userInfo -->
				<script>
					$(function () {
						$('.info').find('.nickname').click(function () {
							var isParent = $(this).closest('.info');
							$(this).closest('.list').find('.item').removeClass('zdex')
							$(this).closest('.item').addClass('zdex');
							$('.layer-wrap.userInfo').bPopup({
								closeClass: "userInfo-close",
								speed: 0,
								appendTo: isParent,
								follow: [false, false],
								position: [false, false],
								onClose: function () {
									$('.cmmt').find('.item').removeClass('zdex');
								},
								modalColor: 'transparent',
								modal: true,
							});
						});
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
<!-- e: #container-wrap //-->