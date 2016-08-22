<!DOCTYPE html>
<html>
    <head>
        <title>CuARdros - Administración</title>
        <meta charset="UTF-8">
        <script src="//code.jquery.com/jquery.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.css"/>
        <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.min.js"></script>
        <meta content='initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css"/>
        <script type="text/javascript" src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>        
        <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.11.4/themes/black-tie/jquery-ui.css"/>
        <script type="text/javascript" src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script type="text/javascript" src="//malsup.github.com/jquery.form.js"></script>
        
        <style>            
            body{
                width: 960px;
                margin: 0px auto;
            }
            .dataTables_wrapper{
                margin-top: 10px
            }
        </style>
        
    </head>
    <body>
        <div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-justified" role="tablist">
                <li role="presentation" class="active"><a href="#Cuadros" aria-controls="Cuadros" role="tab" data-toggle="tab" onclick="oTableCuadros.draw();">Cuadros</a></li>
                <li role="presentation"><a href="#Patrones" aria-controls="Patrones" role="tab" data-toggle="tab" onclick="oTablePatterns.draw();">Patrones</a></li>
                <!--<li role="presentation"><a href="#Usuarios" aria-controls="Usuarios" role="tab" data-toggle="tab">Usuarios</a></li>-->
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="Cuadros">
                    <?php include 'Views/_cuadrosTable.php'; ?>
                    <?php include 'Views/_addCuadroModal.php'; ?>
                </div>
                <div role="tabpanel" class="tab-pane" id="Patrones">
                    <?php include 'Views/_patternTable.php'; ?>
                    <?php include 'Views/_patternConfigModal.php'; ?>
                </div>
                <!--<div role="tabpanel" class="tab-pane" id="Usuarios">...</div>-->
            </div>
        </div>
    </body>
</html>