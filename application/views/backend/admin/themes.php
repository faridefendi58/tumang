<ol class="breadcrumb bc-3">
    <li>
        <a href="<?php echo site_url('panel-admin/dashboard'); ?>">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="#" class="active"><?php echo get_phrase('themes'); ?></a> </li>
</ol>

<h2><?php echo $page_title; ?></h2>
<br />
<div class="row">
    <div class="col-md-12">
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
</div>
