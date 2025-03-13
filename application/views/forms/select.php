<?php
$this->load->vars(['label' => '', 'guide' => '', 'unit' => '', 'comment' => '', 'readonly' => '']);
$label    = @$label ?: @$validation_rules[$field]['label'];
$guide    = @$guide ?: @$validation_rules[$field]['guide'];
$unit     = @$unit ?: @$validation_rules[$field]['unit'];
$comment  = @$comment ?: @$validation_rules[$field]['comment'];
$readonly = @$readonly ?: @$validation_rules[$field]['readonly'];
?>
<div class="form-group <?= form_error($field) ? 'has-error' : '' ?>">
<?= form_dropdown($field, $options, set_value($field, @$data[$field] ?: ''), 'class="form-control"') ?>
    <?= @$unit ?: '' ?>
    <?= form_error($field) ? '<span class="help-block">'.form_error($field).'</span>' : '' ?>
    <?= @$comment ? '<span class = "help-block">'.$comment.'</span>' : '' ?>
</div>
