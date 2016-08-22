<?php

/**
 * Description of Cuadros
 *
 * @author Sergio
 */

class Pattern {
    public static function add($db)
    {
        $minId = $db->query("Select MIN(a.id + 1) From patternconfig A Left Join patternconfig B On A.id = B.Id - 1 Where B.id Is NULL")->fetchAll();
        $id = $minId[0][0] != null ? $minId[0][0] : 1;
        
        $db->insert("patternconfig", [
            "id"       => $id,
            "cuadroId" => 0,
        ]);
        var_dump($minId);
    }
    
    public static function delete($db, $id)
    {
        $db->delete("patternconfig", [
            "id" => $id
        ]);
    }
    
    public static function search($db, $draw, $start = 0, $length = 10) 
    {
        $data = $db->select("patternconfig", [
                "id",
                "cuadroId"
            ],
            [
                "LIMIT" => [$start, $length]
            ]
        );

        $total = $db->count('patternconfig');
        $patterns = [
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $total,
            "data" => $data
        ];

        return json_encode($patterns);
    }
    
    public static function edit($db, $patternId, $cuadroId) 
    {
        $db->update("patternconfig", [
                "cuadroId" => $cuadroId
            ], [
                "id" => $patternId
        ]);
    }
    
    public static function getJson($db) 
    {
        $data = $db->select("patternconfig", [
                "id",
                "cuadroId"
            ]
        );
        
        $json = [];
        
        foreach ($data as $value) {
            $json[$value['id']] = $value['cuadroid'];
        }
        return json_encode($json);
    }
}