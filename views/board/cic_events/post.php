<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<div id="container-wrap">
	<div id="top-vis">
		<div class="txt">
			<h2>이벤트</h2>
		</div>
		<div class="img"><img src="<?php echo base_url('assets/images/top-vis01.jpg') ?>" alt=""></div>
	</div>
	<div id="contents" class="div-cont">
		<!-- page start // -->
		<div class="board-wrap detail">
			<div class="detail">
				<div class="upper r">
					<a href="<?php echo element('list_url', $view); ?>" class="bw-btn"><span>목록</span></a>
					<a href="<?php echo element('url', element('prev_post', $view)); ?>" class="bw-btn"><span>이전</span></a>
					<a href="<?php echo element('url', element('next_post', $view)); ?>" class="bw-btn"><span>다음</span></a>
				</div>
				<div class="tits">
					<h3><?php echo html_escape(element('post_title', element('post', $view))); ?></h3>
					<ul>
						<li>등록일 : <?php echo element('display_datetime', element('post', $view)); ?> </li>
						<li>작성자 : <?php echo html_escape(element('post_nickname', element('post', $view))); ?> </li>
						<li>조회 : <?php echo number_format(element('post_hit', element('post', $view))); ?> </li>
					</ul>
				</div>
				<!-- 본문 내용 시작 -->
				
				<div class="cons">
					<?php echo element('content', element('post', $view)); ?>
				</div>
				<!-- 본문 내용 끝 -->
				<?php if (element('file_download_count', $view) > 0) { ?>
				<div class="files">
					<ul>
						<?php	foreach (element('file_download', $view) as $key => $value) { ?>
						<li><a href="javascript:file_download('<?php echo element('download_link', $value); ?>')"><?php echo html_escape(element('pfi_originname', $value)); ?>(<?php echo byte_format(element('pfi_filesize', $value)); ?>)</a></li>
						<?php
						}
						?>
					</ul>
				</div>
				
				<script type="text/javascript">
				//<![CDATA[
				function file_download(link) {
					<?php if (element('point_filedownload', element('board', $view)) < 0) { ?>if ( ! confirm("파일을 다운로드 하시면 포인트가 차감(<?php echo number_format(element('point_filedownload', element('board', $view))); ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?")) { return; }<?php }?>
					document.location.href = link;
				}
				//]]>
				</script>
				<?php
				}
				?>
				
				<div class="others">
					<ul>
						<li>
							<p class="btxt">다음글</p>
							<?php if(element('next_post', $view)){ ?>
								<a href="<?php echo element('url', element('next_post', $view)); ?>"><?php echo element('post_title', element('next_post', $view)); ?></a>
							<?php } else { ?>
								<a href="javascript:void(0);">다음 글이 없습니다.</a>
							<?php } ?>
						</li>
						<li>
							<p class="btxt">이전글</p>
							<?php if(element('prev_post', $view)){ ?>
								<a href="<?php echo element('url', element('prev_post', $view)); ?>"><?php echo element('post_title', element('prev_post', $view)); ?></a>
							<?php } else { ?>
								<a href="javascript:void(0);">이전 글이 없습니다.</a>
							<?php } ?>
						</li>
					</ul>
				</div>
			</div>
			<div class="lower r">
				<?php if(element('modify_url', $view)){ ?>
				<a href="<?php echo element('modify_url', $view); ?>" class="bw-btn"><span>수정</span></a>
				<?php } ?>
				<?php if(element('delete_url', $view)){ ?>
				<a href="javascript:void(0);" class="bw-btn btn-one-delete" data-one-delete-url="<?php echo element('delete_url', $view); ?>"><span>삭제</span></a>
				<?php } ?>
			</div>

		</div>
		<!-- page end // -->
	</div>
</div>
