/**
 * メインJS
 *
 * @package    Admin
 * @subpackage
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */

$(function () {

    // 無効リンク
    $("a.disabled").on("click", function () {
        return false;
    });

    /**
     * フォーム送信先切り替え
     *
     */
    $('.change_action').click(function () {
        $(this).parents('form').attr('action', $(this).data('action'));
        $(this).parents('form').attr('target', $(this).data('target') ? $(this).data('target') : '');
    });

    /**
     * トグルチェックボックス連動
     *
     */
    $("table :checkbox.toggle").click(function () {
        $(this).parents("table").find(":checkbox:not([disabled])").prop('checked', $(this).prop('checked'));
        $(this).parents("table").find("tr").removeClass('checked');
        if ($(this).prop('checked')) {
            $(this).parents("table").find("tr").addClass('checked');
        }
    });

    /**
     * チェックボックス付きテーブル列クリック
     *
     */
    $('table.selectable tr:not(:first)').click(function (event) {
        // 行のチェックボックス取得
        var checkbox = $(this).find(':checkbox')[0];
        // 特定タグを除外
        tag = $(event.target).prop("tagName");
        if (tag == "BUTTON" || tag == "A") {
            return;
        }
        // チェック状態取得
        if (event.target != checkbox) {
            checkbox.checked = !checkbox.checked;
        }
        // TRのクラス設定
        if (checkbox.checked) {
            $(this).addClass('checked');
        } else {
            $(this).removeClass('checked');
        }
    });

    /**
     * ログアウト確認ダイアログ
     *
     */
    $(".logout").click(function () {
        // URLをセット
        var url = $(this).attr("href");
        // ダイアログ表示
        bootbox.confirm({
            size: "small",
            message: "ログアウトしますか？",
            buttons: {
                confirm: {
                    label: 'ログアウト',
                    className: 'btn-warning'
                },
                cancel: {
                    label: 'キャンセル'
                }
            },
            animate: false,
            callback: function (result) {
                if (result) {
                    // 画面遷移
                    location.href = $('base').attr('href') + url;
                }
            }
        });
        return false;
    });

    /**
     * 削除確認ダイアログ（フォームボタン型）
     *
     */
    $("button.delete").click(function () {
        // ボタンのフォームオブジェクトを退避
        var current_form = this.form;
        // チェック件数
        var checkbox_length = $(this).parents("form").find("input:checkbox:checked").length;

        if (checkbox_length == 0) {
            bootbox.alert("対象を選択してください");
            return false;
        }

        // ダイアログ表示
        bootbox.confirm({
            size: "small",
            message: "選択した" + checkbox_length + "行の情報を削除します。<br>本当に削除しますか？",
            buttons: {
                confirm: {
                    label: '削除する',
                    className: 'btn-danger'
                },
                cancel: {
                    label: 'キャンセル'
                }
            },
            animate: false,
            callback: function (result) {
                if (result) {
                    // ウェイトを入れる
                    setTimeout(function () {
                        // ダイアログ表示２回目
                        bootbox.confirm({
                            size: "small",
                            message: "[最終確認] 本当に削除しますか？",
                            buttons: {
                                confirm: {
                                    label: '本当に削除する',
                                    className: 'btn-danger'
                                },
                                cancel: {
                                    label: 'キャンセル'
                                }
                            },
                            animate: false,
                            callback: function (result) {
                                if (result) {
                                    // 画面遷移
                                    current_form.submit();
                                }
                            }
                        });
                    }, 200);
                }
            }
        });
        return false;
    });

    /**
     * 削除確認ダイアログ（リンク型）
     *
     */
    $("a.delete").click(function () {
        // URLをセット
        var url = $(this).attr("href");
        // ダイアログ表示
        bootbox.confirm({
            size: "small",
            message: "情報を削除します。<br>本当に削除しますか？",
            buttons: {
                confirm: {
                    label: '削除する',
                    className: 'btn-danger'
                },
                cancel: {
                    label: 'キャンセル'
                }
            },
            animate: false,
            callback: function (result) {
                if (result) {
                    // ウェイトを入れる
                    setTimeout(function () {
                        // ダイアログ表示２回目
                        bootbox.confirm({
                            size: "small",
                            message: "[最終確認] 本当に削除しますか？",
                            buttons: {
                                confirm: {
                                    label: '本当に削除する',
                                    className: 'btn-danger'
                                },
                                cancel: {
                                    label: 'キャンセル'
                                }
                            },
                            animate: false,
                            callback: function (result) {
                                if (result) {
                                    // 画面遷移
                                    location.href = $('base').attr('href') + url;
                                }
                            }
                        });
                    }, 200);
                }
            }
        });
        return false;
    });

    /**
     * 複製確認ダイアログ（リンク型）
     *
     */
    $("a.copy").click(function () {
        // URLをセット
        var url = $(this).attr("href");
        // ダイアログ表示
        bootbox.confirm({
            size: "small",
            message: "複製しますか？",
            buttons: {
                confirm: {
                    label: '複製する',
                    className: 'btn-warning'
                },
                cancel: {
                    label: 'キャンセル'
                }
            },
            animate: false,
            callback: function (result) {
                if (result) {
                    // 画面遷移
                    location.href = $('base').attr('href') + url;
                }
            }
        });
        return false;
    });

    /**
     * 確認ダイアログ（フォーム送信）
     *
     */
    $("form.confirm").on("submit", function () {
        // フォームオブジェクトを退避
        var current_form = this;
        // チェック件数
        var checkbox_length = $(this).find("td input:checkbox:checked").length;
        // ダイアログ表示
        bootbox.confirm({
            size: "small",
            message: "選択した" + checkbox_length + "行の一括操作を実行しますか？",
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

    /**
     * 確認ダイアログ（サブミットボタン）
     *
     */
    $("button.confirm").on("click", function () {
        // ボタンのフォームオブジェクトを退避
        var current_form = this.form;
        // チェック件数
        var checkbox_length = $(this).parents("form").find("td input:checkbox:checked").length;

        if (checkbox_length == 0) {
            bootbox.alert("対象を選択してください");
            return false;
        }

        // 題名
        var conftitle = $(this).data('conftitle');

        // ダイアログ表示
        bootbox.confirm({
            size: "small",
            message: "選択した" + checkbox_length + "件を" + conftitle + "しますか？",
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

    // Bootstrap ツールチップ
    $('[data-toggle="tooltip"]').tooltip();

    /*
     * 編集フォームはエンターキーでサブミット無効
     */
    $("form.edit input").on("keydown", function (e) {
        if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
            return false;
        } else {
            return true;
        }
    });
});