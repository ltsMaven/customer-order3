<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // 1) Ensure the user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        // 2) (Optional) Load any models/helpers/libraries you need
        //    $this->load->model('Order_model');
    }

    /**
     * Show the welcome dashboard.
     */
    public function index()
    {
        // Pass the username (or any other data) into the view
        $data = [
            'username' => $this->session->userdata('username'),
            'first_name' => $this->session->userdata('first_name'),
            'last_name' => $this->session->userdata('last_name'),
        ];

        // Load the view (application/views/dashboard/index.php)
        $this->load->view('dashboard_page', $data);
    }
}
