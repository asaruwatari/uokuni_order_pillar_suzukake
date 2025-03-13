<?php
$this->load->vars(['label' => '', 'guide' => '', 'unit' => '', 'comment' => '', 'readonly' => '', 'class' => '', 'value' => '']);
$label    = @$label ?: @$validation_rules[$field]['label'];
$guide    = @$guide ?: @$validation_rules[$field]['guide'];
$unit     = @$unit ?: @$validation_rules[$field]['unit'];
$comment  = @$comment ?: @$validation_rules[$field]['comment'];
$readonly = @$readonly ?: @$validation_rules[$field]['readonly'];
$class    = @$class ?: @$validation_rules[$field]['class'];
$value    = @$value ?: @$data[$field];

if ($readonly) {
    $this->load->view($dir.'forms/select_hidden', ['field' => $field, 'options' => $options]);
} else {
    ?>
    <div class="form-group">
        <label class="col-form-label col-form-label-sm"><?= @$label ?></label>
        <div class="required col-form-label col-form-label-sm">
            <?php $this->view($dir.'forms/required') ?>
        </div>
        <div class="field">
            <?= form_dropdown($field, $options, set_value($field, @$data[$field] ?: ''), 'class="form-control form-control-sm '.(form_error($field) ? 'is-invalid' : '').'"') ?>
            <?= @$unit ?: '' ?>
            <?= form_error($field) ? '<span class="invalid-feedback">'.form_error($field).'</span>' : '' ?>
            <?= @$comment ? '<small class="form-text text-muted">'.$comment.'</small>' : '' ?>
        </div>
    </div>
    <?php
}
?>
