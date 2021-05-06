
  
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
			<input type="hidden" name="is_submit" value="1"/>
			<div class="form-group">
				<label class="col-sm-2 control-label"> 마켓 </label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="market" value="<?php echo set_value('market', element('market', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">한국어 이름</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="name_ko" value="<?php echo set_value('name_ko', element('name_ko', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">영어 이름</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="name_en" value="<?php echo set_value('name_en', element('name_en', element('data', $view))); ?>" />
				</div>
			</div>
            <div class="btn-group pull-right" role="group" aria-label="...">
				<button type="submit" class="btn btn-success btn-sm">저장하기</button>
			</div>
		<?php echo form_close(); ?>
            
</div><br>


    
<div class ='box'>
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

