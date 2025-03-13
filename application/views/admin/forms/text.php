<?php
$this->load->vars(['label' => '', 'guide' => '', 'unit' => '', 'comment' => '', 'readonly' => '', 'style' => '', 'class' => '', 'value' => '']);
$label    = @$label ?: @$validation_rules[$field]['label'];
$guide    = @$guide ?: @$validation_rules[$field]['guide'];
$unit     = @$unit ?: @$validation_rules[$field]['unit'];
$comment  = @$comment ?: @$validation_rules[$field]['comment'];
$readonly = @$readonly ?: @$validation_rules[$field]['readonly'];
$style    = @$style ?: @$validation_rules[$field]['style'];
$class    = @$class ?: @$validation_rules[$field]['class'];
$value    = @$value ?: @$data[$field];
?>

<div class="form-group">
    <label class="col-form-label col-form-label-sm"><?= @$label ?></label>
    <div class="required col-form-label col-form-label-sm">
        <?php $this->view($dir.'forms/required') ?>
    </div>
    <div class="field">
        <input type="text" name="<?= h($field) ?>" class="form-control form-control-sm <?= h($class) ?> <?= form_error($field) ? 'is-invalid' : '' ?>" style="<?= @$unit ? 'display:inline-block; width:10em' : '' ?>" value="<?= set_value($field, isset($data[$field]) ? $data[$field] : '') ?>" placeholder="<?= @$guide ?: '' ?>" <?= $readonly ? 'readonly' : '' ?> autocorrect="off" autocomplete="off" autocapitalize="off">
        <?= @$unit ?: '' ?>
        <?= form_error($field) ? '<span class="invalid-feedback">'.form_error($field).'</span>' : '' ?>
        <?= @$comment ? '<small class="form-text text-muted">'.$comment.'</small>' : '' ?>
    </div>
</div>
