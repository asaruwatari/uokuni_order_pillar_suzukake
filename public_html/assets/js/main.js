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

    /*
     * ログアウト確認ダイアログ
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
                    label: 'キャンセル',
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


    /*
     * メニュー
     */
    // Initialize Slidebars
    var controller = new slidebars();
    controller.init();

    // Toggle Slidebars
    $('#hamburger').on('click', function (event) {
        // Stop default action and bubbling
        event.stopPropagation();
        event.preventDefault();
        controller.toggle('menu');
    });

    $(document).click(function () {
        controller.close('menu');
    });

    var $animation = $('#hamburger');

    $animation.on('click', function () {
        if ($(this).hasClass('is-open')) {
            $(this).removeClass('is-open');
        } else {
            $(this).addClass('is-open');
        }
    });

    /*
     * 上部へスクロール
     */
    var showFlag = false;
    var topBtn = $('#totop');
    topBtn.css('bottom', '-50px');
    //スクロールが100に達したらボタン表示
    $('body').scroll(function () {
        if ($(this).scrollTop() > 100) {
            if (showFlag == false) {
                showFlag = true;
                topBtn.stop().animate({'bottom': '10px'}, 100);
            }
        } else {
            if (showFlag) {
                showFlag = false;
                topBtn.stop().animate({'bottom': '-50px'}, 100);
            }
        }
    });
    //スクロールしてトップ
    topBtn.click(function () {
        $('body').animate({
            scrollTop: 0
        }, 100);
        return false;
    });
});