<?php

class User_model extends CI_Model {

    function submit($table , $data){
        $submit = $this->db->insert($table, $data);
        return $submit;
    }

    function update($table, $data, $where){
        $update = $this->db->update($table, $data, $where);
        return $update;
    } 

    function delete($table, $where){
        $update = $this->db->delete($table, $where);
        return $update;
    } 

    function select($table, $data){
        $select = $this->db->get_where($table, $data)->result();
        return $select;
    }

    function find_all($table, $order_by = '', $sort = ''){
        $query = '';
        if($order_by != ''){
            $query = $table . " ORDER BY ". $order_by . (($sort != '')? " " . $sort: '');
        }else{
            $query = $table;
        }
        $select = $this->db->query("SELECT * FROM $query")->result();
        return $select;
    }
}