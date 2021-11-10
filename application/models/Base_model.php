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

    public function joinBarang($where = null)
    {
        if ($where != null) {
            $this->db->select('*');
            $this->db->from('transaksi');
            $this->db->join('barang', 'barang.id_barang = transaksi.id_barang');
            $this->db->where($where);
            $query = $this->db->get();
            return $query;
        } else {
            $this->db->select('*');
            $this->db->from('transaksi');
            $this->db->join('barang', 'barang.id_barang = transaksi.id_barang');
            // $this->db->where($where);
            $query = $this->db->get();
            return $query;
        }
    }

    public function get_join()
    {
        $this->db->select('*');
        $this->db->from('transaksi');
        $this->db->join('barang', 'barang.id_barang = transaksi.id_barang');
        // $this->db->order_by($order, $az);
        $sql = $this->db->get();
        return $sql;
    }

    public function getDay($id = null)
    {
        $nowDate = date('Y-m-d');
        $this->db->select('*');
        $this->db->from('transaksi');
        $this->db->where('tanggal', $nowDate);
        $this->db->join('barang', 'barang.id_barang=transaksi.id_barang');
        $this->db->order_by('id_transaksi', 'DESC');
        if ($id != null) {
            $this->db->where('id_transaksi', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function getUsers()
    {
        /**
         * ID disini adalah untuk data yang tidak ingin ditampilkan. 
         * Maksud saya disini adalah 
         * tidak ingin menampilkan data user yang digunakan, 
         * pada managemen data user
         */
        $this->db->select('*');
        $this->db->from('user');
        // $this->db->where('id_user !=', $id);
        $query = $this->db->get();
        return $query;
    }

    public function get($table)
    {
        // $this->db->order_by($order);
        $sql = $this->db->get($table);
        return $sql;
    }

    public function getBarang($table, $data = null, $where = null)
    {
        if ($data != null) {
            return $this->db->get_where($table, $data)->row_array();
        } else {
            return $this->db->get_where($table, $where)->result_array();
        }
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

    public function cekHarga($id)
    {
        // $this->db->join('satuan s', 'b.satuan_id=s.id_satuan');
        $this->db->select('*');
        $this->db->from('barang');
        $this->db->where(['id_barang' => $id]);
        $query = $this->db->get()->row_array();
        return $query;
    }
}
