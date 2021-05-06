
  
<!-- <td><?php $realtime_coin_info; ?></td> -->
<!-- <td> $realtime_coin_info['high_price']; ?> -->
<!--  ------------------------------------PART 2------------------------------------------ -->      


<div class="box">
	<div class="box-header">
		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/CStock'); ?>" onclick="return check_form_changed();">CP 설정</a></li>
		</ul>
	</div>
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open(current_full_url(), $attributes);
		?>
			<form method ="POST">
				<input type="hidden" name="is_submit" value="1" />
				<div class="form-group">
					<input type="hidden" name="cpc_id[]" value="<?php echo element('cpc_id', $value) ?>"/>
					<label class="col-sm-3 control-label"><?php echo element('cpc_title', $value)."<br/>(".element('cpc_description', $value).")"?></label>
						<div class="col-sm-8">
							활성화 -
							<label for="cpc_enable" class="control-label">
								<select name="selected_market" id="doc_layout" class="form-control">
								<?php
								foreach($getStock as $stoks){
									echo '<option value="'.$stoks->market.'">'.$stoks->market.'</option>';							
								
								}?>	
								</select>
							</label>
					
						</div>
				</div>

				<div class="btn-group pull-right" role="group" aria-label="...">
					<button type="submit" name="submit" class="btn btn-success btn-sm">저장하기</button>
				</div>
			</form>	
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
//]]>

$("#CPconfig").parent('li').addClass('active');
</script>


