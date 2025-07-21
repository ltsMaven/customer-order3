<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // only allow logged-in admins
        if (
            !$this->session->userdata('logged_in')
            || $this->session->userdata('role') !== 'admin'
        ) {
            redirect('login');
        }
        // load any models you need
        $this->load->model('Order_model');
        $this->load->model('Agent_model');
    }

    public function index()
    {
        // gather whatever stats you like
        $data = [
            'first_name' => $this->session->userdata('first_name'),
            'total_orders' => $this->Order_model->count_all(),
            'total_agents' => $this->Agent_model->count_all(),
        ];

        // render
        // $this->load->view('partials/header', $data);
        // $this->load->view('partials/sidebar', $data);
        $this->load->view('admin/admin_dashboard_page', $data);
        // $this->load->view('partials/footer', $data);
    }
}
