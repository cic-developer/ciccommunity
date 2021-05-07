<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/contents.css'); ?>
<div id="container-wrap">
    <div id="top-vis">
        <div class="txt">
            <h2>community</h2>
        </div>
        <div class="img"><img src="<?php echo base_url('assets/images/top-vis04.jpg')?>" alt=""></div>
    </div>
    <div id="contents" class="div-cont">
        <!-- page start // -->
        <div class="board-wrap list">
            <div class="real">
                <div class="fl">
                    <h4>베스트 게시물</h4>
                    <ul>
                        <li><a href="<?php echo base_url('post/5')?>">1. [스압] 월급루팡이 만들어지는 과정 (5) <span>18</span></a>
                        </li>
                        <li><a href="<?php echo base_url('post/5')?>">2. [스압] 월급루팡이 만들어지는 과정 (5) <span>18</span></a>
                        </li>
                        <li><a href="<?php echo base_url('post/5')?>">3. [스압] 월급루팡이 만들어지는 과정 (5) <span>18</span></a>
                        </li>
                        <li><a href="<?php echo base_url('post/5')?>">4. [스압] 월급루팡이 만들어지는 과정 (5) <span>18</span></a>
                        </li>
                        <li><a href="<?php echo base_url('post/5')?>">5. [스압] 월급루팡이 만들어지는 과정 (5) <span>18</span></a>
                        </li>
                        <li><a href="<?php echo base_url('post/5')?>">6. [스압] 월급루팡이 만들어지는 과정 (5) <span>18</span></a>
                        </li>
                        <li><a href="<?php echo base_url('post/5')?>">7. [스압] 월급루팡이 만들어지는 과정 (5) <span>18</span></a>
                        </li>
                        <li><a href="<?php echo base_url('post/5')?>">8. [스압] 월급루팡이 만들어지는 과정 (5) <span>18</span></a>
                        </li>
                        <li><a href="<?php echo base_url('post/5')?>">9. [스압] 월급루팡이 만들어지는 과정 (5) <span>18</span></a>
                        </li>
                        <li><a href="<?php echo base_url('post/5')?>">10. [스압] 월급루팡이 만들어지는 과정 (5) <span>18</span></a>
                        </li>
                    </ul>
                </div>
                <div class="fr">
                    <h4>실시간 인기 게시물</h4>
                    <ul>
                    	<?php
						if (element('poplist', element('data', $view))) {
							foreach (element('poplist', element('data', $view)) as $result) {
						?>
							<tr>
								<td>
                                <td class="l file">
                                    <a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('title', $result)); ?>"><?php echo html_escape(element('title', $result)); ?>
                                        <span class="reply">(<?php echo element('post_comment_count', $result); ?>)</span>
                                    </a>
                                </td>
							</tr>
						<?php
							}
						}
						if ( ! element('poplist', element('data', $view))) {
						?>
							<tr>
								<td colspan="12" class="nopost">자료가 없습니다</td>
							</tr>
						<?php
						}
						?>
                        <!-- <li><a href="<?php echo base_url('post/5')?>">1. [스압] 월급루팡이 만들어지는 과정 (5) <span>28</span></a>
                        </li>
                        <li><a href="<?php echo base_url('post/5')?>">2. [스압] 월급루팡이 만들어지는 과정 (5) <span>28</span></a>
                        </li>
                        <li><a href="<?php echo base_url('post/5')?>">3. [스압] 월급루팡이 만들어지는 과정 (5) <span>28</span></a>
                        </li>
                        <li><a href="<?php echo base_url('post/5')?>">4. [스압] 월급루팡이 만들어지는 과정 (5) <span>28</span></a>
                        </li>
                        <li><a href="<?php echo base_url('post/5')?>">5. [스압] 월급루팡이 만들어지는 과정 (5) <span>28</span></a>
                        </li>
                        <li><a href="<?php echo base_url('post/5')?>">6. [스압] 월급루팡이 만들어지는 과정 (5) <span>28</span></a>
                        </li>
                        <li><a href="<?php echo base_url('post/5')?>">7. [스압] 월급루팡이 만들어지는 과정 (5) <span>28</span></a>
                        </li>
                        <li><a href="<?php echo base_url('post/5')?>">8. [스압] 월급루팡이 만들어지는 과정 (5) <span>28</span></a>
                        </li>
                        <li><a href="<?php echo base_url('post/5')?>">9. [스압] 월급루팡이 만들어지는 과정 (5) <span>28</span></a>
                        </li>
                        <li><a href="<?php echo base_url('post/5')?>">10. [스압] 월급루팡이 만들어지는 과정 (5) <span>28</span></a>
                        </li> -->
                    </ul>
                </div>
            </div>
            <div class="gap60"></div>
            <div class="list community">
                <table>
                    <colgroup>
                        <col width="170">
                        <col width="*">
                        <col width="100">
                        <col width="100">
                        <col width="100">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>글쓴이</th>
                            <th>제목</th>
                            <th>등록일</th>
                            <th>조회</th>
                            <th><span class="cyellow">VP</span></th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                    if (element('notice_list', element('list', $view))) {
                        foreach (element('notice_list', element('list', $view)) as $result) {
                    ?>
                        <tr>
                            <td>
                                <div class="my-info">
                                    <p class="pimg"><img src="<?php echo base_url('assets/images/photo-popo.png')?>"
                                            alt=""></p>
                                    <p class="rtxt"><?php echo element('post_nickname', $result); ?></p>
                                </div>
                            </td>
                            <td class="l notice"><a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('title', $result)); ?>"><span
                                        class="cate">공지</span><?php echo html_escape(element('title', $result)); ?></a></td>
                            <td><?php echo element('display_datetime', $result); ?></td>
                            <td><?php echo number_format(element('post_hit', $result)); ?></td>
                            <td>
                                <p class="cyellow">12</p>
                                <!-- <p class="cred">4 진정한 흑우</p> -->
                            </td>
                        </tr>
                    <?php
                        }
                    }
                    if (element('list', element('data', element('list', $view)))) {
                        foreach (element('list', element('data', element('list', $view))) as $result) {
                    ?>
                        <tr>
                            <td>
                                <div class="my-info">
                                    <p class="pimg"><img src="<?php echo thumb_url('mlc_attach', element('mlc_attach', $result), 30, 30); ?>"
                                            alt="<?php echo element('mlc_title', $result); ?>"></p>
                                    <p class="rtxt"><?php echo html_escape(element('post_nickname', $result)); ?></p>
                                </div>
                            </td>
                            <td class="l file">
                                <a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('title', $result)); ?>"><?php echo html_escape(element('title', $result)); ?>
                                    <span class="reply">(<?php echo element('post_comment_count', $result); ?>)</span>
                                </a>
                            </td>
                            <td><?php echo element('display_datetime', $result); ?></td>
                            <td><?php echo number_format(element('post_hit', $result)); ?></td>
                            <td>
                                <p class="cyellow"><?=number_format(element('post_like_point', $result)-element('post_dislike_point', $result))?></p>
                            </td>
                        </tr>
                    <?php
                        }
                    }
                    if ( ! element('notice_list', element('list', $view)) && ! element('list', element('data', element('list', $view)))) {
                    ?>
                        <tr>
                            <td colspan="5" class="nopost">게시물이 없습니다</td>
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
                <p class="chk-select">
                    <select>
                        <option value="">제목</option>
                        <option value="">내용</option>
                    </select>
                </p>
                <p class="chk-input">
                    <input type="text" placeholder="검색어를 입력해주세요" autocomplete="off">
                    <a href="<?php echo base_url('post/5')?>" class="search-btn"><span>검색</span></a>
                </p>
            </div>
            <!-- e: board-filter -->
        </div>
        <!-- page end // -->
    </div>
</div>