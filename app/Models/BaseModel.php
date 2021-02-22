<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    private function generateColumns(array $data): string
    {
        $columns = '';
        foreach($data as $key => $value) {
            $columns .= $key.',';
        }
        return rtrim($columns, ',');
    }

    private function generateValues(array $data): string
    {
        $values = '';
        foreach($data as $key => $value) {
            $values .= ':'.$key.':,';
        }
        return rtrim($values, ',');
    }

    /*
     |------------------------
     | Insert Returning
     |----------------------------
     | If insert success, return a value from new data was inserted, ex. id
    */

    public function insertReturning(array $data_insert, string $field_return)//: bool
    {
        $sql = 'INSERT INTO '.$this->table.' ('.$this->generateColumns($data_insert).')
               VALUES ('.$this->generateValues($data_insert).') RETURNING '.$this->db->escapeString($field_return);

        $insert = $this->db->query($sql, $data_insert);
        $this->insert_return = $insert->getRowArray()[$field_return];

        if ($this->insert_return !== null) {
            return true;
        }
        return false;
    }

    public function getInsertReturned(): ? string
    {
        return $this->insert_return??null;
    }
}