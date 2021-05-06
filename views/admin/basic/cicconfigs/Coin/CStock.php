
  
<!-- <td><?php $realtime_coin_info; ?></td> -->
<!-- <td> $realtime_coin_info['high_price']; ?> -->
<!--  ------------------------------------PART 2------------------------------------------ -->      

	
						<select name="cpc_enable[]" id="doc_layout" class="form-control">
							<?php		
								foreach($realtime_coin_info as $stocks){	
									echo "hi";
									echo '<option value="'.$stocks['market'].'" >' .$stocks['market']. '</option>';
								}
							?>	
						</select>


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

