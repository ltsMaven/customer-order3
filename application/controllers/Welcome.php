<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{



	private $countries = [
		'' => '.....',
		'Indonesia' => 'Indonesia',
		'Denmark' => 'Denmark',
		'Japan' => 'Japan',
		'Mexico' => 'Mexico',
		'Netherlands' => 'Netherlands',
		'Norway' => 'Norway',
		'Philippines' => 'Philippines',
		'Sweden' => 'Sweden',
		'Thailand' => 'Thailand',
		'UK' => 'UK',
		'USA' => 'USA',
		'Other' => 'Other',
	];



	public function __construct()
	{
		parent::__construct();
		$this->load->library(['form_validation', 'session']);

		$this->load->model('Order_model');
		$this->load->helper(['form', 'url']);
	}
	public function index()
	{
		$data = [
			'countries' => $this->countries,
			'success_msg' => $this->session->flashdata('success_msg'),
			'error_msg' => $this->session->flashdata('error_msg'),
		];
		$this->load->view('welcome_message', $data);
	}

	public function inputValidation()
	{
		$this->form_validation->set_rules('first_name', 'First Name', 'required|alpha');
		$this->form_validation->set_rules(
			'phone',
			'Phone',
			'numeric|min_length[10]',
			[
				'min_length' => 'The {field} must be at least 10 digits.'
			]
		);
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('address', 'Alamat', 'required');
		$this->form_validation->set_rules('city', 'Kota', 'alpha');
		$this->form_validation->set_rules('state', 'Provinsi', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('country', 'Country', 'required');
		$this->form_validation->set_rules(
			'username',
			'Username',
			'required|alpha_numeric|min_length[4]|is_unique[orders.username]',
			['is_unique' => 'This username is already taken.']
		);
		$this->form_validation->set_rules(
			'password',
			'Password',
			'required|min_length[6]',
			['min_length' => 'Password must be at least 6 characters.']
		);
	}

	public function submit()
	{
		// 1) Define all your rules up front
		$this->inputValidation();

		// 2) Run validation _after_ you set the rules
		if (!$this->form_validation->run()) {
			// on failure, store errors and bounce back
			$this->session->set_flashdata('error_msg', validation_errors());
			return redirect('welcome/index');
		}

		// 3) Validation passed → build your payload
		$customer = [
			'first_name' => $this->input->post('first_name', TRUE),
			'last_name' => $this->input->post('last_name', TRUE),
			'phone' => $this->input->post('phone', TRUE),
			'email' => $this->input->post('email', TRUE),
			'address' => $this->input->post('address', TRUE),
			'city' => $this->input->post('city', TRUE),
			'state' => $this->input->post('state', TRUE),
			'country' => $this->input->post('country', TRUE),
			'username' => $this->input->post('username', TRUE),
			'password' => $this->input->post('password', TRUE),
		];

		// 4) Insert into the DB and get the new ID
		$orderId = $this->Order_model->insert_customer_info($customer);

		$this->session->set_userdata('order_id', $orderId);
		$this->session->set_userdata('customer', $customer);
		$this->session->set_flashdata('success_msg', 'Customer saved!');
		return redirect('dashboard');
	}

}
