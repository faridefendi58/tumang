<hr />
<ol class="breadcrumb bc-3">
    <li class = "active">
        <a href="#">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="<?php echo site_url('panel-admin/posts'); ?>"><?php echo get_phrase('posts'); ?></a> </li>
    <li><a href="#" class="active"><?php echo get_phrase('add_new_post'); ?></a> </li>
</ol>
<h2><i class="fa fa-arrow-circle-o-right"></i> <?php echo get_phrase('add_new_post'); ?></h2>
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
                <form action="<?php echo site_url('panel-admin/posts/create'); ?>" method="post" role="form" class="padding10">
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold"><?php echo get_phrase('title'); ?> <span class="red">*</span></label>
                            <input type="text" name="Posts[meta_title]" class="form-control" id="post-title" required>
                            <p class="text-muted mt10">Judul halaman yang tampil di tab browser dan halaman pencarian Google</p>
                        </div>

                        <div class="form-group col-sm-6 col-md-6 col-lg-6 has-info">
                            <label class="text-bold"><?php echo get_phrase('permalink'); ?> <span class="red">*</span></label>
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button class="btn btn-info" type="button"><?php echo site_url('/blog/'); ?></button>
                                </div>
                                <input type="text" name="Posts[slug]" class="form-control" id="permalink" required>
                            </div>
                            <p class="text-muted mt10">Gunakan tanda '-' untuk memisahkan kata.<br/>Contoh format url yang tepat : <u><?php echo site_url('/blog/belajar-seo-dasar'); ?></u></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                            <label class="text-bold"><?php echo get_phrase('content'); ?> <span class="red">*</span></label>
                            <textarea rows="5" class="form-control tinymce"
                                      name="Posts[content]"
                                      id="content"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6">
                            <label class="text-bold"><?php echo get_phrase('meta_keywords'); ?></label>
                            <input type="text" name="Posts[meta_keywords]" class="form-control">
                            <p class="text-muted mt10"><?php echo get_phrase('separate_with_coma. ex : keyword1, keyword2'); ?></p>
                        </div>

                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold"><?php echo get_phrase('meta_description'); ?> <span class="red">*</span></label>
                            <textarea name="Posts[meta_description]" class="form-control" required></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold">Category</label>
                            <select name="Posts[category][]" class="form-control multiple" multiple="true">
                                <?php foreach (get_post_categories() as $ip => $category): ?>
                                    <option value="<?php echo $category['id']; ?>"><?php echo $category['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold">Tags</label>
                            <input type="text" name="Posts[tags]" class="form-control" placeholder="Please separate with ','. Ex : domain, whois">
                        </div>

                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <div class="checkbox">
                                <label class="text-bold">
                                    <input type="checkbox" name="Posts[allow_comment]" checked="checked">
                                    <b>Allow Comment</b>
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold">Status</label><br/>
                            <?php $statuses = ['draft', 'published', 'archived']; ?>
                            <?php foreach ($statuses as $i => $status): ?>
                                <label class="radio-inline">
                                    <input type="radio" name="Posts[status]" value="<?php echo $status; ?>" id="optionsRadios-<?php echo $i; ?>" <?php if ($i == 0): ?>checked="checked"<?php endif; ?>>
                                    <?php echo ucfirst($status); ?>
                                </label>
                            <?php endforeach; ?>
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
    $(function () {
        $('#post-title').keyup(function () {
            var permalink = $(this).val().toLowerCase();
            if (permalink && permalink.length > 0) {
                var permalink = permalink.replace(/\s+/g, "-");
            }
            $('#permalink').val(permalink);
        });
    });
</script>