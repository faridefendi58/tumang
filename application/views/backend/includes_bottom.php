<link rel="stylesheet" href="<?php echo base_url('assets/backend/js/jvectormap/jquery-jvectormap-1.2.2.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/backend/js/rickshaw/rickshaw.min.css'); ?>">
<!-- Bottom Scripts -->
<script src="<?php echo base_url('assets/backend/js/gsap/main-gsap.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/bootstrap.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/joinable.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/resizeable.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/neon-api.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/jvectormap/jquery-jvectormap-europe-merc-en.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/jquery.sparkline.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/rickshaw/vendor/d3.v3.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/rickshaw/rickshaw.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/raphael-min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/morris.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/toastr.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/neon-chat.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/neon-custom.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/neon-demo.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/datatables/TableTools.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/dataTables.bootstrap.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/datatables/jquery.dataTables.columnFilter.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/datatables/lodash.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/datatables/responsive/js/datatables.responsive.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/select2/select2.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/custom-datatable.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/jquery.nestable.js'); ?>"></script>
<!-- <script src="<?php echo base_url('assets/backend/css/font-icons/simple-line-icon/js/icons-lte.js'); ?>"></script> -->
<script src="<?php echo base_url('assets/backend/js/selectboxit/jquery.selectBoxIt.min.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/wysihtml5/wysihtml5-0.4.0pre.min.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/wysihtml5/bootstrap-wysihtml5.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/fileinput.js');?>"></script>
<!-- <script src="<?php echo base_url('assets/backend/js/daterangepicker/moment.min.js');?>"></script> -->
<!-- <script src="<?php echo base_url('assets/backend/js/daterangepicker/daterangepicker.js');?>"></script> --!>
<script src="<?php echo base_url('assets/backend/js/daterangepicker3.0.5/moment.min.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/daterangepicker3.0.5/daterangepicker.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/font-awesome-icon-picker/fontawesome-four-iconpicker.min.js');?>" charset="utf-8"></script>
<!-- <script src="<?php echo base_url('assets/backend/js/font-awesome-icon-picker/fontawesome-iconpicker.min.js');?>" charset="utf-8"></script> -->
<script src="<?php echo base_url('assets/backend/js/bootstrap-tagsinput.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/bootstrap-timepicker.min.js');?>"></script>
<script src="<?php echo base_url('assets/backend/lib/editarea/edit_area_full.js');?>"></script>
<script src="<?php echo base_url('assets/backend/lib/tinymce/tinymce.min.js');?>"></script>
<script src="<?php echo base_url('assets/backend/lib/jquery-sortable-lists/jquery-sortable-lists.min.js');?>"></script>

<script>
$(document).ready(function() {
    $(".html5editor").each(function(){$(this).wysihtml5();});
    if ($('#edit-area').length > 0) {
        editAreaLoader.init({
            id: "edit-area"	// id of the textarea to transform
            ,start_highlight: true	// if start with highlight
            ,allow_resize: "both"
            ,allow_toggle: true
            ,word_wrap: true
            ,language: "en"
            ,syntax: "html"
        });
    }
    if ($('.tinymce').length > 0) {
        tinymce.init({
            selector : '.tinymce',
            remove_linebreaks : false,
            gecko_spellcheck : false,
            keep_styles : true,
            accessibility_focus : true,
            tabfocus_elements : 'major-publishing-actions',
            media_strict : false,
            height: 400,
            plugins : 'code image imagetools paste codesample link',
            menubar : true,
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | pastetext image code codesample link',
            codesample_languages: [
                {text: 'HTML/XML', value: 'markup'},
                {text: 'JavaScript', value: 'javascript'},
                {text: 'CSS', value: 'css'},
                {text: 'PHP', value: 'php'},
                {text: 'Ruby', value: 'ruby'},
                {text: 'Python', value: 'python'},
                {text: 'Java', value: 'java'},
                {text: 'C', value: 'c'},
                {text: 'C#', value: 'csharp'},
                {text: 'C++', value: 'cpp'}
            ],
            valid_elements : '*[*]',
            apply_source_formatting : true,
            content_css: "<?php echo site_url('assets/frontend/'. get_settings('theme') .'/css/bootstrap.min.css'); ?>",
            images_upload_handler: function (blobInfo, success, failure) {
                var xhr, formData;

                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '<?php echo site_url("panel-admin/posts/direct-upload"); ?>');

                xhr.onload = function() {
                    var json;

                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }

                    var json = $.parseJSON(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }

                    success(json.location);
                };

                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());

                xhr.send(formData);
            }
        });
    }
});
$(function() {
   $('.icon-picker').iconpicker();
 });
</script>
<!-- SHOW TOASTR NOTIFIVATION -->
<?php if ($this->session->flashdata('flash_message') != ""):?>

<script type="text/javascript">
	toastr.success('<?php echo $this->session->flashdata("flash_message");?>');
</script>

<?php endif;?>

<?php if ($this->session->flashdata('error_message') != ""):?>

<script type="text/javascript">
	toastr.error('<?php echo $this->session->flashdata("error_message");?>');
</script>

<?php endif;?>
