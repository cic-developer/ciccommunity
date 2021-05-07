
  
<!-- <td><?php $realtime_coin_info; ?></td> -->
<!-- <td> $realtime_coin_info['high_price']; ?> -->
<!--  ------------------------------------PART 2------------------------------------------ -->      


<div class="box">
	<div class="box-header">
		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/CStock'); ?>" onclick="return check_form_changed();">코인 검색 설정</a></li>
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
							활성화 -
							<label for="cpc_enable" class="control-label">
								<select name="selected_market" id="doc_layout" class="form-control">
								<?php
								foreach($getStock as $stoks){
									echo '<option value="'.$stoks->name_ko.'">'.$stoks->market. ': '.$stoks->name_ko.' </option>';							
								
								}?>	
								</select>
							</label>
				
						</div>
						<div class="btn-group pull-right" role="group" aria-label="...">
							<button type="submit" name="submit" class="btn btn-success btn-sm">저장하기</button>
						</div>	
				</div>

			</form>	

            <div class ='box-table'>
				<div class="box-header">
						<ul class="nav nav-tabs">
							<li role="presentation" class="active">update Coin stock</li>
						</ul>
				</div>
				<div class='box-table'>
					<form>
							<div class="form-group col-md-2">
								<label for="inputCity">Market name</label>
								<input type="text" class="form-control" id="myText" value = '<?php echo $realtime_coin_info['market']; ?>'>
							</div>

							<div class="form-group col-md-2">
								<label for="inputCity"> name in Korean</label>
								<input type="text" class="form-control" id="myText" value = '<?php echo $realtime_coin_info['market']; ?>'>
							</div>

							<div class="form-group col-md-2">
								<label for="inputState">high-price</label>
								<input type="text" class="form-control" id="myText" value = '<?php echo $realtime_coin_info['high_price']; ?>'>
							</div>
							<div class="form-group col-md-2">
								<label for="inputZip">low-price</label>
								<input type="text" class="form-control" id="myText" value = '<?php echo $realtime_coin_info['low_price']; ?>'>
							</div>
							<div class="form-group col-md-2">
								<label for="inputZip">trade-price</label>
								<input type="text" class="form-control" id="myText" value = '<?php echo $realtime_coin_info['trade_price']; ?>'>
							</div>
							<div class="btn-group pull-right" role="group" aria-label="...">
								<button type="submit" class="btn btn-success btn-sm">update</button>        
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


