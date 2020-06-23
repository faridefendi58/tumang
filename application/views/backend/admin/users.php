<ol class="breadcrumb bc-3">
    <li>
        <a href="<?php echo site_url('panel-admin/dashboard'); ?>">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li><a href="#" class="active"><?php echo get_phrase('user'); ?></a> </li>
</ol>
<h2><i class="fa fa-arrow-circle-o-right"></i> <?php echo $page_title; ?></h2>
<br />

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
			<div class="panel-body">
                <div class="row" style="margin-left: -15px;">
                    <div class="col-md-3">
                        <a href = "<?php echo site_url('panel-admin/user_form/add_user_form'); ?>" class="btn btn-block btn-info" type="button"><i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo get_phrase('add_user'); ?></a>
                    </div>
                </div>
                <table class="table table-bordered datatable" id="table-1">
                    <thead>
                      <tr>
                        <th><?php echo get_phrase('name'); ?></th>
                        <th><?php echo get_phrase('email'); ?></th>
                        <th><?php echo get_phrase('date_added'); ?></th>
                        <th><?php echo get_phrase('actions'); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users->result_array() as $user): ?>
                            <tr class="gradeU">
                              <td><?php echo $user['first_name'].' '.$user['last_name']; ?></td>
                              <td><?php echo $user['email']; ?></td>
                              <td><?php echo date('D, d-M-Y', $user['date_added']); ?></td>
                              <td>
                                <?php if ($this->session->userdata('user_id') != $user['id']): ?>
                                  <div class="btn-group">
                                      <button type="button" class="btn btn-default" data-toggle="dropdown"> <i class = "fa fa-ellipsis-v"></i> </button>
                                      <ul class="dropdown-menu">
                                          <li>
                                              <a href="<?php echo site_url('panel-admin/user_form/edit_user_form/'.$user['id']) ?>">
                                                  <?php echo get_phrase('edit');?>
                                              </a>
                                          </li>
                                          <li class="divider"></li>
                                          <li>
                                              <a href="#" onclick="confirm_modal('<?php echo site_url('panel-admin/users/delete/'.$user['id']); ?>');">
                                                  <?php echo get_phrase('delete');?>
                                              </a>
                                          </li>
                                      </ul>
                                  </div>
                                <?php endif;?>
                              </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                  </table>
			</div>
		</div>
	</div>
</div>


<div class="row">
    <div class="col-md-12">
      <div class="grid simple">
        <div class="grid-body no-border">


          <div class="row">
              <br>

          </div>
        </div>
      </div>
    </div>
</div>
