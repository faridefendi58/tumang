<hr />
<ol class="breadcrumb bc-3">
    <li class = "active">
        <a href="#">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="<?php echo site_url('panel-admin/pages'); ?>"><?php echo get_phrase('pages'); ?></a> </li>
    <li><a href="#" class="active"><?php echo $page_data->meta_title; ?></a> </li>
</ol>
<h2><i class="fa fa-arrow-circle-o-right"></i> Update <?php echo $page_data->meta_title; ?></h2>
<br />

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo get_phrase('update_page'); ?> - <?php echo $page_data->meta_title; ?>
                </div>
                <div class="col-md-3 pull-right mt10">
                    <a href = "<?php echo site_url($page_data->slug); ?>" class="btn btn-block btn-info" type="button" target="_blank"><?php echo get_phrase('preview'); ?>  <i class="entypo-forward" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <form action="<?php echo site_url('panel-admin/pages/update/'. $page_data->id); ?>" method="post" role="form" class="padding10">
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold"><?php echo get_phrase('title'); ?> <span class="red">*</span></label>
                            <input type="text" name="Pages[meta_title]" class="form-control" id="page-title" value="<?php echo $page_data->meta_title; ?>" required>
                            <p class="text-muted mt10">Judul halaman yang tampil di tab browser dan halaman pencarian Google</p>
                        </div>

                        <div class="form-group col-sm-6 col-md-6 col-lg-6 has-info">
                            <label class="text-bold"><?php echo get_phrase('permalink'); ?> <span class="red">*</span></label>
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button class="btn btn-info" type="button"><?php echo site_url('/'); ?></button>
                                </div>
                                <input type="text" name="Pages[slug]" class="form-control" id="permalink" value="<?php echo $page_data->slug; ?>" required>
                            </div>
                            <p class="text-muted mt10">Gunakan tanda '-' untuk memisahkan kata.<br/>Contoh format url yang tepat : <u><?php echo site_url('/belajar-seo-dasar'); ?></u></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                            <label class="text-bold"><?php echo get_phrase('content'); ?> <span class="red">*</span></label>
                            <textarea rows="5" class="form-control tinymce"
                                      name="Pages[content]"
                                      id="content"><?php echo $page_data->content; ?></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6">
                            <label class="text-bold"><?php echo get_phrase('meta_keywords'); ?></label>
                            <input type="text" name="Pages[meta_keywords]" class="form-control" value="<?php echo $page_data->meta_keywords; ?>">
                            <p class="text-muted mt10"><?php echo get_phrase('separate_with_coma. ex : keyword1, keyword2'); ?></p>
                        </div>

                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold"><?php echo get_phrase('meta_description'); ?> <span class="red">*</span></label>
                            <textarea name="Pages[meta_description]" class="form-control" required><?php echo $page_data->meta_description; ?></textarea>
                        </div>

                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold">Status</label><br/>
                            <?php $statuses = ['draft', 'published', 'archived']; ?>
                            <?php foreach ($statuses as $i => $status): ?>
                                <label class="radio-inline">
                                    <input type="radio" name="Pages[status]" value="<?php echo $status;?>" id="optionsRadios-<?php echo $i; ?>" <?php if ($status == $page_data->status): ?>checked="checked"<?php endif; ?>>
                                    <?php echo ucfirst($status); ?>
                                </label>
                            <?php endforeach; ?>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                            <button class="btn btn-success" type="submit" name="button"><?php echo get_phrase('Update'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#page-title').keyup(function () {
            var permalink = $(this).val().toLowerCase();
            if (permalink && permalink.length > 0) {
                var permalink = permalink.replace(/\s+/g, "-");
            }
            $('#permalink').val(permalink);
        });
    });
</script>