<?php
$items = [];
if ($type == Menu_model::TYPE_PAGE) {
    $items = $this->page_model->findAllByAttributes(['status' => Page_model::STATUS_PUBLISHED])->result_array();
} elseif ($type == Menu_model::TYPE_POST) {
    $items = $this->post_model->findAllByAttributes(['status' => Post_model::STATUS_PUBLISHED])->result_array();
} elseif ($type == Menu_model::TYPE_CATEGORY) {
    $items = $this->postCategory_model->findAll()->result_array();
}
?>
<div class="form-group col-sm-6 col-md-6">
    <label class="text-bold"><?php echo ucfirst($type); ?> <span class="red">*</span></label>
    <?php if ($type != Menu_model::TYPE_CUSTOM_LINK): ?>
        <select name="Menus[rel_id]" class="form-control">
            <option value="">- <?php echo get_phrase('choose');?> <?php echo ucfirst($type); ?> -</option>
            <?php foreach ($items as $i => $item): ?>
                <?php
                if (array_key_exists('meta_title', $item)) {
                    $title = $item['meta_title'];
                } elseif (array_key_exists('title', $item)) {
                    $title = $item['title'];
                }
                ?>
                <option value="<?php echo $item['id']; ?>" <?php if (!empty($rel_id) && $rel_id == $item['id']):?>selected="selected"<?php endif; ?>><?php echo $title; ?></option>
            <?php endforeach; ?>
        </select>
        <?php if ($type == Menu_model::TYPE_CATEGORY):?>
            <a href="<?php echo site_url('panel-admin/categories/create'); ?>" target="_blank" class="text-info mt10 pull-right"><i class="fa fa-plus"></i> Add Category</a>
        <?php endif; ?>
    <?php else: ?>
        <input type="text" name="Menus[slug]" class="form-control" placeholder="ex: https://www.google.co.id">
    <?php endif; ?>
</div>