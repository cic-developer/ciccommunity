<?php $_type = $this->input->get('type') != 'reg' ?>
<div class="box">
	<div class="box-table">
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
			<div class="box-table-header">
				<ul class="nav nav-pills">
					<li role="presentation" class="<?php echo $_type ? 'active' : ''?>"><a href="<?php echo base_url('admin/member/recommend?type=rec')?>">레퍼럴 추천인</a></li>
					<li role="presentation" class="<?php echo !$_type ? 'active' : ''?>"><a href="<?php echo base_url('admin/member/recommend?type=reg') ?>">레퍼럴 추천인 회원가입</a></li>
				</ul>

                <div class="btn-group pull-right" role="group" aria-label="...">
                    <a href="javascript:void(0);" class="btn btn-outline btn-default btn-sm">보상지급</a>
                </div>
			</div>
			<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th>번호</th>
							<th>회원아이디</th>
							<th>닉네임</th>
							<th>보상 VP</th>
							<th>보상 CP</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
					?>
						<tr>
							<td><?php echo number_format(element('num', $result)); ?></td>
							<td><?php echo $_type ? element('mem_userid', $result): element('mem_rec_userid', $result);?></td>
							<td><?php echo $_type ? element('usr_nickname', $result): element('rec_nickname', $result); ?></td>
							<td><?php echo $_type ? element('rmd_rec_vp', $result): element('rmd_vp', $result); ?></td>
							<td><?php echo $_type ? element('rmd_rec_cp', $result): element('rmd_cp', $result); ?></td>
						</tr>
					<?php
						}
					}
					if ( ! element('list', element('data', $view))) {
					?>
						<tr>
							<td colspan="8" class="nopost">자료가 없습니다</td>
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
