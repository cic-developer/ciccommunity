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
				<p class="btxt"><span><?php echo element('highlight_keyword', $view);?></span> 에 대한 통합검색 총</p>
				<p class="stxt"><?php echo $total_rows; ?>건</p>
			</div>
			<!-- HERE THE PRICE -->
			<?php if($trade){ ?>
				<div class="result" style="height: 100px">
					<div class="txt" >
						<div class="vc">
						
							<div>
								<em class="stxt pimg" style="float: left"><img style= "width: 30px" style= "height: 30px"; style= "float: left"; src="https://static.upbit.com/logos/<?php echo $symbole; ?>.png"></img>
								<strong  class="btxt center" style= "width: 100px"; style= "height: 700px"> <?php echo $korean; ?></strong><em>
								<p class="stxt"><span> KRW-<?php echo $symbole; ?> </span></p>
							</div>
							<canvas class="text-center" id="canvas"></canvas>
						</div>

						
					</div>
					<div style= "float: right">
						<p class="btxt"> ￦ <span style="color:blue" ><?php echo $trade; ?></p>
						<p class="stxt"> 고가 <span style="color:blue"> ￦ <?php echo $high; ?> </span></p>
						<p class="stxt"> 저가<span style="color:red"> ￦ <?php echo $low; ?> </span></p>
					</div>	
					
				</div>
			<?php
			}
			if(!$trade){?>
				<div></div>
			<?php } ?>	
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

							if (element('list', element('data', $view))) {
								foreach (element('list', element('data', $view)) as $result) {
							?>
								<tr>
									<td>
										<div class="my-info">
											<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png')?>"
													alt=""></p>
											<p class="rtxt"><?php echo element('post_nickname', $result); ?></p>
										</div>
									</td>
									<td class="l notice"><a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('post_title', $result)); ?>">
										<?php echo html_escape(element('post_title', $result)); ?></a></td>
									<td><?php echo element('display_datetime', $result); ?></td>
									<td><?php echo number_format(element('post_hit', $result)); ?></td>
									<td>
										<p class="cyellow"><?php echo number_format(element('post_like_point', $result)-element('post_dislike_point', $result)); ?></p>
									</td>
								</tr>
							<?php
								}
							}
							if (!element('list', element('data', $view)))  {
							?>
								<tr>
									<td colspan="5" class="nopost">게시물이 없습니다</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					<div class="paging-wrap">
						<?php echo element('paging', $view); ?>
					</div>
				</div>
				<div class="gap75"></div>
				<div class="tits">
					<h3>WRITER</h3>
					<a href="#n" class="more"><span>more</span></a>
				</div>
				<div class="list vimg vp">
					<ul>
					<?php
						if (element('list', element('data', $view))) {
							foreach (element('list', element('data', $view)) as $result) {
					?>		
						<li>
							<a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('post_title', $result)); ?>">
								<div class="img"><img src="<?php echo base_url('assets/images/news-img02.png')?>" alt=""></div>
								<div class="txt">
									<div class="vc">
										<p class="btxt"><?php echo html_escape(element('post_title', $result)); ?><span class="yellow-bg"><?php echo element('highlight_keyword', $view);?></span> 
											<span>(<?php echo element('post_comment_count', $result); ?>)</span></p>
											<p class="stxt"><?php echo html_escape(cut_str(strip_tags(element('post_content', $result)), 60)); ?></p>
										<p class="ctxt">
											<span><?php echo html_escape(element('post_nickname', $result)); ?></span>
											<span><?php echo element('display_datetime', $result); ?></span>
											<span>조회 <?php echo number_format(element('post_hit', $result));?></span>
										</p>
									</div>
								</div>
								<div class="abr">
									<div class="photo">
										<p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png')?>" alt=""></p>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script>
var ctx = document.getElementById('canvas');
var contex = ctx.getContext("2d");
var r = 3;
var r_ = 17;
var r__ = 6;
ctx.width = 200; 
ctx.heigh = 70;
var data = {
labels: ['', '', '', ''],
datasets: [{
	 
	label: 'Bitcoin',
    data: [12, r, r_,r__],
	backgroundColor: "white",
	borderColor: "#3e95cd"
    }]
};
var option = {
	responsive: false,
    maintainAspectRatio: false,
	legend: {
        display: false
    },
	scales: {
		yAxes:{
    		stacked:false,
        	gridLines: {
        		display:false,
            }
    	},
		xAxes:{
			gridLines: {
				display:false
			}
    	}
    }
};
var myBarChart = Chart.Line(canvas,{
	data:data,
  	options:option
});
</script>
