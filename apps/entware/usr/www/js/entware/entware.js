/*
<script>
    var ajaxload_callback = '';
    $.getScript("/js/lib/cTools.js", function () {
    ajaxload_callback = new cTools();
});
</script>
*/

$(() => {
    const $menuItems = $("#menu-list").children("li");
    const $contentItems = $("#content > div");
    const $contentItemInstall = $contentItems.filter("[data-id='install']");
    const $logsContent = $contentItemInstall.find("pre[data-id='install_logs']");
    const $installButton = $contentItemInstall.find("button[data-id='install_button']");
    const $installSpinner = $installButton.find("img");
    const $installIcon = $installButton.find("i");
    let installStatusUpdate;

    $menuItems.on('click', e => {
        const id = $(e.delegateTarget).attr('data-id');
        selectMenuItem(id);
    });

    // info -> install button
    $contentItems.filter("[data-id='info']").find("button[data-id='info_install']").on('click', () => {
        selectMenuItem('install');
    });

    // install -> install button
    $installButton.on('click', () => {
        $.ajax({
            url:'/lib/entware/api.php',
            type:'get',
            data:{'fn':'install'},
            dataType:'json',
            beforeSend: (/*jqXHR, settings*/) => {
                $installSpinner.show();
                $installIcon.hide();
                installStatusUpdate = setInterval("readLogs()", 1000);
            },
            complete: (/*jqXHR, textStatus*/) => {
                $installSpinner.hide();
                clearInterval(installStatusUpdate);
            },
            success: (data/*, textStatus, jqXHR*/) => {
                $installIcon.removeClass();
                $installIcon.addClass(data.result === 0 ? "icon-ok-circle" : "icon-remove-circle");
                $installIcon.show();
                readLogs();
            }
        });
    });


    function selectMenuItem(id) {
        $menuItems.removeClass('act');
        $menuItems.filter("li[data-id='" + id + "']").addClass('act');

        $contentItems.hide();
        $contentItems.filter("div[data-id='" + id + "']").show();
    }

    function readLogs() {
        $.ajax({
            url:'/lib/entware/api.php',
            type:'get',
            data:{'fn':'log'},
            dataType:'text',
            success: (resp/*, textStatus, jqXHR*/) => {
                $logsContent
                    .html(resp)
                    .scrollTop(Number.MAX_SAFE_INTEGER);
            }
        });
    }

    readLogs();
    selectMenuItem('info');
});
