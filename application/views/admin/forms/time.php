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
        <?php $this->view($dir.'forms/required') ?>
    </div>
    <div class="field">
        <input type="time" name="<?= h($field) ?>" style="width:10em" class="form-control form-control-sm form-inline time" value="<?= set_value($field, @$data[$field] ? date('H:i', strtotime($data[$field])) : '') ?>" placeholder="<?= @$placeholder ?: '' ?>">
        <?= @$unit ?: '' ?>
        <?= form_error($field) ? '<span class="invalid-feedback">'.form_error($field).'</span>' : '' ?>
        <?= @$comment ? '<small class="form-text text-muted">'.$comment.'</small>' : '' ?>
    </div>
</div>
