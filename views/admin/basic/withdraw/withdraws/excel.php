<meta http-equiv="Content-Type" content="text/html; charset=<?php echo config_item('charset');?>" />
<style type="text/css">
th {font-weight:bold;padding:5px; min-width:120px; width:120px; _width:120px; text-align:center; line-height:18px; font-size:12px; color:#959595; font-family:dotum,돋움; border-right:1px solid #e4e4e4;}
td {text-align:center; line-height:40px; font-size:12px; color:#474747; font-family:gulim,굴림; border-right:1px solid #e4e4e4;}
</style>
<table width="100%" border="1" bordercolor="#E4E4E4" cellspacing="0" cellpadding="0">
		<tr>
			<th>아이디</th>
			<th>아이피</th>
			<th>닉네임</th>
			<th>지갑주소</th>
			<th>수수료(%)</th>
			<th>신청금액(CP)</th>
			<th>출금금액(CP)</th>
			<th>요청날짜</th>
			<th>결과</th>
			<th>승인</th>
			<th>처리완료시 우측 정보 활성화</th>
			<th>퍼코인</th>
			<th>트랜잭션</th>
			<th>관리자아이디</th>
			<th>관리자아이피</th>
			<th>처리날짜</th>
			<th>처리사유</th>
		</tr>
	<?php
	if (element('list', element('data', $view))) {
		foreach (element('list', element('data', $view)) as $result) {
	?>
			<tr>
				<td height="30"><?php echo html_escape(element('wid_userid', $result)); ?></td>
				<td><?php echo html_escape(element('wid_userip', $result)); ?></td>
				<td>
					<?php echo html_escape(element('wid_nickname', $result)); ?>
				</td>
				<td><?php echo html_escape(element('wid_wallet_address', $result)); ?></td>
				<td><?php echo number_format(element('wid_commission', $result), 2); ?></td>
				<td><?php echo number_format(element('wid_req_money', $result), 2); ?></td>
				<td><?php echo number_format(element('wid_cal_money', $result), 2); ?></td>
				<td><?php echo element('wid_req_datetime', $result); ?></td>
				<td><?php echo html_escape(element('wid_state', $result)) != null ? (element('wid_state', $result) == 1 ? '승인' : '반려' ) : '미처리';?></td>
				<td><?php echo element('wid_state', $result) != null ? '처리안료' : '미처리'; ?></td>
				<td>==> </td>
				<td><?php echo number_format(element('wid_percoin', $result), 2); ?></td>
				<td><?php echo element('wid_transaction', $result); ?></td>
				<td><?php echo element('wid_admin_id', $result); ?></td>
				<td><?php echo element('wid_admin_ip', $result); ?></td>
				<td><?php echo element('wid_res_datetime', $result); ?></td>
				<td><?php echo element('wid_content', $result); ?></td>
			</tr>
		<?php
			}
		}
		?>
</table>
