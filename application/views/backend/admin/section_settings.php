<ol class="breadcrumb bc-3">
    <li>
        <a href="<?php echo site_url('panel-admin/dashboard'); ?>">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="#" class="active"><?php echo get_phrase('section_settings'); ?></a> </li>
</ol>
<h2><i class="fa fa-arrow-circle-o-right"></i> <?php echo $page_title; ?></h2>
<br />

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <form action="<?php echo site_url('panel-admin/section-settings'); ?>" method="post" role="form" class="padding10">
                <div class="panel-heading">
                    <div class="panel-title">
                        Chart Section Settings
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6" id="chart">
                            <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                <label> <input type="checkbox"  name="section[chart][activate]" data-id="chart" class="check" <?=($config->chart->active)?'checked':'';?> /></label>
                                <label class="text-bold"><?php echo get_phrase('active'); ?></label>
                                <input type="hidden" name="section[chart][active]" id="chart_active" class="form-control" value="<?=$config->chart->active?>" />
                            </div>
                            <div id="section_chart">
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('title'); ?></label>
                                    <input type="text" name="section[chart][title]" class="form-control" value="<?=$config->chart->title?>" <?=($config->chart->active)?'':'readonly';?> />
                                </div>
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('day_range'); ?> <span class="red">*</span></label>
                                    <select name="section[chart][range]" class="form-control" <?=($config->chart->range)?'required':'readonly';?>>
                                        <?
                                        for($i=1; $i<=30; $i++){
                                            ?><option value="<?=$i?>" <?=($config->chart->range==$i)?"selected":"";?> ><?=$i?></option><?
                                        }
                                        ?>
                                    </select> 
                                </div>
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('order'); ?> <span class="red">*</span></label>
                                    <input type="text" name="section[chart][order]" class="form-control" value="<?=$config->chart->order?>" <?=($config->chart->active)?'required':'readonly';?> />
                                </div>
                            </div><input type="hidden" name="section[chart][type]" value="chart" />
                        </div>
                    </div>
                </div>
                <hr />
                <div class="panel-heading">
                    <div class="panel-title">
                        Blog Section Settings #1
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6 blog" id="blog_1">
                            <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                <label> <input type="checkbox"  name="section[blog_1][activate]" data-id="blog_1" class="check" <?=($config->blog_1->active)?'checked':'';?>></label>
                                <label class="text-bold"><?php echo get_phrase('active'); ?> </label>
                                <input type="hidden" name="section[blog_1][active]" id="blog_1_active" class="form-control" value="<?=$config->blog_1->active?>" />
                            </div>
                            <div id="section_blog_1" style="<?=($config->blog_1->active)?'':'display:none;';?>">
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('title'); ?></label>
                                    <input type="text" name="section[blog_1][title]" class="form-control" value="<?=$config->blog_1->title?>" <?=($config->blog_1->active)?'':'readonly';?>  />
                                </div>
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('sub_title'); ?></label>
                                    <input type="text" name="section[blog_1][sub_title]" class="form-control" value="<?=$config->blog_1->sub_title?>" <?=($config->blog_1->active)?'':'readonly';?>  />
                                </div>
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('description'); ?></label>
                                    <textarea name="section[blog_1][description]" class="form-control" <?=($config->blog_1->active)?'':'readonly';?> ><?=$config->blog_1->description?></textarea>
                                </div>
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('Category'); ?> <span class="red">*</span></label>
                                    <select name="section[blog_1][category]" class="form-control" <?=($config->blog_1->active)?'required':'readonly';?> >
                                        <option value="0" <?=($config->blog_1->category=="0")?"selected":"";?> >ALL</option>
                                        <?
                                        foreach ($categories as $category){
                                            ?><option value="<?=$category['id']?>" <?=($config->blog_1->category==$category['id'])?"selected":"";?>><?=$category['title']?></option><?
                                        }
                                        ?>
                                    </select> 
                                </div>
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('number_post'); ?> <span class="red">*</span></label>
                                    <select name="section[blog_1][num_post]" class="form-control"  <?=($config->blog_1->active)?'required':'readonly';?>>
                                        <option value="3" <?=($config->blog_1->category=="3")?"selected":"";?> >3</option>
                                        <option value="6" <?=($config->blog_1->category=="6")?"selected":"";?> >6</option>
                                        <option value="9" <?=($config->blog_1->category=="9")?"selected":"";?> >9</option>
                                    </select> 
                                </div>
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('order'); ?> <span class="red">*</span></label>
                                    <input type="text" name="section[blog_1][order]" class="form-control" value="<?=$config->blog_1->order?>" <?=($config->blog_1->active)?'required':'readonly';?> />
                                    <input type="hidden" name="section[blog_1][type]" value="blog" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="panel-heading">
                    <div class="panel-title">
                        Blog Section Settings #2
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6 blog" id="blog_2">
                            <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                <label> <input type="checkbox"  name="section[blog_2][activate]" data-id="blog_2" class="check" <?=($config->blog_2->active)?'checked':'';?>></label>
                                <label class="text-bold"><?php echo get_phrase('active'); ?> </label>
                                <input type="hidden" name="section[blog_2][active]" id="blog_2_active" class="form-control" value="<?=$config->blog_2->active?>" />
                            </div>
                            <div id="section_blog_2" style="<?=($config->blog_2->active)?'':'display:none;';?>">
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('title'); ?> </label>
                                    <input type="text" name="section[blog_2][title]" class="form-control" value="<?=$config->blog_2->title?>" <?=($config->blog_2->active)?'':'readonly';?>  />
                                </div>
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('sub_title'); ?> </label>
                                    <input type="text" name="section[blog_2][sub_title]" class="form-control" value="<?=$config->blog_2->sub_title?>" <?=($config->blog_2->active)?'':'readonly';?>  />
                                </div>
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('description'); ?> </label>
                                    <textarea name="section[blog_2][description]" class="form-control" <?=($config->blog_2->active)?'':'readonly';?> ><?=$config->blog_2->description?></textarea>
                                </div>
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('Category'); ?> <span class="red">*</span></label>
                                    <select name="section[blog_2][category]" class="form-control" <?=($config->blog_2->active)?'required':'readonly';?> >
                                        <option value="0" <?=($config->blog_2->category=="0")?"selected":"";?> >ALL</option>
                                        <?
                                        foreach ($categories as $category){
                                            ?><option value="<?=$category['id']?>" <?=($config->blog_2->category==$category['id'])?"selected":"";?>><?=$category['title']?></option><?
                                        }
                                        ?>
                                    </select> 
                                </div>
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('number_post'); ?> <span class="red">*</span></label>
                                    <select name="section[blog_2][num_post]" class="form-control"  <?=($config->blog_2->active)?'required':'readonly';?>>
                                        <option value="3" <?=($config->blog_2->category=="3")?"selected":"";?> >3</option>
                                        <option value="6" <?=($config->blog_2->category=="6")?"selected":"";?> >6</option>
                                        <option value="9" <?=($config->blog_2->category=="9")?"selected":"";?> >9</option>
                                    </select> 
                                </div>
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('order'); ?> <span class="red">*</span></label>
                                    <input type="text" name="section[blog_2][order]" class="form-control" value="<?=$config->blog_2->order?>" <?=($config->blog_2->active)?'required':'readonly';?> />
                                    <input type="hidden" name="section[blog_2][type]" value="blog" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="panel-heading">
                    <div class="panel-title">
                        Highlight Promo
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6 blog" id="blog">
                            <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                <label> <input type="checkbox"  name="section[promo][activate]" data-id="promo" class="check" <?=($config->promo->active)?'checked':'';?>></label>
                                <label class="text-bold"><?php echo get_phrase('active'); ?> </label>
                                <input type="hidden" name="section[promo][active]" id="promo_active" class="form-control" value="<?=$config->promo->active?>" />
                            </div>
                            <div id="section_promo">
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('title'); ?> </label>
                                    <input type="text" name="section[promo][title]" class="form-control" value="<?=$config->promo->title?>" <?=($config->promo->active)?'':'readonly';?>  />
                                </div>
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('sub_title'); ?> </label>
                                    <input type="text" name="section[promo][sub_title]" class="form-control" value="<?=$config->promo->sub_title?>" <?=($config->promo->active)?'':'readonly';?>  />
                                </div>
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('description'); ?> </label>
                                    <textarea name="section[promo][description]" class="form-control" <?=($config->promo->active)?'':'readonly';?> ><?=$config->promo->description?></textarea>
                                </div>
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('number_promo'); ?> <span class="red">*</span></label>
                                    <select name="section[promo][num_post]" class="form-control"  <?=($config->promo->active)?'required':'readonly';?>>
                                        <option value="1" <?=($config->promo->num_post=="1")?"selected":"";?> >1</option>
                                        <option value="2" <?=($config->promo->num_post=="2")?"selected":"";?> >2</option>
                                        <option value="3" <?=($config->promo->num_post=="3")?"selected":"";?> >3</option>
                                        <option value="4" <?=($config->promo->num_post=="4")?"selected":"";?> >4</option>
                                        <option value="5" <?=($config->promo->num_post=="5")?"selected":"";?> >5</option>
                                        <option value="6" <?=($config->promo->num_post=="6")?"selected":"";?> >6</option>
                                    </select> 
                                </div>
                                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                    <label class="text-bold"><?php echo get_phrase('order'); ?> <span class="red">*</span></label>
                                    <input type="text" name="section[promo][order]" class="form-control" value="<?=$config->promo->order?>" <?=($config->promo->active)?'required':'readonly';?> />
                                    <input type="hidden" name="section[promo][category]" value="9" />
                                    <input type="hidden" name="section[promo][type]" value="promo" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                            <button class="btn btn-success" type="submit" name="button"><?php echo get_phrase('Save'); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(function() {
    $(".check").click(function(){
        var id = $(this).attr("data-id");
        var div = document.getElementById(id);
        var input_id = "#"+id+"_active";
        var section = $("#section_"+id);
        if ($(this).is( ":checked" ) == true){
            $(input_id).val(1);
            $(div).find('input:text, input:password, input:file, select, textarea').each(function() {
                $(this).removeAttr('readonly');
                $(this).attr('required', 'required');
            });
            $(section).slideDown();
        } else {
            $(input_id).val(0);
            $(div).find('input:text, input:password, input:file, select, textarea').each(function() {
                $(this).attr('readonly', 'readonly');
                $(this).removeAttr('required', '');
            });
            $(section).slideUp();
        }
    });
});
</script>