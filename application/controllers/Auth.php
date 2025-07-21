<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Agent_model');
    }

    public function login()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/login');
            return;
        }

        $u = $this->input->post('username', true);
        $p = $this->input->post('password', true);
        $agent = $this->Agent_model->get_by_username($u);

        // TEMPORARY TEST LOGIN: admin/admin works in plain text
        if ($agent && $agent->password === $p) {
            // stash every column you care about
            $sess = [
                'id' => $agent->id,
                'first_name' => $agent->first_name,
                'last_name' => $agent->last_name,
                'role' => $agent->role,
                'phone' => $agent->phone,
                'email' => $agent->email,
                'address' => $agent->address,
                'city' => $agent->city,
                'state' => $agent->state,
                'country' => $agent->country,
                'username' => $agent->username,
                'logged_in' => TRUE,
            ];
            $this->session->set_userdata($sess);

            // 2) redirect based on role
            if ($agent->role === 'admin') {
                redirect('admin/dashboard');
            } else {
                redirect('dashboard');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid login');
            redirect('login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
