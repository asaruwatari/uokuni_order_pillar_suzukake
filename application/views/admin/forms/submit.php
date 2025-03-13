<?php
$this->load->vars(['label' => '', 'guide' => '', 'unit' => '', 'comment' => '']);
$label    = @$label ?: @$validation_rules[$field]['label'];
$guide    = @$guide ?: @$validation_rules[$field]['guide'];
$unit     = @$unit ?: @$validation_rules[$field]['unit'];
$comment  = @$comment ?: @$validation_rules[$field]['comment'];
$disabled = @$disabled ?: @$validation_rules[$field]['disabled'];
?>
<button type="submit" class="btn btn-warning btn-sm btn-block" <?= $disabled ? 'disabled' : '' ?>> <?= h($label) ?></button>
