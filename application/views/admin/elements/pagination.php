<div class="pager-box my-2">
    <div class="info">
        <?= $pagination['rows_from'] ?>-<?= $pagination['rows_to'] ?>件 / <?= $pagination['total_rows'] ?>件
    </div>
    <?= $this->pagination->create_links() ?>
</div>