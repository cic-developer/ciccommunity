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
					<li class="active"><a href="post"><span>작성글</span></a></li>
					<li><a href="comment"><span>작성댓글</span></a></li>
					<li><a href="point"><span>명예포인트기록</span></a></li>
					<li><a href="vp"><span>VP기록</span></a></li>
					<li><a href="cp"><span>CP기록</span></a></li>
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
									<input type="checkbox" name="vsel-all" id="vsel-all" />
									<label for="vsel-all">
										<span class="blind">선택</span>
									</label>
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
										<input type="checkbox" id="<?php echo element('post_id', $post); ?>" name="vsel[]" value="<?php echo element('post_id', $post); ?>" /><label for="<?php echo element('post_id', $post); ?>"><span
												class="blind">선택</span></label>
									</p>
								</td>
								<td><span><?php echo number_format(element('num', $post));?></span></td>
								<td class="l">
									<a href="<?php echo goto_url(element('post_url', $post)); ?>">
										<?php echo html_escape(element('post_title', $post));?>
									</a>
								</td>
								<td><?php echo display_datetime(element('post_datetime', $post), 'full'); ?></td>
								<td><?php echo number_format(element('post_hit', $post));?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<!-- <div class="lower r">
				<a href="javascript:void(0);" class="by-btn list-delete-btn" data-list-delete-url="<?php //echo element('list_delete_url', $view); ?>"><span>삭제</span></a>
			</div> -->
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

<script>
	$(document).on("click", "#vsel-all", function() {
		var chk = document.getElementsByName("vsel[]");
		for (i = 0; i < chk.length; i++) chk[i].checked = this.checked;
	});

	$(document).on('click', '.list-delete-btn', function() {
		console.log("=> ", document);
		list_delete_submit(document.flist, 'delete', $(this).attr('data-list-delete-url'));
	});

	// list delete submit
    function list_delete_submit(f, acttype, actpage){
        var chk = document.getElementsByName("vsel[]");
		var checkLen = 0;
		var checkArr = [];

		for(var val of chk){
			if(val.checked){
				checkArr.push(val.value);
				checkLen++;
			}
		}

		if(checkLen < 1){
			alert('삭제할 게시물을 체크해주세요');
			return;
		}

        if (acttype === 'delete' && ! confirm('선택한 게시물을 정말 삭제 하시겠습니까?')) return;
        f.action = actpage;
		f.submit();
    }   
</script>