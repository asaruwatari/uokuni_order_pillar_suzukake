<form method="post" id="import" action="<?= h("{$dir}{$class}/import/") ?>" class="card mb-2" enctype="multipart/form-data"  autocomplete="off" novalidate>
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

    <div class="card-body form-inline form-row p-2">
        <div class="form-group-sm col">
            <a href="<?= h("{$dir}{$class}/edit") ?>" class="btn btn-sm btn-primary"><i class="fa fa-plus-square fa-fw" aria-hidden="true"></i>新規作成</a>
        </div>

        <!-- インポート -->
        <div class="form-group-sm col text-right">
            <input type="file" name="file" class="form-control-file" style="display: inline-block; width: auto;">
            <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-upload fa-fw" aria-hidden="true"></i> Excel入力</button>
        </div>
    </div>
</form>

<script>
    /**
     * 複製確認ダイアログ（リンク型）
     *
     */
    $("#import").on("submit", function () {
        // URLをセット
        var current_form = this;
        // ダイアログ表示
        bootbox.confirm({
            size: "small",
            message: "Excel入力を実行しますか？",
            buttons: {
                confirm: {
                    label: '実行する',
                    className: 'btn-warning'
                },
                cancel: {
                    label: 'キャンセル'
                }
            },
            animate: false,
            callback: function (result) {
                if (result) {
                    loading();
                    // 画面遷移
                    current_form.submit();
                }
            }
        });
        return false;
    });
</script>