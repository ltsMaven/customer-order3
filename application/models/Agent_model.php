<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Agent_model extends CI_Model
{
    public function get_by_username($username)
    {
        return $this->db
            ->where('username', $username)
            ->get('orders')
            ->row();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('orders')
            ->row();
    }

    public function count_all()
    {
        return $this->db
            ->from('orders')
            ->where('role', 'agent')
            ->count_all_results();
    }
}