<hr />
<ol class="breadcrumb bc-3">
    <li class = "active">
        <a href="#">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="<?php echo site_url('panel-admin/categories'); ?>"><?php echo get_phrase('categories'); ?></a> </li>
    <li><a href="#" class="active"><?php echo get_phrase('update_category'); ?></a> </li>
</ol>
<h2><i class="fa fa-arrow-circle-o-right"></i> <?php echo get_phrase('update_category'); ?></h2>
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
                <form action="<?php echo site_url('panel-admin/categories/update').'/'.$page_data->id; ?>" method="post" role="form" class="padding10">
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold"><?php echo get_phrase('title'); ?> <span class="red">*</span></label>
                            <input type="text" name="PostsCategory[title]" class="form-control" id="title" value="<?php echo $page_data->title;?>" required>
                        </div>

                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold"><?php echo get_phrase('slug'); ?> <span class="red">*</span></label>
                            <input type="text" name="PostsCategory[slug]" class="form-control" id="slug" value="<?php echo $page_data->slug;?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                            <label class="text-bold"><?php echo get_phrase('description'); ?></label>
                            <textarea name="PostsCategory[description]" class="form-control"><?php echo $page_data->description;?></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                            <button class="btn btn-success" type="submit" name="button"><?php echo get_phrase('Save'); ?></button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

</script>