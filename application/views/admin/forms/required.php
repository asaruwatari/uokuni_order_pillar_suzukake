<?php
if (false !== strpos((@$validation_rules[$field]['rules'] ?: ''), 'required')) {
    ?><span class="badge badge-danger">必須</span><?php
} else {
    ?><span class="badge badge-secondary">任意</span><?php
}
?>
