<ol class="breadcrumb bc-3">
    <li>
        <a href="<?php echo site_url('panel-admin/dashboard'); ?>">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="#" class="active"><?php echo get_phrase('post_comments'); ?></a> </li>
</ol>
<h2><i class="fa fa-arrow-circle-o-right"></i> <?php echo $page_title; ?></h2>
<br />

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-body">
                <?php
                $pending_comments = $this->postComment_model->findAllByAttributes(['status' => 'pending']);
                $pending_counter = $pending_comments->num_rows();
                $approved_comments = $this->postComment_model->findAllByAttributes(['status' => 'approved']);
                $approved_counter = $approved_comments->num_rows();
                ?>
                <ul class="nav nav-tabs" id="tabs_a">
                    <li class="active"><a data-toggle="tab" href="#pending">Pending <?php if ($pending_counter > 0):?><span class="badge badge-warning"><?php echo $pending_counter;?></span><?php endif; ?></a></li>
                    <li><a data-toggle="tab" href="#approved">Approved</a></li>
                </ul>
                <div class="tab-content" id="tabs_content_a">
                    <div id="pending" class="tab-pane fade in active">
                        <table class="table table-bordered datatable" id="table-1">
                            <thead>
                            <tr>
                                <th><?php echo get_phrase('name'); ?></th>
                                <th><?php echo get_phrase('email'); ?></th>
                                <th><?php echo get_phrase('article'); ?></th>
                                <th><?php echo get_phrase('actions'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $counter = 1;
                            foreach ($pending_comments->result_array() as $pending_comment): ?>
                                <tr class= "<?php if( $counter % 2 == 0) echo 'odd gradeX'; else echo 'even gradeC'; $counter++;?>">
                                    <td>
                                        <?php echo $pending_comment['author_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $pending_comment['author_email']; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo site_url('blog/'. $pending_comment['post_slug']);?>"><?php echo $pending_comment['post_title']; ?></a>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-small btn-default btn-demo-space" data-toggle="dropdown"> <i class = "fa fa-ellipsis-v"></i> </button>
                                            <ul class="dropdown-menu dropdown-default" role="menu">
                                                <li>
                                                    <a href="<?php echo site_url('panel-admin/posts/detail-comment/'.$pending_comment['id']); ?>">
                                                        <?php echo get_phrase('detail');?>
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="javascript:void(0);" onclick="return removeComment(this);" attr-href="<?php echo site_url('panel-admin/posts/comment/delete'); ?>" attr-id="<?php echo $pending_comment['id'];?>">
                                                        <?php echo get_phrase('delete');?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div id="approved" class="tab-pane fade">
                        <table class="table table-bordered datatable" id="table-1">
                            <thead>
                            <tr>
                                <th><?php echo get_phrase('name'); ?></th>
                                <th><?php echo get_phrase('email'); ?></th>
                                <th><?php echo get_phrase('article'); ?></th>
                                <th><?php echo get_phrase('actions'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $counter = 1;
                            foreach ($approved_comments->result_array() as $approved_comment): ?>
                                <tr class= "<?php if( $counter % 2 == 0) echo 'odd gradeX'; else echo 'even gradeC'; $counter++;?>">
                                    <td>
                                        <?php echo $approved_comment['author_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $approved_comment['author_email']; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo site_url('blog/'. $approved_comment['post_slug']);?>"><?php echo $approved_comment['post_title']; ?></a>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-small btn-default btn-demo-space" data-toggle="dropdown"> <i class = "fa fa-ellipsis-v"></i> </button>
                                            <ul class="dropdown-menu dropdown-default" role="menu">
                                                <li>
                                                    <a href="<?php echo site_url('panel-admin/posts/detail-comment/'.$approved_comment['id']); ?>">
                                                        <?php echo get_phrase('detail');?>
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="javascript:void(0);" onclick="return removeComment(this);" attr-href="<?php echo site_url('panel-admin/posts/comment/delete'); ?>" attr-id="<?php echo $approved_comment['id'];?>">
                                                        <?php echo get_phrase('delete');?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function removeComment(dt) {
        if (confirm('Are you sure you want to delete this data?')) {
            var $this =  $(dt);
            var url = $this.attr('attr-href');
            $.ajax({
                'url': url,
                'type':'post',
                'data':{'id':$this.attr('attr-id')},
                'dataType': 'json',
                'success': function(data) {
                    if (data.success) {
                        toastr.success(data.message);
                        setTimeout(function () {
                            window.location.href = "<?php echo site_url('panel-admin/posts/comment'); ?>";
                        }, 3000);
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        }
        return false;
    }
</script>