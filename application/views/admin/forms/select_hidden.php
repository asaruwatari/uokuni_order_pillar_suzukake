<?php
$this->load->vars(['label' => '', 'guide' => '', 'unit' => '', 'comment' => '', 'readonly' => '', 'class' => '', 'value' => '']);
$label    = @$label ?: @$validation_rules[$field]['label'];
$guide    = @$guide ?: @$validation_rules[$field]['guide'];
$unit     = @$unit ?: @$validation_rules[$field]['unit'];
$comment  = @$comment ?: @$validation_rules[$field]['comment'];
$readonly = @$readonly ?: @$validation_rules[$field]['readonly'];
$class    = @$class ?: @$validation_rules[$field]['class'];
$value    = @$value ?: @$data[$field];
?>

<div class="form-group">
    <label class="col-form-label col-form-label-sm"><?= @$label ?></label>
    <div class="required col-form-label col-form-label-sm">

    </div>
    <div class="field col-form-label col-form-label-sm">
        <?= h(@$options[$data[$field]] ?: '') ?>
        <input type="hidden" name="<?= h($field) ?>" value="<?= set_value($field, isset($data[$field]) ? $data[$field] : '') ?>">
        <?= @$unit ?: '' ?>
        <?= form_error($field) ? '<span class="invalid-feedback">'.form_error($field).'</span>' : '' ?>
        <?= @$comment ? '<small class="form-text text-muted">'.$comment.'</small>' : '' ?>
    </div>
</div>
