<ol class="breadcrumb bc-3">
    <li>
        <a href="<?php echo site_url('panel-admin/dashboard'); ?>">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="#" class="active"><?php echo get_phrase('editor'); ?></a> </li>
</ol>

<h2><?php echo $page_title; ?></h2>
<br />
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><?php echo get_phrase('pages'); ?></a>
                </h4>
            </div>
            <div class="panel-body">
                <textarea name="Editor[file_name]" class="form-control"></textarea>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <h3>Files</h3>
    </div>
</div>