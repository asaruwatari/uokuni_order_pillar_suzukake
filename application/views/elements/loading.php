<!-- ローディング -->
<div id="loading" style="display: none;">
    <i class="fas fa-spinner fa-2x fa-pulse faa-fast"></i>
</div>

<style>
    #loading {
        display: none;
        position: fixed;
        top: 0px;
        left: 0px;
        width: 100vw;
        height: 100vh;
        text-align: center;
        line-height: 100vh;
        z-index: 999;
        background-color: rgba(0,0,0,0.20);
    }
</style>

<script>
    /*
     * ローディング表示
     */
    function loading() {
        // ベース高さをHTML全体に合わせて表示
        $("#loading").css({'display': 'block'});
    }
    /*
     * ローディング消去
     */
    function clear_loading() {
        $("#loading").css({'display': 'none'});
    }

    $(function () {
        /**
         * Ajaxイベント
         * Global Events
         */
        $("document").on("ajaxSend", function () {
            loading();
        }).bind("ajaxComplete", function () {
            clear_loading();
        });

        /*
         * フォーム送信イベント
         */
        $("form").on("submit", function () {
            loading();
        });
    });
</script>