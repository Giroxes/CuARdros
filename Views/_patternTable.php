<table id="tablePatterns">
            <thead>
                <tr>
                    <th>Patrón</th>
                    <th>Cuadro</th>
                    <th></th>
                </tr>
            </thead>
        </table>
        <button id="btnaddPattern" onclick="addPattern();" type="button" class="btn btn-success" >Añadir patrón</button>
        <script>
            var oTablePatterns = null;
            $(function ()
            {                
                oTablePatterns = $('#tablePatterns').DataTable( {
                    processing: true,
                    serverSide: true,
                    pagination: true,
                    selectable: true,
                    renderer: "bootstrap",
                    ajax: {
                        url: "patternsController.php",
                        type: "POST",
                        data: {
                            action: 'search'
                        }
                    },
                    columns: [
                        {                            
                            // Patrón
                            data: 'id',
                            render: function ( data, type, full, meta ) {
                                return '<img src="img/patterns/%20(' + data + ').png" style="max-height: 50px" />';
                            },
                            orderable: false
                        },
                        {
                            data: 'cuadroid',
                            render: function ( data, type, full, meta ) {
                                return '<img src="img/cuadros/' + data + '.jpg" style="max-height: 50px" />';
                            },
                            orderable: false
                        },
                        {
                            data: 'id',
                            render: function ( data, type, full, meta ) {
                                return '<button onclick="InitConfigPatterModalDialog(' + data + ');" type="button" class="btn btn-info" >Asignar cuadro</button>'+
                                        '<button onclick="deletePattern(' + data + ');" type="button" class="btn btn-danger" >Eliminar</button>';;
                            },
                            orderable: false
                        }
                    ]
                });
            });
            
            function addPattern()
            {
                $.ajax({
                    url: 'patternsController.php',
                    method: 'POST',
                    data: {
                        action: 'add'
                    },
                    complete: function ()
                    {
                        oTablePatterns.draw();
                    }
                });
            }
            
            function deletePattern(id)
            {
                $.ajax({
                    url: 'patternsController.php',
                    method: 'POST',
                    data: {
                        id: id,
                        action: 'delete'
                    },
                    complete: function ()
                    {
                        oTablePatterns.draw();
                    }
                });
            }
        </script>