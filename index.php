<!DOCTYPE html>
<html>
    <head>
        <title>CuARdros</title>
        <meta charset="UTF-8">
        <script src="//code.jquery.com/jquery.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="assets/magi.js"></script>
        <script src="assets/utils.js"></script>
        <script src="assets/JSARToolKit.js"></script>
        <script src="js/photos.js"></script>
        <script src="js/pitagoras.js"></script>
        <!--<script src="js/video.js"></script>-->   
        <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.11.4/themes/black-tie/jquery-ui.css"/>
        <script type="text/javascript" src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <meta content='initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <style>
            #infoButtons{
                position: absolute;
                z-index: 1;
                margin-top: 1%;
            }
            
            #infoButtons ul{
                list-style: none;
            }
            
            #infoButtons li{
                margin-bottom: 1%
            }
            
            #infoButtons img{
                border: 2px white;
            }
            
            #welcome{
                background-color: #99ccff;
                position: absolute;
                width: 100%;
                height: 100%;
                z-index: 1;
                text-align: center;
                padding-top: 10%
            }
        </style>
    </head>
    <body>
        <div id="cuadros" data-slick='{"slidesToShow": 3, "slidesToScroll": 3, "arrows": false, "focusOnSelect": true, "variableWidth": true}'>
        </div>
        
        <div id="welcome">
            <h1>Bienvenido a CuARdros</h1>
            <button id="closeWelcome" class="btn btn-danger" onclick="$('#welcome').hide(); $.getScript('js/video.js', function(){})" type="submit">Empezar a disfrutar del arte!!</button>
        </div>        
        
        <script>
            var cuadros = null;            
            var cuadros2 = null;
            $.ajax({
                url: 'patternsController.php',
                dataType : "json",
                method: 'POST',
                data: {
                    action: 'getJson'
                },
                success: function (result)
                {
                    cuadros2 = result;
                }
            });
        </script>
        <?php include 'Views/_cuadroInfoModal.php' ?>
        <div id="infoButtons">
            <ul></ul>
        </div>
    </body>
</html>