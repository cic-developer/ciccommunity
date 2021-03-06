<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<div id="container-wrap">
	<div id="contents" class="div-cont">
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<script>alert("', '");</script>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		?>
		<!-- page start // -->
		<div class="board-wrap list">
			<?php
			echo form_open(current_full_url(), $attributes);
			?>
			<div class="tab">
				<ul>
					<li><a href="post"><span>작성글</span></a></li>
					<li><a href="comment"><span>작성댓글</span></a></li>
					<li><a href="point"><span>명예포인트기록</span></a></li>
					<li><a href="vp"><span>VP기록</span></a></li>
					<li class="active"><a href="cp"><span>CP기록</span></a></li>
				</ul>
			</div>
			<div class="list record">
				<table>
					<colgroup>
						<col width="70" />
						<col width="200" />
						<col width="*" />
						<col width="250" />
						<col width="100" />
					</colgroup>
					<thead>
						<tr>
							<th>번호</th>
							<th>cp</th>
							<th>내용</th>
							<th>메모</th>
							<th>등록일</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach(element('list',element('data', $view)) as $post ) { ?>
							<tr>
								<td><span><?php echo number_format(element('num', $post));?></span></td>
								<td><span><?php echo html_escape(element('cp_point', $post) >= 0 ? '+'.element('cp_point', $post) : element('cp_point', $post));?></span></td>
								<?php if(html_escape(element('post_id', $post))){?>
								<td class="l_memo"><span><a href="<?php echo base_url('post').'/'.element('post_id', $post)?>"><?php echo html_escape(element('cp_content', $post));?></a></span></td>
								<?php }else{ ?>
								<td class="l_memo"><span>
									<?php echo html_escape(element('cp_content', $post));?></span></td>
								<?php } ?>
								<td><?php echo preg_match("/[xE0-xFF][x80-xFF][x80-xFF]/", html_escape(element('cp_action', $post))) ? "" : html_escape(element('cp_action', $post));?></td>
								<td><?php echo display_datetime(element('cp_datetime', $post), 'full', 'Y-m-d H:i'); ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<?php echo form_close(); ?>
			<!-- s: paging-wrap -->
			<div class="paging-wrap">
				<?php echo element('paging', $view); ?>
			</div>
			<!-- e: paging-wrap -->
			<!-- s: board-filter -->
			<form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
				<div class="board-filter">
					<p class="chk-select">
						<select name="sfield">
							<?php echo element('search_option', $view); ?>
						</select>
					</p>
					<p class="chk-input">
						<input type="text" name="skeyword" value="<?php echo html_escape(element('skeyword', $view)); ?>" placeholder="검색어를 입력해주세요" autocomplete="off" />
						<button class="search-btn" name="search_submit" type="submit"></button>
					</p>
				</div>
			</form>
			<!-- e: board-filter -->
		</div>
		<!-- page end // -->
	</div>
</div>
<!-- e: #container-wrap //-->

<style>
	.l_memo a:hover{
		text-decoration:underline; color:#555;
	}
</style>