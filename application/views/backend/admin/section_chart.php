<ol class="breadcrumb bc-3">
    <li>
        <a href="<?php echo site_url('panel-admin/dashboard'); ?>">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="#" class="active"><?php echo get_phrase('section_chart'); ?></a> </li>
</ol>
<h2><i class="fa fa-arrow-circle-o-right"></i> <?php echo $page_title; ?></h2>
<br />

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
			<div class="panel-body">
                <div class="row" style="margin-left: -15px;">
                    <div class="col-md-3">
                        <a href = "<?php echo site_url('panel-admin/section-chart/new'); ?>" class="btn btn-block btn-info" type="button"><i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo get_phrase('add_chart_value'); ?></a>
                    </div>
                    <div class="col-md-3 pull-right">
                        <a href = "<?php echo site_url('panel-admin/section-chart/view'); ?>" class="btn btn-block btn-info" type="button"><i class="fa fa-charts"></i>&nbsp;&nbsp;<?php echo get_phrase('view_chart'); ?></a>
                    </div>
                </div>
                <table class="table table-bordered datatable" id="table-1">
                    <thead>
                      <tr>
                        <th><?php echo get_phrase('date'); ?></th>
                        <th><?php echo get_phrase('open'); ?></th>
                        <th><?php echo get_phrase('closed'); ?></th>
                        <th><?php echo get_phrase('low'); ?></th>
                        <th><?php echo get_phrase('high'); ?></th>
                        <th><?php echo get_phrase('actions'); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            $counter = 0;
                            foreach ($items as $item): ?>
                            <tr class= "<?php if( $counter % 2 == 0) echo 'odd gradeX'; else echo 'even gradeC'; $counter++;?>">
                                <td><?=date("d-m-Y", strtotime($item['date']))?></td>
                                <td><?=$item['open']?></td>
                                <td><?=$item['close']?></td>
                                <td><?=$item['low']?></td>
                                <td><?=$item['high']?></td>
                                <td>
                                    <div class="btn-group">
                                    <button class="btn btn-small btn-default btn-demo-space" data-toggle="dropdown"> <i class = "fa fa-ellipsis-v"></i> </button>
                                    <ul class="dropdown-menu dropdown-default" role="menu">
                                        <li>
                                            <a href="<?php echo site_url('panel-admin/section_chart/update/'.$item['id']); ?>">
                                                <?php echo get_phrase('update');?>
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="return removeApp(this);" attr-href="<?php echo site_url('panel-admin/section_chart/delete/'. $item['id']); ?>" attr-id="<?php echo $item['id'];?>">
                                                <?php echo get_phrase('delete');?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                </td>
                            </tr>
                            <? endforeach; ?>
                    </tbody>
                  </table>
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">
    function removeApp(dt) {
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
                            window.location.href = "<?php echo site_url('panel-admin/section_chart'); ?>";
                        }, 3000);
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        }
        return false;
    }
</script>