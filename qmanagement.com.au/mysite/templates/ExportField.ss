<button class='linkfield-button ss-ui-button ss-ui-button-small' id='irx_export'>
    <span id="loading"></span>Export</button>
<script type='text/javascript'>
jQuery(function($) {
    $('#irx_export').click(function() {
        $.ajax({
            url: "$Link('toZip')",
            type: "post",
            dataType: "json",
            beforeSend: function(XMLHttpRequest) {

                $("#loading").html("<img src='cms/images/loading.gif' />");
            },
            success: function(data, textStatus) {
                console.info(data.flag);
                if (data.flag == true) {
                    window.open("$Link(downloadPage)?file=" + data.msg, "_self");
                } else {
                    alert(data.msg);
                }

            },
            complete: function(XMLHttpRequest, textStatus) {

                $("#loading").empty();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

                $("#loading").empty();
            }
        });

    });
});
</script>
