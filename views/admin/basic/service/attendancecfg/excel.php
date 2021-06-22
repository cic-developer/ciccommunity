<meta http-equiv="Content-Type" content="text/html; charset=<?php echo config_item('charset');?>" />
<style type="text/css">
th {font-weight:bold;padding:5px; min-width:120px; width:120px; _width:120px; text-align:center; line-height:18px; font-size:12px; color:#959595; font-family:dotum,돋움; border-right:1px solid #e4e4e4;}
td {text-align:center; line-height:40px; font-size:12px; color:#474747; font-family:gulim,굴림; border-right:1px solid #e4e4e4;}
</style>
<table width="100%" border="1" bordercolor="#E4E4E4" cellspacing="0" cellpadding="0">
		<tr>
            <th>번호</th>
            <th>닉네임</th>
            <th>지급 명예 포인트</th>
            <th>지급 VP</th>
            <th>지급 CP</th>
            <th>순위</th>
            <th>등록일</th>
		</tr>
	<?php
	if (element('list', element('data', $view))) {
		foreach (element('list', element('data', $view)) as $result) {
	?>
			<tr>
                <td><?php echo element('num', $result)?></td>
                <td><?php echo element('mem_nickname', $result)?></td>
                <td><?php echo element('att_point', $result)?></td>
                <td><?php echo element('att_vp', $result)?></td>
                <td><?php echo element('att_cp', $result)?></td>
                <td><?php echo element('att_ranking', $result)?></td>
                <td><?php echo element('att_datetime', $result)?></td>
			</tr>
		<?php
			}
		}
		?>
</table>
