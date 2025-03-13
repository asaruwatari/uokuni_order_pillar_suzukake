<?php
$this->load->vars(['label' => '', 'guide' => '', 'unit' => '', 'comment' => '', 'disabled' => '', 'readonly' => '', 'class' => '', 'value' => '']);
$label    = @$label ?: @$validation_rules[$field]['label'];
$guide    = @$guide ?: @$validation_rules[$field]['guide'];
$unit     = @$unit ?: @$validation_rules[$field]['unit'];
$comment  = @$comment ?: @$validation_rules[$field]['comment'];
$disabled = @$disabled ?: @$validation_rules[$field]['disabled'];
$readonly = @$readonly ?: @$validation_rules[$field]['readonly'];
$class    = @$class ?: @$validation_rules[$field]['class'];
$value    = @$value ?: @$data[$field];
?>

<div class="form-group">
    <div class="name">
        <label class="control-label"><?= @$label ?></label>
    </div>
    <div class="required col-form-label col-form-label-sm">
        <?php $this->view($dir.'forms/required', ['field' => "{$field}_from"]) ?>
    </div>
    <div class="field">
        <input type="text" name="<?= h($field) ?>_from" class="form-control form-inline date" value="<?= set_value($field.'_from', isset($data[$field.'_from']) ? $data[$field.'_from'] : '') ?>" style="<?= @$ime ? "ime-mode: {$ime}" : '' ?>" placeholder="<?= @$guide ?: '' ?>">
        ～
        <input type="text" name="<?= h($field) ?>_to" class="form-control form-inline date" value="<?= set_value($field.'_to', isset($data[$field.'_to']) ? $data[$field.'_to'] : '') ?>" style="<?= @$ime ? "ime-mode: {$ime}" : '' ?>" placeholder="<?= @$guide ?: '' ?>">
        <?= @$unit ?: '' ?>
        <?= @$comment ? '<small class="form-text text-muted">'.$comment.'</small>' : '' ?>
        <?= form_error($field.'_from') ? '<span class="invalid-feedback">'.form_error($field.'_from').'</span>' : '' ?>
        <?= form_error($field.'_to') ? '<span class="invalid-feedback">'.form_error($field.'_to').'</span>' : '' ?>
    </div>
</div>
