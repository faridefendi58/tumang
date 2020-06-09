<ol class="breadcrumb bc-3">
    <li>
        <a href="<?php echo site_url('panel-admin/dashboard'); ?>">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="#" class="active"><?php echo get_phrase('slide_show'); ?></a> </li>
</ol>
<h2><i class="fa fa-arrow-circle-o-right"></i> <?php echo $page_title; ?></h2>
<br />

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-body">
                <div class="row" style="margin-left: -15px;">
                    <div class="col-md-3 pull-right">
                        <a href = "<?php echo site_url('panel-admin/slide-show/create'); ?>" class="btn btn-block btn-info" type="button"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo get_phrase('add_slide_show'); ?></a>
                    </div>
                </div>
                <table class="table table-bordered datatable" id="table-1">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th><?php echo get_phrase('title'); ?></th>
                        <th><?php echo get_phrase('image'); ?></th>
                        <th><?php echo get_phrase('caption'); ?></th>
                        <th><?php echo get_phrase('category'); ?></th>
                        <th><?php echo get_phrase('actions'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $counter = 0;
                    foreach ($items as $item): ?>
                        <tr class= "<?php if( $counter % 2 == 0) echo 'odd gradeX'; else echo 'even gradeC'; $counter++;?>">
                            <td><center><?php echo $counter; ?></center></td>
                            <td>
                                <a href="<?php echo site_url('panel-admin/slide-show/detail/'.$item['id']); ?>"><?php echo $item['title']; ?></a>
                            </td>
                            <td>
                                <img src="<?php echo site_url($item['image']); ?>" height="100px"/>
                            </td>
                            <td>
                                <?php echo $item['caption']; ?>
                            </td>
                            <td>
                                <?php echo $item['category_name']; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-small btn-default btn-demo-space" data-toggle="dropdown"> <i class = "fa fa-ellipsis-v"></i> </button>
                                    <ul class="dropdown-menu dropdown-default" role="menu">
                                        <li>
                                            <a href="<?php echo site_url('panel-admin/slide-show/detail/'.$item['id']); ?>">
                                                <?php echo get_phrase('detail');?>
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="<?php echo site_url('panel-admin/slide-show/update/'.$item['id']); ?>">
                                                <?php echo get_phrase('update');?>
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="return removeSlide(this);" attr-href="<?php echo site_url('panel-admin/slide-show/delete/'. $item['id']); ?>" attr-id="<?php echo $item['id'];?>">
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
<script type="text/javascript">
    function removeSlide(dt) {
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
                            window.location.href = "<?php echo site_url('panel-admin/slide-show/view'); ?>";
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