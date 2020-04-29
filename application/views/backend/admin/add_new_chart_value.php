<hr />
<ol class="breadcrumb bc-3">
    <li class = "active">
        <a href="#">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="<?php echo site_url('panel-admin/section_chart'); ?>"><?php echo get_phrase('section_chart'); ?></a> </li>
    <li><a href="#" class="active"><?php echo get_phrase('add_new_chart_value'); ?></a> </li>
</ol>
<h2><i class="fa fa-arrow-circle-o-right"></i> <?php echo get_phrase('add_new_chart_value'); ?></h2>
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
                <form action="<?php echo site_url('panel-admin/section-chart/new'); ?>" method="post" role="form" class="padding10">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                <label class="text-bold"><?php echo get_phrase('date'); ?> <span class="red">*</span></label>
                                <input type="text" name="chart[date]" class="form-control datepicker" id="datepicker" data-provide="datepicker" required>
                            </div>

                            <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                <label class="text-bold"><?php echo get_phrase('open'); ?> <span class="red">*</span></label>
                                <input type="text" name="chart[open]" class="form-control" id="open" required>
                            </div>

                            <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                <label class="text-bold"><?php echo get_phrase('close'); ?> <span class="red">*</span></label>
                                <input type="text" name="chart[close]" class="form-control" id="closed" required>
                            </div>

                            <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                <label class="text-bold"><?php echo get_phrase('low'); ?> <span class="red">*</span></label>
                                <input type="text" name="chart[low]" class="form-control" id="low" required>
                            </div>

                            <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                <label class="text-bold"><?php echo get_phrase('high'); ?> <span class="red">*</span></label>
                                <input type="text" name="chart[high]" class="form-control" id="high" required>
                            </div>
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
<script>
$(function() {
    $('#datepicker').daterangepicker({
        singleDatePicker: true,
        locale: {
          format: 'DD-MM-YYYY'
        }
    });
});
</script>