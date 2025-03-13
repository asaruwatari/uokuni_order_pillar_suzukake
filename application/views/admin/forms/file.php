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
        if (@$data[$field]) {
            ?>
            <a href="<?= $file_dir.'/'.$data[$field] ?>" class="btn btn-primary" target="_blank"><i class="fas fa-file-download fa-fw"></i><?= @$data[$field] ?></a>
            <div class="checkbox">
                <label><input type="checkbox" name="<?= h($field) ?>_delete_flag" value="1"> 削除</label>
            </div>
            <?php
        }
        ?>
        <input type="hidden" name="<?= h($field) ?>" value="<?= h(@$data[$field]) ?>">
        <input type="file" name="<?= h($field) ?>_file" class="form-control">

        <span class="help-block">合計<?= min([ini_get('post_max_size'), ini_get('upload_max_filesize'), ini_get('memory_limit')]) ?>Bまで</span>
        <?= form_error($field) ? '<span class="invalid-feedback">'.form_error($field).'</span>' : '' ?>
        <?= @$comment ? '<small class="form-text text-muted">'.$comment.'</small>' : '' ?>
    </div>
</div>
