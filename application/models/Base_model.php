<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Base_model extends CI_Model
{

    public function getUser($table, $data = null, $where = null)
    {
        if ($data != null) {
            return $this->db->get_where($table, $data)->row_array();
        } else {
            return $this->db->get_where($table, $where)->result_array();
        }
    }

    public function joinCategory($order,$where){
        $this->db->select('*');
        $this->db->from('cash_balance');
        $this->db->join('categori','categori.id_categori = cash_balance.category');
        $this->db->order_by($order, 'DESC');   
        $this->db->where($where);   
        $query = $this->db->get();
        return $query;
     }

     public function joinCategory2($order, $where, $range = null){
        $this->db->select('*');
        $this->db->from('cash_balance');
        $this->db->join('categori','categori.id_categori = cash_balance.category');
        $this->db->join('user','user.id_user = cash_balance.id_user');
        $this->db->order_by($order, 'DESC');   
        $this->db->where($where);   

        if ($range != null) {
            $this->db->where('date' . ' >=', $range['mulai']);
            $this->db->where('date' . ' <=', $range['akhir']);
        }
        // return $this->db->get('barang_masuk bm')->result_array();
        $query = $this->db->get()->result_array();
        return $query;
     }

    public function getUsers($id)
    {
        /**
         * ID disini adalah untuk data yang tidak ingin ditampilkan. 
         * Maksud saya disini adalah 
         * tidak ingin menampilkan data user yang digunakan, 
         * pada managemen data user
         */
        $this->db->where('id_user !=', $id);
        return $this->db->get('user')->result_array();
    }

    public function get($table)
    {
        // $this->db->order_by($order);
        $sql = $this->db->get($table);
        return $sql;
    }

    public function getTotal()
    {
        $login = $this->session->userdata('id_user');
        $this->db->select('*');
        $this->db->from('cash_balance');
        // $this->db->where('id_user', $login);
        $query = $this->db->get();
        return $query;
    }

    public function getCash($table, $order , $where)
    {
       // $tanggal = date('Y-m-d');
       $this->db->select('*');
       $this->db->from($table);
       $this->db->where($where);
       $this->db->order_by($order, 'DESC');
       $query = $this->db->get();
       return $query;
    }

    public function get_uang($table, $order , $where)
    {
        // $tanggal = date('Y-m-d');
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($order, 'DESC');
        $this->db->limit(5);
        $query = $this->db->get();
        return $query;
    }

    public function get_max_id($table, $field, $where)
    {
        $this->db->select_max($field);
        $this->db->where($where);
        $sql = $this->db->get($table);
        return $sql;
    }
    public function get_group_id($table, $group_by)
    {
        $this->db->group_by($group_by);
        $this->db->order_by($group_by . " DESC");
        $sql = $this->db->get($table);
        return $sql;
    }
    public function add($table, $data)
    {
        $this->db->insert($table, $data);
    }
    public function del($table, $where)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
    public function edit($table, $data, $where)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }
    public function get_join()
    {
        $this->db->select('*');
        $this->db->from('cash_balance');
        $this->db->join('user', 'user.id_user = cash_balance.id_user');
        // $this->db->order_by($order, $az);
        $sql = $this->db->get();
        return $sql;
    }
    public function get_join2()
    {
        $login = $this->session->userdata('id_user');
        $this->db->select('user.id, onlineform.date, onlineform.day, onlineform.in1, 
        onlineform.out1, onlineform.in2, onlineform.out2');
        $this->db->from('user');
        $this->db->join('cash_balance', 'cash_balace.id = user.id');
        $this->db->where('id_user', $login);
        // $this->db->order_by($order, $az);
        $sql = $this->db->get();
        return $sql;
    }
    public function join_multiple($table, $join, $pq, $join1, $pq1, $order, $az)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join($join, $pq);
        $this->db->join($join1, $pq1);
        $this->db->order_by($order, $az);
        $sql = $this->db->get();
        return $sql;
    }
    public function get_id($table, $where)
    {
        $this->db->where($where);
        $sql = $this->db->get($table);
        return $sql;
    }
    public function fetch_data($table, $field, $num, $offset)
    {
        empty($offset) ? $offset = 0 : $offset;

        $this->db->query("SET @no=" . $offset);
        $this->db->select('*,(@no:=@no+1) AS nomor');
        $this->db->group_by($field);
        $this->db->order_by($field, 'DESC');

        $data = $this->db->get($table, $num, $offset);

        return $data->result();
    }

    public function update($table, $pk, $id, $data)
    {
        $this->db->where($pk, $id);
        return $this->db->update($table, $data);
    }

    public function insert($table, $data, $batch = false)
    {
        return $batch ? $this->db->insert_batch($table, $data) : $this->db->insert($table, $data);
    }

    public function delete($table, $pk, $id)
    {
        return $this->db->delete($table, [$pk => $id]);
    }
}
