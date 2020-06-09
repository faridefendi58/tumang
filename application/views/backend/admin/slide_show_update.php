<hr />
<ol class="breadcrumb bc-3">
    <li class = "active">
        <a href="#">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="<?php echo site_url('panel-admin/slide-show'); ?>"><?php echo get_phrase('slide_show'); ?></a> </li>
    <li><a href="#" class="active"><?php echo get_phrase('update_slide_show'); ?></a> </li>
</ol>
<h2><i class="fa fa-arrow-circle-o-right"></i> <?php echo get_phrase('update_slide_show'); ?></h2>
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
                <form action="<?php echo site_url('panel-admin/slide-show/update').'/'.$data->id; ?>" method="post" role="form" class="padding10" enctype="multipart/form-data">
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold"><?php echo get_phrase('title'); ?> <span class="red">*</span></label>
                            <input type="text" name="SlideShow[title]" class="form-control" id="title" value="<?php echo $data->title;?>" required>
                        </div>

                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold"><?php echo get_phrase('sub_title'); ?> </label>
                            <?php
                            $configs = json_decode($data->configs, true);
                            if (empty($configs)) {
                                $configs = [];
                            }
                            ?>
                            <input type="text" name="SlideShow[configs][subtitle]" class="form-control" id="sub-title" value="<?php echo (array_key_exists('subtitle', $configs))? $configs['subtitle'] : '';?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold"><?php echo get_phrase('button_label'); ?> </label>
                            <input type="text" name="SlideShow[configs][button_label]" class="form-control" id="button-label" value="<?php echo array_key_exists('button_label', $configs)? $configs['button_label'] : '';?>">
                        </div>

                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold"><?php echo get_phrase('url'); ?></label>
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button class="btn btn-info" type="button"><?php echo site_url('/'); ?></button>
                                </div>
                                <input type="text" name="SlideShow[url]" class="form-control" id="slug" value="<?php echo $data->url;?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold"><?php echo get_phrase('category'); ?> <span class="red">*</span></label>
                            <select name="SlideShow[category_id]" class="form-control">
                                <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id'];?>"><?php echo $category['title'];?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold"><?php echo get_phrase('order'); ?> <span class="red">*</span></label>
                            <input type="text" name="SlideShow[order]" class="form-control" id="slug" value="<?php echo $data->order;?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold"><?php echo get_phrase('caption'); ?></label>
                            <textarea name="SlideShow[caption]" class="form-control"><?php echo $data->caption;?></textarea>
                        </div>

                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="form-label"><?php echo get_phrase('image');?></label>

                            <div class="controls">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
                                        <img src="<?php echo base_url($data->image);?>" alt="...">
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
                            <button class="btn btn-success" type="submit" name="button"><?php echo get_phrase('update'); ?></button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

</script>