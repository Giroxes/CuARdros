<?php

/**
 * Description of Cuadros
 *
 * @author Sergio
 */

class Cuadro {
    public static function add($db, $name, $author, $age, $description, $img)
    {
        if (!is_null($name) && !is_null($author) && !is_null($age) && !is_null($description) && !is_null($img))
        {
            $last_id = $db->insert("cuadros", [
                "name"        => $name,
                "author"      => $author,
                "age"         => $age,
                "description" => $description
            ]);
            move_uploaded_file($img["tmp_name"], "img\\cuadros\\$last_id.jpg");
            $result = true;
        }
        else
        {
            $result = false;
        }
        return $result;
    }
    
    public static function delete($db, $id)
    {
        if (!is_null($id))
        {
            $db->delete("cuadros", [
                "id" => $id
            ]);
            
            $db->update("patternconfig", [
                    "cuadroId" => null
                ], [
                    "cuadroId" => $id
            ]);
            
            $file = "..\\img\\cuadros\\$id.jpg";
            if (file_exists($file)) 
                unlink($file);
            
            $result = true;
        }
        else
        {
            $result = false;
        }
        return $result;
    }
    
    public static function search($db, $draw, $search, $column, $dirLow, $start = 0, $length = 10) 
    {
        $dir = strtoupper($dirLow);
        $where = $search['value'] != "" ? [
                "AND" => [
                    "OR" => [
                        "name[~]" => $search,
                        "author[~]" => $search,
                        "age[~]" => $search,
                        "description[~]" => $search
                    ]
                ],
                "LIMIT" => [$start, $length],
                "ORDER" => "$column $dir"
            ]
        :
            [
                "LIMIT" => [$start, $length],
                "ORDER" => "$column $dir"
            ];        
        
        $data = $db->select("cuadros", [
                "name",
                "author",
                "id",
                "description",
                "age"
            ],
            $where
        );

        $total = $db->count('cuadros');
        $cuadros = [
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $total,
            "data" => $data
        ];

        return json_encode($cuadros);
    }
    
    public static function getModalInfoById($db, $id) 
    {
        $data = $db->select("cuadros", [
                "name",
                "author",
                "id",
                "description",
                "age"
            ],
            [
                "id" => $id
            ]
        );
        
        $name = $data[0]['name'];
        $author = $data[0]['author'];
        $description = $data[0]['description'];
        $age = $data[0]['age'];

        return
        "<div class='thumbnail'>
            <img id='img' src='img/cuadros/$id.jpg' alt='' style='max-width: 25%; float: left;'/>
            <div class='caption'>
                <h2 id='name'>$name</h2>
                <h3 id='author'>$author</h3>
                <h3 id='age'>$age</h3>
                <p id='description'>$description</p>
                <p><button id='btnCloseCuadroInfo' href='#' class='btn btn-primary' role='button' onclick=\"$('#dialogCuadroInfoModal').dialog('close');\">Cerrar</button></p>
            </div>
        </div>";
    }
}