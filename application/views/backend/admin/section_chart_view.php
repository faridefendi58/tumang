<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<hr />
<ol class="breadcrumb bc-3">
    <li class = "active">
        <a href="#">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="<?php echo site_url('panel-admin/section_chart'); ?>"><?php echo get_phrase('section_chart'); ?></a> </li>
    <li><a href="#" class="active"><?php echo get_phrase('view_chart'); ?></a> </li>
</ol>
<h2><i class="fa fa-arrow-circle-o-right"></i> <?php echo get_phrase('view_chart'); ?></h2>
<br />

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    Chart
                </div>
            </div>
            <div class="panel-body">
                <form action="<?php echo site_url('panel-admin/section-chart/getData/'); ?>" method="post" role="form" class="padding10">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                <label class="text-bold"><?php echo get_phrase('date'); ?> <span class="red">*</span></label>
                                <input type="text" name="chart[date]" class="form-control datepicker" id="datepicker" required>
                            </div>
                        </div>
                    </div>
                </form>
                
                <div id="chart_div" class="col-sm-12 col-md-12 col-lg-12" style=""></div>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback();
    $('#datepicker').daterangepicker({
        locale: {
            "separator": " s/d ",
            format: 'DD-MM-YYYY'
        }
    }, function(start, end, label) {
        //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        get_data(start, end);
    });
});
    

function get_data(start, end){
    $.ajax({
        'url': '<?=site_url('panel-admin/section_chart/view/')?>',
        'type':'post',
        'data':{'start':start.format('YYYY-MM-DD'),'end':end.format('YYYY-MM-DD')},
        'dataType': 'json',
        'success': function(jsonData) {
            if (jsonData.success) {
                $( "#chart_div" ).css("height","500px");
                drawChart(jsonData.data);
            } else {
                toastr.error(jsonData.message);
                $("#chart_div").html("");
            }
        }
    });
}

</script>
    <script type="text/javascript">
      function drawChart(jsonData) {
          
        var data = new google.visualization.DataTable();
          data.addColumn('string', 'Month'); // Impl
          data.addColumn({type:'number'});  // interval role col.
          data.addColumn({type:'number'});  // interval role col.
          data.addColumn({type:'number'});  // interval role col.
          data.addColumn({type:'number'});  // interval role col.
          data.addColumn({type: 'string', role: 'tooltip', 'p': {'html': true}});
          data.addRows(jsonData);

        var options = {
          legend: 'none',
          bar: { groupWidth: '100%' }, // Remove space between bars.
          candlestick: {
            fallingColor: { strokeWidth: 0, fill: '#a52714' }, // red
            risingColor: { strokeWidth: 0, fill: '#0f9d58' }   // green
          }
        };

        var chart = new google.visualization.CandlestickChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }

    </script>