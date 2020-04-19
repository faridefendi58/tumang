<?php
$items = [];
if ($type == Menu_model::TYPE_PAGE) {
    $items = $this->page_model->findAllByAttributes(['status' => Page_model::STATUS_PUBLISHED])->result_array();
} elseif ($items == Menu_model::TYPE_PAGE) {
    $items = $this->page_model->findAllByAttributes(['status' => Post_model::STATUS_PUBLISHED])->result_array();
}
?>
<div class="form-group col-sm-6 col-md-6">
    <label class="text-bold"><?php echo ucfirst($type); ?> <span class="red">*</span></label>
    <select name="Menus[rel_id]" class="form-control">
        <option value="">- <?php echo get_phrase('choose');?> <?php echo ucfirst($type); ?> -</option>
        <?php foreach ($items as $i => $item): ?>
            <?php
            if (array_key_exists('meta_title', $item)) {
                $title = $item['meta_title'];
            } elseif (array_key_exists('meta_title', $item)) {
                $title = $item['title'];
            }
            ?>
            <option value="<?php echo $item['id']; ?>" <?php if (!empty($rel_id) && $rel_id == $item['id']):?>selected="selected"<?php endif; ?>><?php echo $title; ?></option>
        <?php endforeach; ?>
    </select>
</div>