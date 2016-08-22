<?php

include 'Classes/medoo.php';
include 'Classes/Pattern.php';

if ($_REQUEST['action']  == 'delete')
    Pattern::delete ($database, $_REQUEST['id']);

elseif ($_REQUEST['action']  == 'search')
    echo Pattern::search($database, $_REQUEST['draw'], $_REQUEST['start'], $_REQUEST['length']);

elseif ($_REQUEST['action']  == 'add')
    echo Pattern::add($database);

elseif ($_REQUEST['action']  == 'edit')
    Pattern::edit($database, $_REQUEST['patternId'], $_REQUEST['cuadroId']);

elseif ($_REQUEST['action']  == 'getJson')
    echo Pattern::getJson($database);

else
    header("Location:index.php");