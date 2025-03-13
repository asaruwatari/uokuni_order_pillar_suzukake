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
        <input type="text" name="<?= h($field) ?>" class="form-control" value="<?= set_value($field, isset($data[$field]) ? $data[$field] : '') ?>" placeholder="<?= @$guide ?: '' ?>" list="list_<?= h($field) ?>" <?= $readonly ? 'readonly' : '' ?> autocorrect="off" autocapitalize="off">
        <datalist id="list_<?= h($field) ?>">
            <?php
            foreach ($options as $name) {
                ?>
                <option value="<?= h($name) ?>">
                    <?php
                }
                ?>
        </datalist>
        <?= @$unit ?: '' ?>
        <?= form_error($field) ? '<span class="invalid-feedback">'.form_error($field).'</span>' : '' ?>
        <?= @$comment ? '<small class="form-text text-muted">'.$comment.'</small>' : '' ?>
    </div>
</div>
