<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<div class="box">
<!-- Search form (start) -->
	<div class ='box-table'>
		<form method='post' action="<?= base_url() ?>index.php/User/loadRecord" >
			<input type='text' name='search' value='<?= $search ?>'><input type='submit' name='submit' value='Submit'>
		</form><br/> 
	</div>

	<div class ='box-table'>
		<!-- Posts List -->
		<table border='1' width='100%' style='border-collapse: collapse;'>
			<tr>
				<th>S.no</th>
				<th>Market</th>
				<th>Content</th>
			</tr>
			<?php 
			$sno = $row+1;
			foreach($getStock as $stoks){

				//$content = substr($data['content'],0, 180)." ...";
				echo "<tr>";
				echo "<td>".$sno."</td>";
				echo "<td><a href='".$stoks->name_ko."' target='_blank'> ".$stoks->market. " - " .$stoks->name_ko."</a></td>";
				//echo "<td><button type="button" class="btn btn-info">Info</button></td>";
				echo "</tr>";
				$sno++;

			}
			if(count($result) == 0){
				echo "<tr>";
				echo "<td colspan='3'>No record found.</td>";
				echo "</tr>";
			}
			?>
		</table>
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


