<div class="box">
	<div class="box-table">
        <?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>

            <div class="box-table-header">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="?" class="btn btn-sm <?php echo ( ! $this->input->get('cwl_result') && $this->input->get('cwl_result') != '0') ? 'btn-success' : 'btn-default'; ?>">전체목록</a>
					<a href="?cwl_result=1" class="btn btn-sm <?php echo ($this->input->get('cwl_result') == '1') ? 'btn-success' : 'btn-default'; ?>">승인</a>
					<a href="?cwl_result=0" class="btn btn-sm <?php echo ($this->input->get('cwl_result') == '0') ? 'btn-success' : 'btn-default'; ?>">반려</a>
				</div>

				<?php
				ob_start();
				?>
					<div class="btn-group pull-right" role="group" aria-label="...">
						<button type="button" class="btn btn-outline btn-success btn-sm" id="export_to_excel"><i class="fa fa-file-excel-o"></i> 엑셀 다운로드</button>
					</div>
				<?php
				$buttons = ob_get_contents();
				ob_end_flush();
				?>
			</div>
            <div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><a href="<?php echo element('cwl_idx', element('sort', $view)); ?>">번호</a></th>
                            <th><a href="<?php echo element('cwl_res_admin_id', element('sort', $view)); ?>">관리자아이디</a></th>
                            <th><a href="<?php echo element('cwl_req_user_id', element('sort', $view)); ?>">유저아이디</a></th>
                            <th><a href="<?php echo element('cwl_res_admin_ip', element('sort', $view)); ?>">관리자아이피</a></th>
                            <th><a href="<?php echo element('cwl_req_user_ip', element('sort', $view)); ?>">유저아이피</a></th>
                            <th><a href="<?php echo element('cwl_cp_point', element('sort', $view)); ?>">출금요청금액</a></th>
                            <th><a href="<?php echo element('cwl_wallet_address', element('sort', $view)); ?>">지갑주소</a></th>
                            <th>처리사유</th>
                            <th><a href="<?php echo element('cwl_datetime', element('sort', $view)); ?>">처리날짜</a></th>
                            <th><a href="<?php echo element('cwl_result', element('sort', $view)); ?>">처리결과</a></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (element('list', element('data', $view))) {
                        foreach (element('list', element('data', $view)) as $result) {
                    ?>
                        <tr>
                            <td><?php echo number_format(element('cwl_idx', $result)); ?></td>
                            <td><?php echo html_escape(element('cwl_res_admin_id', $result)); ?></td>
                            <td><?php echo html_escape(element('cwl_req_user_id', $result)); ?></td>
                            <td><?php echo html_escape(element('cwl_res_admin_ip', $result)); ?></td>
                            <td><?php echo html_escape(element('cwl_req_user_ip', $result), 2); ?></td>
                            <td><?php echo number_format(element('cwl_cp_point', $result)); ?></td>
                            <td><?php echo html_escape(element('cwl_wallet_address', $result)); ?></td>
                            <td><?php echo html_escape(element('cwl_content', $result)); ?></td>
                            <td><?php echo html_escape(element('cwl_datetime', $result)); ?></td>
                            <td><?php echo html_escape(element('cwl_result', $result)) == 1 ? '<p class="text-success">승인</p>' : '<p class="text-danger">반려</p>'; ?></td>
                        </tr>
                    <?php
                        }
                    }
                    if ( ! element('list', element('data', $view))) {
                    ?>
                        <tr>
							<td colspan="17" class="nopost">자료가 없습니다</td>
						</tr>
					<?php
					}
					?>
                    </tbody>
                </table>
            </div>
            <div class="box-info">
				<?php echo element('paging', $view); ?>
				<div class="pull-left ml20"><?php echo admin_listnum_selectbox();?></div>
				<?php echo $buttons; ?>
			</div>
        <?php echo form_close(); ?>
    </div>
    <form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
		<div class="box-search">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<select class="form-control" name="sfield" >
						<?php echo element('search_option', $view); ?>
					</select>
					<div class="input-group">
						<input type="text" class="form-control" name="skeyword" value="<?php echo html_escape(element('skeyword', $view)); ?>" placeholder="Search for..." />
						<span class="input-group-btn">
							<button class="btn btn-default btn-sm" name="search_submit" type="submit">검색!</button>
						</span>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

    
<script>
    // excel
    $(document).on('click', '#export_to_excel', function(){
        exporturl = '<?php echo admin_url($this->pagedir . '/excel' . '?' . $this->input->server('QUERY_STRING', null, '')); ?>';
        document.location.href = exporturl;
    })
</script>
