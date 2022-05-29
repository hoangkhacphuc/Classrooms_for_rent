<?php
namespace App\Models;

class HomeModel
{
    public $db;
    public $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = session();
    }

    // Kiểm tra quyền Admin
    public function checkAdmin()
    {
        if ($this->session->has('User_ID')) {
            $user_id = $this->session->get('User_ID');
            $query = $this->db->table('customers')
                                ->where(array('id' => $user_id, 'role_id' => '1'))
                                ->get()
                                ->getRowArray();
            if (count($query) > 0) {
                return true;
            }
            return false;
        } else {
            return false;
        }
    }
}