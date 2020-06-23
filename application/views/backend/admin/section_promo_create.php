<hr />
<ol class="breadcrumb bc-3">
    <li class = "active">
        <a href="#">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="<?php echo site_url('panel-admin/section-promo'); ?>"><?php echo get_phrase('section_promo'); ?></a> </li>
    <li><a href="#" class="active"><?php echo get_phrase('create_promo'); ?></a> </li>
</ol>
<h2><i class="fa fa-arrow-circle-o-right"></i> <?php echo get_phrase('create_promo'); ?></h2>
<br />

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    Kolom bertanda <span class="red">*</span> tidak boleh dikosongi.
                </div>
            </div>
            <div class="panel-body">
                <form action="<?php echo site_url('panel-admin/section-promo/create'); ?>" method="post" role="form" class="padding10" enctype="multipart/form-data">
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold"><?php echo get_phrase('name'); ?> <span class="red">*</span></label>
                            <input type="text" name="Promo[promo_name]" class="form-control" id="title" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold"><?php echo get_phrase('url'); ?></label>
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button class="btn btn-info" type="button"><?php echo site_url('/'); ?></button>
                                </div>
                                <input type="text" name="Promo[url]" class="form-control" id="slug">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="form-label"><?php echo get_phrase('image');?></label>

                            <div class="controls">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
                                        <img src="<?php echo base_url('thumbnails/thumbnail.png');?>" alt="...">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                    <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileinput-new"><?php echo get_phrase('select_image'); ?></span>
                                        <span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
                                        <input type="file" name="image" accept="image/*">
                                    </span>
                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                            <button class="btn btn-success" type="submit" name="button"><?php echo get_phrase('save'); ?></button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>