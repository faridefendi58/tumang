<ol class="breadcrumb bc-3">
    <li>
        <a href="<?php echo site_url('panel-admin/dashboard'); ?>">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="#" class="active"><?php echo get_phrase('menus'); ?></a> </li>
</ol>

<h2><?php echo $page_title; ?></h2>
<br />
<style>
    ul#sTree2 {display: block;list-style-type: decimal;margin-block-start: 1em;margin-block-end: 1em;margin-inline-start: 0px;margin-inline-end: 0px;padding-inline-start: 40px;}
    ul#sTree2 li {list-style-type: none;margin: 5px;}
    ul#sTree2 li div {padding: 7px;border: 1px solid #dbdbdb;}
    ul#sTree2 div .fa-arrows-alt {margin-right: 10px;}
    ul#sTree2 .fa-arrows-alt:hover {cursor: move;}
    .currElemClass{border:1px solid orange;}
    .openerClass{}
</style>
<div class="row">
    <div class="col-md-4">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><?php echo get_phrase('pages'); ?></a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <form method="post" action="<?php echo site_url('panel-admin/menus/add-link');?>">
                            <?php $pages = $this->page_model->get_all_published();?>
                            <?php foreach ($pages as $p => $page): ?>
                            <div class="form-group">
                                <input type="checkbox" name="PageLink[page_id][]" value="<?php echo $page['id'];?>"> <?php echo $page['meta_title']; ?>
                            </div>
                            <?php endforeach; ?>

                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="btn btn-success pull-right"><?php echo get_phrase('add_to_menu');?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><?php echo get_phrase('custom_links'); ?></a>
                    </h4>
                </div>
                <div id="collapse2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <form method="post" class="form-horizontal" action="<?php echo site_url('panel-admin/menus/add-link');?>">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Url <span class="red">*</span></label></label>
                                <div class="col-sm-8">
                                    <input type="text" name="CustomLink[slug]" class="form-control" value="http://">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Link Text <span class="red">*</span></label></label>
                                <div class="col-sm-8">
                                    <input type="text" name="CustomLink[title]" class="form-control" placeholder="Link Text">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="btn btn-success"><?php echo get_phrase('add_to_menu');?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"><?php echo get_phrase('categories'); ?></a>
                    </h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse">
                    <div class="panel-body">
                        <form method="post" action="<?php echo site_url('panel-admin/menus/add-link');?>">
                            <?php $categories = $this->postCategory_model->get_items();?>
                            <?php foreach ($categories as $c => $category): ?>
                                <div class="form-group">
                                    <input type="checkbox" name="CategoryLink[cat_id][]" value="<?php echo $category['id'];?>"> <?php echo $category['title']; ?>
                                </div>
                            <?php endforeach; ?>

                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="btn btn-success pull-right"><?php echo get_phrase('add_to_menu');?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo get_phrase('menu_settings');?>
                </div>
                <div class="pull-right">
                    <div class="form-group">
                        <?php $menu_groups = $this->menuGroup_model->get_items(); ?>
                        <select name="nav_group" class="form-control" onchange="selectedGroup(this);">
                            <option value="">- <?php echo get_phrase('Choose') ?> Group -</option>
                            <?php foreach ($menu_groups as $mg => $menu_group): ?>
                            <option value="<?php echo $menu_group['id']; ?>" <?php if ($menu_group['id'] == $group_id): ?>selected="selected"<?php endif; ?>><?php echo $menu_group['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row" style="margin-left: -15px;">
                    <div class="col-md-3 pull-right">
                        <a href = "<?php echo site_url('panel-admin/menus/create'); ?>" class="btn btn-block btn-info" type="button"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo get_phrase('add_menu'); ?></a>
                    </div>
                </div>
                <?php if (!empty($group_id)): ?>
                    <ul class="sTree2 listsClass" id="sTree2">
                        <!--<li id="item_a" data-module="a">
                            <div>Item a</div>
                        </li>
                        <li class="sortableListsOpen" id="item_b" data-module="b">
                            <div>Item b</div>
                            <ul class="">
                                <li id="item_b1" data-module="b">
                                    <div>Item b1</div>
                                </li>
                                <li id="item_b2" data-module="b">
                                    <div><span class="clickable">Item b2 - clickable text</span></div>
                                </li>
                            </ul>
                        </li>
                        <li class="" id="item_d" data-module="d">
                            <div>Item d</div>
                        </li>-->
                        <?php echo $this->menu_model->get_sortable_items($group_id); ?>
                    </ul>
                    <div class="clearfix mt20"></div>
                    <a href="javascript:void(0);" id="toArrBtn" class="btn btn-info pull-right hidden"><?php echo get_phrase('update');?> Menu</a>
                    <div class="clearfix mb20"></div>
                <?php else: ?>
                <table class="table table-bordered datatable" id="table-1">
                    <thead>
                    <tr>
                        <th><?php echo get_phrase('title'); ?></th>
                        <th><?php echo get_phrase('parent'); ?></th>
                        <th><?php echo get_phrase('group'); ?></th>
                        <th><?php echo get_phrase('status'); ?></th>
                        <th><?php echo get_phrase('actions'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $counter = 1;
                    foreach ($menus as $menu): ?>
                        <tr class= "<?php if( $counter % 2 == 0) echo 'odd gradeX'; else echo 'even gradeC'; $counter++;?>">
                            <td>
                                <a href="<?php echo site_url('panel-admin/menus/update/'.$menu['id']); ?>" class="text-info"><?php echo $menu['title']; ?></a>
                            </td>
                            <td><?php echo $menu['parent']; ?></td>
                            <td><?php echo $menu['group_name']; ?></td>
                            <td><?php echo $menu['status']; ?></td>
                            <td>

                                <div class="btn-group">
                                    <button class="btn btn-small btn-default btn-demo-space" data-toggle="dropdown"> <i class = "fa fa-ellipsis-v"></i> </button>
                                    <ul class="dropdown-menu dropdown-default" role="menu">
                                        <li>
                                            <a href="<?php echo site_url('panel-admin/menus/update/'.$menu['id']); ?>">
                                                <?php echo get_phrase('edit');?>
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="return removeMenu(this);" attr-href="<?php echo site_url('panel-admin/menus/delete/'.$menu['id']); ?>" attr-id="<?php echo $menu['id']; ?>">
                                                <?php echo get_phrase('delete');?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function removeMenu(dt) {
        if (confirm('Are you sure you want to delete this data?')) {
            var $this =  $(dt);
            var url = $this.attr('attr-href');
            $.ajax({
                'url': url,
                'type':'post',
                'data':{'id':$this.attr('attr-id')},
                'dataType': 'json',
                'success': function(data) {
                    if (data.success) {
                        toastr.success(data.message);
                        setTimeout(function () {
                            window.location.href = "<?php echo site_url('panel-admin/menus'); ?>";
                        }, 3000);
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        }
        return false;
    }

    function selectedGroup(dt) {
        if ($(dt).val().length > 0) {
            window.location.href = "<?php echo site_url('panel-admin/menus/view'); ?>/"+ $(dt).val();
        } else {
            window.location.href = "<?php echo site_url('panel-admin/menus'); ?>";
        }
    }

    $(function () {
        var options = {
            placeholderCss: {'background-color': '#ebebeb'},
            hintCss: {'border':'1px dashed #dbdbdb'},
            onChange: function( cEl )
            {
                console.log( 'onChange' );
            },
            complete: function( cEl )
            {
                console.log(cEl.context);
                if (cEl.context.className == 'fa fa-pencil' && cEl.context.id.length > 0) {
                    window.location.href = cEl.context.id;
                    console.log(cEl.context);
                }
                $('#toArrBtn').removeClass('hidden');
            },
            isAllowed: function( cEl, hint, target )
            {
                // Be carefull if you test some ul/ol elements here.
                // Sometimes ul/ols are dynamically generated and so they have not some attributes as natural ul/ols.
                // Be careful also if the hint is not visible. It has only display none so it is at the previouse place where it was before(excluding first moves before showing).
                if( target.data('module') === 'c' && cEl.data('module') !== 'c' )
                {
                    hint.css('background-color', '#ff9999');
                    return false;
                }
                else
                {
                    hint.css('border', '1px dashed #dbdbdb');
                    return true;
                }
            },
            opener: {
                active: true,
                as: 'html',  // if as is not set plugin uses background image
                close: '<i class="fa fa-minus c3"></i>',  // or 'fa-minus c3',  // or './imgs/Remove2.png',
                open: '<i class="fa fa-plus"></i>',  // or 'fa-plus',  // or'./imgs/Add2.png',
                openerCss: {
                    'display': 'inline-block',
                    //'width': '18px', 'height': '18px',
                    'float': 'left',
                    'margin-left': '-35px',
                    'margin-right': '5px',
                    //'background-position': 'center center', 'background-repeat': 'no-repeat',
                    'font-size': '1.1em'
                }
            },
            ignoreClass: 'clickable'
        };

        $('#sTree2').sortableLists(options);

        $('#toArrBtn').on('click', function(){
            $.ajax({
                'url': "<?php echo site_url('panel-admin/menus/re-order');?>",
                'type':'post',
                'data':{'Menus':$('#sTree2').sortableListsToArray()},
                'dataType': 'json',
                'success': function(data) {
                    console.log(data);
                    if (data.success) {
                        toastr.success(data.message);
                        $('#toArrBtn').addClass('hidden');
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        });
    });
</script>