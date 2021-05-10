<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<div class="box">
	<?php
	echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
	$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
	echo form_open(current_full_url(), $attributes);
	?>
	<div class="box-table-header">
		
	</div>



<!-- Search form (start) -->
	<div class ='box-table'>
		<form method='post' action="<?= base_url() ?>/application/controllers/admin/cicconfigs/Coin/loadRecord" >
			<div class='box-search'>
				<div class='col-md-6 col-md-offset-3'>
					<div class='input-group'>
						<input type='text' class='form-control' name='search' value='<?= $search ?>'>
						<span class = "input-group-btn">
							<button type='submit' class="btn btn-default btn-sm" name='submit' value='검색'>검색!</button>
						</span>
					</div>
				</div>
			</div>		
		</form><br/> 
		
	</div>
	<!-- Posts List -->
	<div class ='box-table'>
	<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
		
		<div class="table-responsive">
			<table class="table table-hover table-striped table-bordered">
				<tr>
					<th>S.no</th>
					<th>마겟 명</th>
					<th>한국어 명</th>
				</tr>
				<?php 
				$sno = $row+1;
				foreach($getStock as $stocks){
					echo "<tr>";
					echo "<td>".$sno."</td>";
					echo "<td><a href='".$stoks->market."' target='_blank'> ".$stocks->market."</a></td>";
					echo "<td><a href='".$stoks->name_ko."' target='_blank'> ".$stocks->name_ko."</a></td>";
					//echo "<td><button type="button" class="btn btn-info">Info</button></td>";
					echo "</tr>";
					$sno++;
				}
				
				if(count($stocks) == 0){
					echo "<tr>";
					echo "<td colspan='3'>No record found.</td>";
					echo "</tr>";
				}
				?>
			</table>
		</div>	
	</div>

	<!-- Paginate -->
	<div style='margin-top: 10px;'>
	<?= $pagination; ?>
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

$("#CStock").parent('li').addClass('active');
</script>


