<?php
$this->load->vars(['label' => '', 'guide' => '', 'unit' => '', 'comment' => '']);
$label   = @$label ?: @$validation_rules[$field]['label'];
$guide   = @$guide ?: @$validation_rules[$field]['guide'];
$unit    = @$unit ?: @$validation_rules[$field]['unit'];
$comment = @$comment ?: @$validation_rules[$field]['comment'];
?>
<div class="form-group row">
    <label class="col-4 col-form-label"><?= @$label ?></label>
    <div class="col-8">
        <input type="password" name="<?= h($field) ?>" class="form-control <?= form_error($field) ? 'is-invalid' : '' ?>" placeholder="<?= @$guide ?: '' ?>">
        <?= form_error($field) ? '<span class="invalid-feedback">'.form_error($field).'</span>' : '' ?>
        <?= @$comment ? '<small class="form-text text-muted">'.$comment.'</small>' : '' ?>
    </div>
</div>
