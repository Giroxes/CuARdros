<?php

include 'Classes/medoo.php';
include 'Classes/Cuadro.php';

if ($_REQUEST['action']  == 'delete')
    Cuadro::delete ($database, $_REQUEST['id']);

elseif ($_REQUEST['action']  == 'search')
    echo Cuadro::search($database, $_REQUEST['draw'], $_REQUEST['search'], $_REQUEST['columns'][$_REQUEST['order'][0]['column']]['data'], $_REQUEST['order'][0]['dir'], $_REQUEST['start'], $_REQUEST['length']);

elseif ($_REQUEST['action']  == 'add')
    Cuadro::add($database, $_REQUEST['name'], $_REQUEST['author'], $_REQUEST['age'], $_REQUEST['description'], $_FILES['img']);

elseif ($_REQUEST['action']  == 'info')
    echo Cuadro::getModalInfoById($database, $_REQUEST['id']);

else
    header("Location:index.php");