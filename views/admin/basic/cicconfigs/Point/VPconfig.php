<div class="box">
	<div class="box-header">
		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/VPconfig'); ?>" onclick="return check_form_changed();">VP 설정</a></li>
		</ul>
	</div>
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open(current_full_url(), $attributes);
		?>
			<input type="hidden" name="is_submit" value="1" />
		<?php foreach(element('list',element('data', $view)) as $value) {?>
			<div class="form-group">
				<input type="hidden" name="vpc_id[]" value="<?php echo element('vpc_id', $value) ?>"/>
				<label class="col-sm-3 control-label"><?php echo element('vpc_title', $value)."<br/>(".element('vpc_description', $value).")"?></label>
					<div class="col-sm-8">
						활성화 -
						<label for="vpc_enable" class="control-label">
							<select name="vpc_enable[]" id="doc_layout" class="form-control">
								<option value="0" <?php echo element('vpc_enable', $value) === '0' ? 'selected' : ''; ?>>비활성</option>
								<option value="1" <?php echo element('vpc_enable', $value) === '1' ? 'selected' : '';; ?>>활성</option>
							</select>
						</label>
				
						지급 비율/절대값 -
						<label for="vpc_value" class="control-label">
							<input type="number" class="form-control" name="vpc_value[]" id="vpc_value" value="<?php echo element('vpc_value', $value)?>">
							<?php echo element('vpc_class', $value) === '1' ? '%' : ''; ?>
						</label>
					</div>
			</div>
		<?php } ?>

			<div class="form-group">
				<label class="col-sm-3 control-label">자유 게시판 추천/비추천 최대최소 입력 포인트<br/>(게시글 추천/비추천 시 입력할 수 있는 VP)</label>
				<div class="col-sm-8">
					최소 입력 VP - 
					<label for="like_min_vp" class="control-label">
						<input type="number" id="like_min_vp" value="<?php echo element('cfg_value',element('like_min_vp', $view))?>" name="like_min_vp"/>
					</label>

					최대 입력 VP - <?php echo element('cfg', $view)?>
					<label for="like_max_vp" class="control-label">
						<input type="number" id="like_max_vp" value="<?php echo element('cfg_value',element('like_max_vp', $view))?>" name="like_max_vp"/>
					</label>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">자유 게시판 댓글 추천/비추천 최대최소 입력 포인트<br/>(댓글 추천/비추천 시 입력할 수 있는 VP)</label>
				<div class="col-sm-8">
					최소 입력 VP - 
					<label for="like_comment_min_vp" class="control-label">
						<input type="number" id="like_comment_min_vp" value="<?php echo element('cfg_value',element('like_comment_min_vp', $view))?>" name="like_comment_min_vp"/>
					</label>

					최대 입력 VP - <?php echo element('cfg', $view)?>
					<label for="like_comment_max_vp" class="control-label">
						<input type="number" id="like_comment_max_vp" value="<?php echo element('cfg_value',element('like_comment_max_vp', $view))?>" name="like_comment_max_vp"/>
					</label>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">CIC WRITER 추천/비추천 최대최소 입력 포인트<br/>(게시글 추천/비추천 시 입력할 수 있는 VP)</label>
				<div class="col-sm-8">
					최소 입력 VP - 
					<label for="writer_like_min_vp" class="control-label">
						<input type="number" id="writer_like_min_vp" value="<?php echo element('cfg_value',element('writer_like_min_vp', $view))?>" name="writer_like_min_vp"/>
					</label>

					최대 입력 VP - <?php echo element('cfg', $view)?>
					<label for="writer_like_max_vp" class="control-label">
						<input type="number" id="writer_like_max_vp" value="<?php echo element('cfg_value',element('writer_like_max_vp', $view))?>" name="writer_like_max_vp"/>
					</label>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">CIC WRITER 댓글 추천/비추천 최대최소 입력 포인트<br/>(댓글 추천/비추천 시 입력할 수 있는 VP)</label>
				<div class="col-sm-8">
					최소 입력 VP - 
					<label for="like_comment_min_vp" class="control-label">
						<input type="number" id="writer_like_comment_min_vp" value="<?php echo element('cfg_value',element('writer_like_comment_min_vp', $view))?>" name="writer_like_comment_min_vp"/>
					</label>

					최대 입력 VP - <?php echo element('cfg', $view)?>
					<label for="writer_like_comment_max_vp" class="control-label">
						<input type="number" id="writer_like_comment_max_vp" value="<?php echo element('cfg_value',element('writer_like_comment_max_vp', $view))?>" name="writer_like_comment_max_vp"/>
					</label>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">포럼 댓글 추천/비추천 최대최소 입력 포인트<br/>(댓글 추천/비추천 시 입력할 수 있는 VP)</label>
				<div class="col-sm-8">
					최소 입력 VP - 
					<label for="forum_comment_min_vp" class="control-label">
						<input type="number" id="forum_like_comment_min_vp" value="<?php echo element('cfg_value',element('forum_like_comment_min_vp', $view))?>" name="forum_like_comment_min_vp"/>
					</label>

					최대 입력 VP - <?php echo element('cfg', $view)?>
					<label for="forum_like_comment_max_vp" class="control-label">
						<input type="number" id="forum_like_comment_max_vp" value="<?php echo element('cfg_value',element('forum_like_comment_max_vp', $view))?>" name="forum_like_comment_max_vp"/>
					</label>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">사용 포인트 종류<br/>(추천/비추천등에 사용되는 포인트)</label>
				<div class="col-sm-8">
					<label for="defualt_using_point" class="control-label">
						<input type="checkbox" id="defualt_using_point" value="vp" <?php echo element('cfg_value',element('defualt_using_point',$view)) === 'vp' ? 'checked':''?> name="defualt_using_point"/>
						VP를 기본 포인트로 사용합니다.(변경을 원할시 CP의 사용포인트 체크박스를 선택해주세요/현재 작동하지 않습니다. 체크박스를 수정하지 말아주세요.)
					</label>
				</div>
			</div>
			
			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="submit" class="btn btn-success btn-sm">저장하기</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
$(function() {
	$('#fadminwrite').validate({
		rules: {
			point_register: {required :true, number:true},
			point_login: {required :true, number:true},
			point_recommended: {required :true, number:true},
			point_recommender: {required :true, number:true}
		}
	});
});

var form_original_data = $('#fadminwrite').serialize();
function check_form_changed() {
	if ($('#fadminwrite').serialize() !== form_original_data) {
		if (confirm('저장하지 않은 정보가 있습니다. 저장하지 않은 상태로 이동하시겠습니까?')) {
			return true;
		} else {
			return false;
		}
	}
	return true;
}
$("#VPconfig").parent('li').addClass('active');
//]]>
</script>
