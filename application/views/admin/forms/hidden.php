<?php
$this->load->vars(['value' => '']);
$value = @$value ?: @$data[$field];
?>
<input type="hidden" name="<?= h($field) ?>" value="<?= set_value($field, $value) ?>">
<?= form_error($field) ? '<span class="invalid-feedback">'.form_error($field).'</span>' : '' ?>
