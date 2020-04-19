<ol class="breadcrumb bc-3">
    <li>
        <a href="<?php echo site_url('panel-admin/dashboard'); ?>">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="#" class="active"><?php echo get_phrase('pages'); ?></a> </li>
</ol>
<h2><i class="fa fa-arrow-circle-o-right"></i> <?php echo $page_title; ?></h2>
<br />

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-body">
                <div class="row" style="margin-left: -15px;">
                    <div class="col-md-3 pull-right">
                        <a href = "<?php echo site_url('panel-admin/pages/create'); ?>" class="btn btn-block btn-info" type="button"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo get_phrase('add_page'); ?></a>
                    </div>
                </div>
                <table class="table table-bordered datatable" id="table-1">
                    <thead>
                    <tr>
                        <th><?php echo get_phrase('page'); ?></th>
                        <th><?php echo get_phrase('url'); ?></th>
                        <th><?php echo get_phrase('actions'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $counter = 1;
                    foreach ($pages as $page): ?>
                        <tr class= "<?php if( $counter % 2 == 0) echo 'odd gradeX'; else echo 'even gradeC'; $counter++;?>">
                            <td>
                                <a href="<?php echo site_url('panel-admin/pages/update/'.$page['id']); ?>" class="text-info"><?php echo $page['meta_title']; ?></a>
                            </td>
                            <td>
                                <a href="<?php echo site_url($page['slug']); ?>" target="_blank"><?php echo site_url($page['slug']); ?></a>
                            </td>
                            <td>

                                <div class="btn-group">
                                    <button class="btn btn-small btn-default btn-demo-space" data-toggle="dropdown"> <i class = "fa fa-ellipsis-v"></i> </button>
                                    <ul class="dropdown-menu dropdown-default" role="menu">
                                        <li>
                                            <a href="<?php echo site_url('panel-admin/pages/update/'.$page['id']); ?>">
                                                <?php echo get_phrase('edit');?>
                                            </a>
                                        </li>
                                        <?php if ($page['slug'] != 'index'): ?>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="#" onclick="confirm_modal('<?php echo site_url('panel-admin/pages/delete/'.$page['id']); ?>');">
                                                <?php echo get_phrase('delete');?>
                                            </a>
                                        </li>
                                        <?php endif; ?>
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
