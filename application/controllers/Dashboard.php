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
        $this->load->model('Order_model');
    }

    /**
     * Show the welcome dashboard.
     */
    public function index()
    {

        $orderId = (int) $this->session->userdata('id');

        // Pass the username (or any other data) into the view

        $data = [

            'username' => $this->session->userdata('username'),
            'first_name' => $this->session->userdata('first_name'),
            'last_name' => $this->session->userdata('last_name'),
            'total_approved' => $this->Order_model->count_order_by_id($orderId, 3),
            'total_reject' => $this->Order_model->count_order_by_id($orderId, 2),
            'total_waiting_to_approve' => $this->Order_model->count_order_by_id($orderId, 1),
            'total_not_finilized' => $this->Order_model->count_order_by_id($orderId, 0),
        ];

        // Load the view (application/views/dashboard/index.php)
        $this->load->view('dashboard_page', $data);
    }
}
