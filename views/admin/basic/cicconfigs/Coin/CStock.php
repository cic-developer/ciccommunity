
  
<!-- <td><?php $realtime_coin_info; ?></td> -->
<!-- <td> $realtime_coin_info['high_price']; ?> -->
<!--  ------------------------------------PART 2------------------------------------------ -->      

<div class="box">
    <div class="box-header">
		<ul class="nav nav-tabs">
			<li role="presentation" class="active">Create Coin stock</li>
		</ul>
	</div>
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open(current_full_url(), $attributes);
		?>



			<div class="form-group">
			
					<div class="col-sm-8">
						활성화 -
						<label for="cpc_enable" class="control-label">	
						<select name="cpc_enable[]" id="doc_layout" class="form-control">
							<?php		
								foreach($realtime_coin_info as $stocks){	
									echo "hi";
									echo '<option value="'.$stocks['market'].'" >' .$stocks['market']. '</option>';
								}
							?>	
						</select>
							
						</label>
				
					</div>
			</div>


    <?php echo form_close(); ?> 
    </div>
</div>    



<script type="text/javascript">
//<![CDATA[
function myFunction() {
    document.getElementById("myText").defaultValue = "Goofy";
}


$(function() {
	$('#fadminwrite').validate({
		rules: {
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
</script>

