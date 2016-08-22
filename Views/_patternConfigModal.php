<div id="dialogConfigPatternModal" title="Asignar Cuadro" style="display: none;">
    <table id="tablaPatternConfigs">
        <thead>
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Autor</th>
                <th>Período</th>
                <th></th>                    
            </tr>
        </thead>
    </table>
    <div class="modal-footer">
        <button id="btnCancelConfigPattern" class="btn">Cancelar</button>
    </div>
</div>

 <script>
    var cuadros = null;
    var oTablePatternConfig = null;
    function createPatternConfigTable()
    {                
        oTablePatternConfig = $('#tablaPatternConfigs').DataTable( {
            sRowSelect: "single",
            processing: true,
            serverSide: true,
            pagination: true,
            selectable: true,
            renderer: "bootstrap",
            ajax: {
                url: "cuadrosController.php",
                type: "POST",
                data: {
                    action: 'search'
                }
            },
            columns: [
                {
                    data: 'id',
                    render: function ( data, type, full, meta ) {
                        return '<img src="img/cuadros/' + data + '.jpg" style="max-height: 50px" />';
                    }
                },
                { data: 'name' },
                { data: 'author' },
                { data: 'age' },
                {
                    data: 'id',
                    render: function ( data, type, full, meta ) {
                        return '<button class="btn btn-info" onclick=\'editPattern(' + currentPatternId + ',' + data + ')\'>Asignar</button>';
                    }
                }
            ]
        });
    }

    function editPattern(pattern, cuadro)
    {
        $.ajax({
            url: 'patternsController.php',
            method: 'POST',
            data: {
                patternId: pattern,
                cuadroId: cuadro,
                action: 'edit'
            },
            complete: function ()
            {                
                oTablePatternConfig.destroy();
                $("#dialogConfigPatternModal").dialog("close");
                oTablePatterns.draw();
            }
        });
    }
</script>

<script type="text/javascript">
    var configPatternModalInit = false;
    var currentPatternId = 0;
    function InitConfigPatterModalDialog(patternId) {
        currentPatternId = patternId;
        if (!configPatternModalInit) {
            configPatternModalInit = true;
            $("#dialogConfigPatternModal").dialog({
                autoOpen: true,
                resizable: false,
                draggable: false,
                width: 700,
                height: 910,
                modal: true
            });
            $("#btnCancelConfigPattern").click(function (e) {
                e.preventDefault();
                oTablePatternConfig.destroy();
                $("#dialogConfigPatternModal").dialog("close");
            });            
            createPatternConfigTable();
        }       
        
        $("#dialogConfigPatternModal").dialog("open");
    }
    
    $('.frmConfigPattern').ajaxForm(function() {
        oTablePatternConfig.destroy();
        $("#dialogConfigPatternModal").dialog("close");
        oTablePatterns.draw();
    });
</script>