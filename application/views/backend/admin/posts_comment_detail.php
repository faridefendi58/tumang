<ol class="breadcrumb bc-3">
    <li>
        <a href="<?php echo site_url('panel-admin/dashboard'); ?>">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="#" class="active"><?php echo get_phrase('comment_detail'); ?></a> </li>
</ol>
<h2><?php echo $page_title; ?></h2>
<br />

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-body">
                <table class="table table-bordered mt20">
                    <tbody>
                    <tr>
                        <td class="text-bold"><?php echo get_phrase('name'); ?></td>
                        <td><?php echo $page_data->author_name; ?></td>
                    </tr>
                    <tr>
                        <td class="text-bold"><?php echo get_phrase('email'); ?></td>
                        <td><?php echo $page_data->author_email; ?></td>
                    </tr>
                    <tr>
                        <td class="text-bold"><?php echo get_phrase('website'); ?></td>
                        <td><?php echo $page_data->author_website; ?></td>
                    </tr>
                    <tr>
                        <td class="text-bold"><?php echo get_phrase('article'); ?></td>
                        <td>
                            <?php
                            $post_model = $this->post_model->findByPk($page_data->post_id);
                            if (is_object($post_model)) {
                                echo '<a href="'. site_url('panel-admin/posts/update/'. $post_model->id) .'" target="_blank" class="text-info">'. $post_model->meta_title .'</a>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold"><?php echo get_phrase('comment'); ?></td>
                        <td><?php echo $page_data->content; ?></td>
                    </tr>
                    <tr>
                        <td class="text-bold"><?php echo get_phrase('status'); ?></td>
                        <td><?php echo $page_data->status; ?></td>
                    </tr>
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-md-12">
                        <?php if ($page_data->status == 'pending'): ?>
                            <a href="javascript:void(0);" attr-href="<?php echo site_url('panel-admin/posts/comment/approve'); ?>" class="btn btn-info ajax-link" attr-id="<?php echo $page_data->id;?>"><?php echo get_phrase('approve'); ?></a>
                            <a href="javascript:void(0);" attr-href="<?php echo site_url('panel-admin/posts/comment/reject'); ?>" class="btn btn-warning ajax-link" attr-id="<?php echo $page_data->id;?>"><?php echo get_phrase('reject'); ?></a>
                            <a href="javascript:void(0);" attr-href="<?php echo site_url('panel-admin/posts/comment/delete'); ?>" class="btn btn-danger ajax-link" attr-id="<?php echo $page_data->id;?>"><?php echo get_phrase('delete'); ?></a>
                        <?php elseif ($page_data->status == 'approved'):?>
                            <a href="javascript:void(0);" attr-href="<?php echo site_url('panel-admin/posts/comment/delete'); ?>" class="btn btn-danger ajax-link" attr-id="<?php echo $page_data->id;?>"><?php echo get_phrase('delete'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('.ajax-link').click(function () {
            if (confirm('Are you sure?')) {
                var $this =  $(this);
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
        });
    });
</script>