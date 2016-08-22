        <table id="tablaCuadros">
            <thead>
                <tr>
                    <th>id</th>
                    <th></th>
                    <th>Name</th>
                    <th>Author</th>
                    <th>Período</th>
                    <th>Description</th>
                    <th></th>                    
                </tr>
            </thead>
        </table>
        <button id="btnaddCuadro" onclick="InitAddCuadroModalDialog();" type="button" class="btn btn-success" >Añadir cuadro</button>
        <script>
            var cuadros = null;
            var oTableCuadros = null;
            $(function ()
            {                
                oTableCuadros = $('#tablaCuadros').DataTable( {
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
                        { data: 'id' },
                        {
                            data: 'id',
                            render: function ( data, type, full, meta ) {
                                return '<img src="img/cuadros/' + data + '.jpg" style="max-height: 50px" />';
                            },
                            orderable: false
                        },
                        { data: 'name' },
                        { data: 'author' },
                        { data: 'age' },
                        {
                            data: 'description',
                            render: function ( data, type, full, meta ) {
                                return data.length > 40 ?
                                  '<span>'+data.substr( 0, 38 )+'...</span>' :
                                  data;
                            },
                            orderable: false
                        },
                        {
                            render: function ( data, type, full, meta ) {
                                return '<button onclick=\'deleteCuadro(' + full.id + ')\' class="btn btn-danger" />Eliminar</button>';
                            },
                            orderable: false
                        }
                    ]
                });
            });
            
            function deleteCuadro(id)
            {
                $.ajax({
                    url: 'cuadrosController.php',
                    method: 'POST',
                    data: {
                        id: id,
                        action: 'delete'
                    },
                    complete: function ()
                    {
                        oTableCuadros.draw();
                    }
                });
            }
        </script>