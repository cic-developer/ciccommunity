<div class="box">
	<div class="box-header">
        <div class="btn-group pull-right" role="group" aria-label="...">
            <button type="button" class="btn btn-outline btn-success btn-sm" id="export_to_excel"><i class="fa fa-file-excel-o"></i> 엑셀 다운로드</button>
            <a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
        </div>
		<ul class="nav nav-tabs">
			<li role="presentation"><a href="<?php echo admin_url($this->pagedir); ?>">일반기능</a></li>
			<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/list'); ?>">출석체크 리스트</a></li>
			<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/points'); ?>">시간/포인트설정</a></li>
			<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/cleanlog'); ?>">오래된 로그삭제</a></li>
		</ul>
	</div>
    
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		?>
        <div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
        <div class="table-responsive">
			<table class="table table-hover table-striped table-bordered">
            <thead>
				<tr>
                    <th>번호</th>
                    <th>닉네임</th>
                    <th>지급 명예 포인트</th>
                    <th>지급 VP</th>
                    <th>지급 CP</th>
                    <th>순위</th>
                    <th>등록일</th>
                </tr>
            </thead>
                <tbody>
					<?php foreach(element('list', element('data', $view)) AS $row) { ?>
						<tr>
							<td><?php echo element('num', $row)?></td>
							<td><?php echo element('mem_nickname', $row)?></td>
							<td><?php echo element('att_point', $row)?></td>
							<td><?php echo element('att_vp', $row)?></td>
							<td><?php echo element('att_cp', $row)?></td>
							<td><?php echo element('att_ranking', $row)?></td>
							<td><?php echo element('att_datetime', $row)?></td>
						</tr>
					<?php } ?>
					<?php if ( ! element('list', element('data', $view))) {?>
						<tr>
							<td colspan="17" class="nopost">자료가 없습니다</td>
						</tr>
					<?php } ?>
                </tbody>
            </table>
		</div>
		<div class="box-info">
		</div>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
$(function() {
	$('#fadminwrite').validate({
		rules: {
			day: {required:true, number:true, min:0}
		}
	});
});
//]]>
</script>
