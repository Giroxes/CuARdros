<div id="dialogCuadroInfoModal" title="Información" style="display: none;">    
</div>

<script type="text/javascript">
    var CuadroInfoModalInit = false;
    function InitAddCuadroModalDialog(id) {
        if (!CuadroInfoModalInit) {
            CuadroInfoModalInit = true;
            $("#dialogCuadroInfoModal").dialog({
                sRowSelect: "single",
                autoOpen: true,
                resizable: false,
                draggable: false,
                width: 540,
                modal: true,
                beforeClose: function () {
                    $("#name").val("");
                    $("#author").val("");
                    $("#age").val("");
                    $("#img").attr("src", "");
                    $("#description").val("");
                }
            });
        }       
        $('#dialogCuadroInfoModal').load('cuadrosController.php?action=info&id=' + id).dialog('open');
    }
</script>