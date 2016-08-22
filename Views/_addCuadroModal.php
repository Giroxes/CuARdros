<div id="dialogAddCuadroModal" title="Agregar Cuadro" style="display: none;">
    <form id="frmAddCuadro" action="cuadrosController.php" method="POST" class="form-horizontal" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="control-group">
                <label for="name" class = "control-label">Nombre</label>
                <div class="controls">
                    <input id="name" type="text" name="name" value="" size="30" class="input-xlarge" required/>
                </div>
            </div>
            
            <div class="control-group">
                <label for="author" class = "control-label">Autor</label>
                <div class="controls">
                    <input id="author" type="text" name="author" value="" size="30" class="input-xlarge" required/>
                </div>
            </div>
            
            <div class="control-group">
                <label for="age" class = "control-label">Período</label>
                <div class="controls">
                    <input id="age" type="text" name="age" value="" size="30" class="input-xlarge" required/>
                </div>
            </div>
            
            <div class="control-group">
                <label for="img" class = "control-label">Imagen</label>
                <div class="controls">
                    <input id="img" type="file" name="img" value="" required/>
                </div>
            </div>
            
            <div class="control-group">
                <label for="description" class = "control-label">Descripción</label>
                <div class="controls">
                    <textarea id="description" name="description" rows="4" cols="30" required></textarea>
                </div>
            </div>
        </div>
        <input type="hidden" name="action" value="add" />
        <div class="modal-footer">
            <button id="btnAcceptAddCuadro" class="btn btn-primary" type="submit">Aceptar</button>
            <button id="btnCancelAddCuadro" class="btn">Cancelar</button>
        </div>
    </form>
</div>

<script type="text/javascript">
    var AddCuadroModalInit = false;
    function InitAddCuadroModalDialog() {
        if (!AddCuadroModalInit) {
            AddCuadroModalInit = true;
            $("#dialogAddCuadroModal").dialog({
                sRowSelect: "single",
                autoOpen: true,
                resizable: false,
                draggable: false,
                width: 540,
                height: 540,
                modal: true,
                beforeClose: function () {
                    $("#name").val("");
                    $("#author").val("");
                    $("#age").val("");
                    $("#img").val("");
                    $("#description").val("");
                }
            });

            $("#btnCancelAddCuadro").click(function (e) {
                e.preventDefault();
                $("#dialogAddCuadroModal").dialog("close");
            });
        }       
        
        $("#dialogAddCuadroModal").dialog("open");
    }
    
    $('#frmAddCuadro').ajaxForm(function() {                
        $("#dialogAddCuadroModal").dialog("close");
        oTableCuadros.draw();
    });
</script>