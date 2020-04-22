<ol class="breadcrumb bc-3">
    <li>
        <a href="<?php echo site_url('panel-admin/dashboard'); ?>">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="#" class="active"><?php echo get_phrase('contacts'); ?></a> </li>
</ol>
<h2><i class="fa fa-arrow-circle-o-right"></i> <?php echo $page_title; ?></h2>
<br />

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-body">
                <table class="table table-bordered mt20" id="table-1">
                    <tbody>
                    <tr>
                        <td><?php echo get_phrase('name'); ?></td>
                        <td><?php echo $data->name; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('email'); ?></td>
                        <td><?php echo $data->email; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('phone'); ?></td>
                        <td><?php echo $data->phone; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('message'); ?></td>
                        <td><?php echo $data->message; ?></td>
                    </tr>
                    </tbody>
                </table>
                <a href="javascript:void(0);"
                   onclick="return removeContact(this);"
                   attr-href="<?php echo site_url('panel-admin/contacts/delete/'. $data->id); ?>" attr-id="<?php echo $data->id;?>"
                   class="btn btn-danger mt10">
                    <?php echo get_phrase('delete');?>
                </a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function removeContact(dt) {
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
                            window.location.href = "<?php echo site_url('panel-admin/contacts/view'); ?>";
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