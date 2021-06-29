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
                    <a href="javascript:void(0);" id="modal_open" class="btn btn-outline btn-default btn-sm" data-toggle="modal">보상지급</a>
                </div>
			</div>
			<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th>번호</th>
							<th><?php echo '추천받은 '?>회원아이디</th>
							<th><?php echo '추천받은 '?>닉네임</th>
							<?php if($_type){ ?>
							<th>레퍼럴 인원 수</th>
							<?php }else{ ?>
							<th>추천한 회원아이디</th>
							<th>추천한 닉네임</th>
							<th>등록일</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
					?>
						<tr>
							<td><?php echo number_format(element('num', $result)); ?></td>
							<td><?php echo element('mem_rec_userid', $result);?></td>
							<td><?php echo element('rec_nickname', $result); ?></td>
							<?php if($_type){ ?>
								<td><?php echo element('is_count', $result) ?></td>
							<?php }else{ ?>
								<td><?php echo element('mem_userid', $result); ?></td>
								<td><?php echo element('usr_nickname', $result);?></td>
								<td><?php echo element('mem_reg_date', $result); ?></td>
							<?php } ?>
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

<div class="modal fade" id="myModal-result">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">보상 지급 <button type="button" class="close" data-dismiss="modal">&times;</button></h4>
            </div>
            <!-- Modal body -->
            <?php echo form_open(current_full_url()); ?>
            <div class="modal-body">
                <!-- <label for="usr"></label> -->
				<input type="hidden" name="required_value" value="<?php echo $_type ? 'rec':'reg'?>">
                <div class="form-group">
                    <label for="reward_vp">보상 VP</label>
                    <input class="form-control" id="reward_vp" name="reward_vp" placeholder="보상을 지급할 vp를 입력해주세요" style="width:100%;"></input>
                </div>
                <div class="form-group">
                    <label for="reward_cp">보상 CP</label>
                    <input class="form-control" id="reward_cp" name="reward_cp" placeholder="보상을 지급할 cp를 입력해주세요" style="width:100%;"></input>
                </div>
            </div>
                
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-retire">지급하기</button>
            </div>
            <?php echo form_close()?>
        </div>
    </div>
</div>

<script>
    $('#modal_open').on('click', function(){
        $('#myModal-result').modal({backdrop: false, keyboard: false});
    })
</script>