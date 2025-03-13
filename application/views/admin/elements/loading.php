<!-- ローディング -->
<div id="loading" style="display: none;">
    <i class="fas fa-circle-notch fa-spin"></i>
</div>

<style>
    #loading {
        /*display: none;*/
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100vh;
        line-height: 100vh;
        z-index: 10000;
        background-color: #fff;
        filter: alpha(opacity=75);
        -moz-opacity: 0.75;
        -khtml-opacity: 0.75;
        opacity: 0.75;
        text-align: center;
        font-size: 6rem;
    }
    .fa-spin {
        -webkit-animation: fa-spin 0.4s infinite linear;
        animation: fa-spin 0.4s infinite linear;
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
        $("form.edit").on("submit", function () {
            loading();
        });
    });
</script>