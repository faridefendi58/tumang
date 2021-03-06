<hr />
<ol class="breadcrumb bc-3">
    <li class = "active">
        <a href="#">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="<?php echo site_url('panel-admin/menus'); ?>"><?php echo get_phrase('menus'); ?></a> </li>
    <li><a href="#" class="active"><?php echo get_phrase('update_menu'); ?></a> </li>
</ol>
<h2><i class="fa fa-arrow-circle-o-right"></i> <?php echo get_phrase('update_menu'); ?></h2>
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
                <form action="<?php echo site_url('panel-admin/menus/update'); ?>/<?php echo $page_data->id;?>" method="post" role="form" class="padding10">
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold"><?php echo get_phrase('title'); ?> <span class="red">*</span></label>
                            <input type="text" name="Menus[title]" class="form-control" value="<?php echo $page_data->title;?>" required>
                        </div>

                        <div class="form-group col-sm-6 col-md-6">
                            <label class="text-bold">Sub Menu Dari</label>
                            <select name="Menus[parent_id]" class="form-control">
                                <option value="">- <?php echo get_phrase('choose');?> Menu -</option>
                                <?php foreach ($menus as $menu): ?>
                                    <?php if ($menu['id'] != $page_data->id): ?>
                                    <option value="<?php echo $menu['id']; ?>" <?php if ($page_data->parent_id == $menu['id']): ?>selected="selected"<?php endif; ?>><?php echo $menu['title']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6">
                            <label class="text-bold">Group Menu <span class="red">*</span></label>
                            <select name="Menus[group_id]" class="form-control">
                                <option value="">- <?php echo get_phrase('choose');?> Group -</option>
                                <?php foreach ($groups as $group): ?>
                                    <option value="<?php echo $group['id']; ?>" <?php if ($page_data->group_id == $group['id']): ?>selected="selected"<?php endif; ?>><?php echo $group['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-sm-6 col-md-6">
                            <label class="text-bold">Menu Type <span class="red">*</span></label>
                            <?php $types = $this->menu_model->get_types(); ?>
                            <select name="Menus[type]" class="form-control" onchange="menuType(this);">
                                <option value="">- <?php echo get_phrase('choose');?> Type -</option>
                                <?php foreach ($types as $type => $type_name): ?>
                                    <option value="<?php echo $type; ?>" <?php if ($page_data->type == $type): ?>selected="selected"<?php endif; ?>><?php echo $type_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div id="menu-type">
                            <?php if ($page_data->type != Menu_model::TYPE_CUSTOM_LINK):?>
                                <?php $this->load->view('backend/'.$logged_in_user_role.'/menus_type', ['type' => $page_data->type, 'rel_id' => $page_data->rel_id]); ?>
                            <?php endif; ?>
                        </div>

                        <div class="form-group col-sm-6 col-md-6">
                            <label class="text-bold"><?php echo get_phrase('sort_order'); ?></label>
                            <input type="text" name="Menus[sort_order]" class="form-control" value="<?php echo $page_data->sort_order;?>">
                        </div>

                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label class="text-bold">Status</label><br/>
                            <?php $statuses = ['draft', 'published', 'hidden']; ?>
                            <?php foreach ($statuses as $i => $status): ?>
                                <label class="radio-inline">
                                    <input type="radio" name="Menus[status]" value="<?php echo $status;?>" id="optionsRadios-<?php echo $i; ?>" <?php if ($page_data->status == $status): ?>checked="checked"<?php endif; ?>>
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
    function menuType(dt) {
        var $this = $(dt);
        var url = $this.attr('attr-href');
        $.ajax({
            'url': "<?php echo site_url('panel-admin/menus/type');?>",
            'type':'post',
            'data':{'type':$this.val()},
            'success': function(data) {
                $('#menu-type').html(data);
            }
        });
    }
</script>