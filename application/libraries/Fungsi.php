<?php 

Class Fungsi {

    protected $ci;

    public function __construct() {
        $this->ci =& get_instance();
    }


    public function count_sepatu()
    {
        $this->ci->load->model('Base_model', 'base');
        // return $data['barang'] = $this->base->get('barang')->num_rows();
        return $this->ci->base->get('barang')->num_rows();
    }

    public function count_user()
    {
        $this->ci->load->model('Base_model', 'base');
        return $this->ci->base->get('user')->num_rows();
    }
    // $data['users'] = $this->base->getUsers()

    public function count_transaksiDays()
    {
        $this->ci->load->model('Base_model', 'base');
        return $this->ci->base->getDay()->num_rows();
    }

    public function count_transaksiTotal()
    {
        $this->ci->load->model('Base_model', 'base');
        return $this->ci->base->joinBarang()->num_rows();
    }
}