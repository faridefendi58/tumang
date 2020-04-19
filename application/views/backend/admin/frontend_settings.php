<ol class="breadcrumb bc-3">
    <li>
        <a href="<?php echo site_url('panel-admin/dashboard'); ?>">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="#" class="active"><?php echo get_phrase('frontend_settings'); ?></a> </li>
</ol>

<h2><?php echo $page_title; ?></h2>
<br />
<div class="row">
    <div class="col-md-12">
        <div class="col-md-7">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        <?php echo get_phrase('theme_settings');?>
                    </div>
                </div>
                <div class="panel-body">
                    <form class="" action="<?php echo site_url('panel-admin/frontend_settings/theme_update'); ?>" method="post">
                        <div class="row">
                            <?php $current_theme = get_settings('theme'); ?>
                            <?php foreach ($themes as $theme): ?>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label><img src="<?php echo site_url($theme['img_path']); ?>" class="img-responsive"/></label>
                                    <label class="radio-inline">
                                        <input type="radio" name="Themes[name]" id="inline_optionsRadios1" value="<?php echo $theme['id']; ?>" <?php if ($theme['id'] == $current_theme):?>checked="checked"<?php endif;?>>
                                        <?php echo $theme['name']; ?>
                                    </label>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <button class = "btn btn-success" type="submit" name="button"><?php echo get_phrase('update_theme'); ?></button>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class = "col-md-5" style="text-align: center;">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        <?php echo get_phrase('update_banner');?>
                    </div>
                </div>
                <div class="panel-body">
                    <form action="<?php echo site_url('panel-admin/frontend_settings/banner_image_update'); ?>" class="no-margin" enctype="multipart/form-data" method="post">

                        <div class="form-group">
                            <label class="form-label"><?php echo get_phrase('banner_image');?></label>

                            <div class="controls">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
                                        <img src="<?php echo base_url('uploads/frontend/home-banner.jpg');?>" alt="...">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new"><?php echo get_phrase('select_image'); ?></span>
                                            <span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
                                            <input type="file" name="banner_image" accept="image/*">
                                        </span>
                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class = "btn btn-success" type="submit" name="submit"><?php echo get_phrase('update_banner_image'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class = "col-md-5" style="text-align: center;">
            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <?php echo get_phrase('update_frontend_logo');?>
                    </div>
                </div>
                <form action="<?php echo site_url('panel-admin/frontend_settings/logo_upload'); ?>" method="post" class="no-margin" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="form-label"><?php echo get_phrase('system_logo');?></label>

                        <div class="controls">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
                                    <?php $logo = get_theme_configs('logo'); ?>
                                    <img src="<?php echo base_url($logo);?>" alt="...">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileinput-new"><?php echo get_phrase('select_image'); ?></span>
                                        <span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
                                        <input type="file" name="logo" accept="image/*">
                                    </span>
                                    <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class = "btn btn-success" type="submit" name="submit"><?php echo get_phrase('update_logo'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
