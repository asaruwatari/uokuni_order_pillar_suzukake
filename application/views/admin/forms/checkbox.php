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
    <label class="col-form-label col-form-label-sm"><?= @$label ?></label>
    <div class="required col-form-label col-form-label-sm">
        <?php $this->view($dir.'forms/required') ?>
    </div>
    <div class="field">
        <?php
        foreach ($options as $id => $name) {
            ?>
            <div class="form-check">
                <label>
                    <?= form_checkbox("{$field}[{$id}]", $id, false !== array_search($id, array_column($data[$field], $checkbox_field)), 'class="form-check-input"'.($disabled ? ' disabled' : '')) ?>
                    <?= h($name) ?>
                </label>
            </div>
            <?php
        }
        ?>
        <?= @$unit ?: '' ?>
        <?= form_error($field) ? '<span class="invalid-feedback">'.form_error($field).'</span>' : '' ?>
        <?= @$comment ? '<small class="form-text text-muted">'.$comment.'</small>' : '' ?>
    </div>
</div>
