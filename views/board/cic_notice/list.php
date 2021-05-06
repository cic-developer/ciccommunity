<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<div id="container-wrap">
    <div id="top-vis">
        <div class="txt">
            <h2>Notice</h2>
            <!-- <p>각 코인의 주요뉴스를 보여드립니다</p> -->
        </div>
        <div class="img"><img src="<?php echo base_url('assets/images/top-vis01.jpg') ?>" alt=""></div>
    </div>
    <div id="contents" class="div-cont mb-nopad">
        <!-- page start // -->
        <div class="board-wrap list">
            <div class="list notice">
                <table>
                    <colgroup>
                        <col width="100">
                        <col width="*">
                        <col width="100">
                        <col width="100">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>번호</th>
                            <th>제목</th>
                            <th>등록일</th>
                            <th>조회</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (element('notice_list', element('list', $view))) {
                        foreach (element('notice_list', element('list', $view)) as $result) {
                    ?>
                        <tr class="notice">
                            <td><span>공지</span></td>
                            <td class="l" style="padding-left: 48px;"><a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('title', $result)); ?>"><?php echo html_escape(element('title', $result)); ?></a></td>
                            <td><?php echo element('display_datetime', $result); ?></td>
                            <td><?php echo number_format(element('post_hit', $result)); ?></td>
                        </tr>
                        <?php
                            }
                        }
                        if (element('list', element('data', element('list', $view)))) {
                            foreach (element('list', element('data', element('list', $view))) as $result) {
                        ?>
                        <tr>
                            <td><span><?php echo element('num', $result); ?></span></td>
                            <td class="l"><a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('title', $result)); ?>"><?php echo html_escape(element('title', $result)); ?></a></td>
                            <td><?php echo element('display_datetime', $result); ?></td>
                            <td><?php echo number_format(element('post_hit', $result)); ?></td>
                        </tr>
                        <?php
                            }
                        }
                        if ( ! element('notice_list', element('list', $view)) && ! element('list', element('data', element('list', $view)))) {
                        ?>
                            <tr>
                                <td colspan="4" class="nopost">게시물이 없습니다</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
		    <?php if (element('write_url', element('list', $view))) { ?>
            <div class="lower r">
                <a href="<?php echo element('write_url', element('list', $view)); ?>" class="by-btn">글쓰기</a>
            </div>
            <?php } ?>
            <!-- s: paging-wrap -->
            <div class="paging-wrap">
                <?php echo element('paging', element('list', $view)); ?>
            </div>
            <!-- e: paging-wrap -->
            <!-- s: board-filter -->
            <div class="board-filter">
                <form id="searchForm" class="navbar-form navbar-right pull-right" action="<?php echo board_url(element('brd_key', element('board', element('list', $view)))); ?>" onSubmit="return postSearch(this);">
					<input type="hidden" name="findex" value="<?php echo html_escape($this->input->get('findex')); ?>" />
                    <!-- <p class="chk-select">
                        <select name="sfield">
                            <option value="post_title" <?php echo ($this->input->get('sfield') === 'post_title') ? ' selected="selected" ' : ''; ?>>제목</option>
                            <option value="post_content" <?php echo ($this->input->get('sfield') === 'post_content') ? ' selected="selected" ' : ''; ?>>내용</option>
                        </select>
                    </p> -->
                    <p class="chk-input">
                        <input type="text" name="skeyword" placeholder="검색어를 입력해주세요" value="<?php echo html_escape($this->input->get('skeyword')); ?>" autocomplete="off">
                        <a href="javascript:document.querySelector('#searchForm').submit();" class="search-btn"><span>검색</span></a>
                    </p>
                
				</form>
                <script type="text/javascript">
                //<![CDATA[
                function postSearch(f) {
                    var skeyword = f.skeyword.value.replace(/(^\s*)|(\s*$)/g,'');
                    if (skeyword.length < 2) {
                        alert('2글자 이상으로 검색해 주세요');
                        f.skeyword.focus();
                        return false;
                    }
                    return true;
                }
                function toggleSearchbox() {
                    $('.searchbox').show();
                    $('.searchbuttonbox').hide();
                }
                <?php
                if ($this->input->get('skeyword')) {
                    echo 'toggleSearchbox();';
                }
                ?>
                $('.btn-point-info').popover({
                    template: '<div class="popover" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
                    html : true
                });
                //]]>
                </script>
            </div>
            <!-- e: board-filter -->
        </div>
        <!-- page end // -->
    </div>
</div>