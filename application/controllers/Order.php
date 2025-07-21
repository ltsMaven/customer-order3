<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);

        $this->load->model('Order_model');
        $this->load->helper(['form', 'url']);
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }


    public function index()
    {
        $order_id = $this->session->userdata('id');
        if (!$order_id) {
            show_error('No customer in session', 403);
        }

        $customer = $this->Order_model->get_order_by_id($order_id);
        $items = $this->Order_model->get_unfinalized_items($order_id);

        $this->load->view('order_page', [
            'order_id' => $order_id,
            'customer' => $customer,
            'items' => $items,
            'success' => $this->session->flashdata('success_msg'),
            'error' => $this->session->flashdata('error_msg'),
        ]);
    }


    public function inputValidation()
    {

        $this->form_validation->set_rules(
            'items[0][Tate/Yoko]',
            'Tate/Yoko',
            'required'
        );
        $this->form_validation->set_rules(
            'items[0][ikatan]',
            'Ikatan',
            'required'
        );
        $this->form_validation->set_rules(
            'item_description[]',
            'Jenis Benang',
            'required'
        );
        $this->form_validation->set_rules(
            'item_size[]',
            'Ukuran',
            'required'
        );
        $this->form_validation->set_rules(
            'items[0][satuan]',
            'Satuan',
            'required'
        );
        $this->form_validation->set_rules(
            'item_width[]',
            'Lebar',
            'required'
        );
        $this->form_validation->set_rules(
            'item_length[]',
            'Panjang',
            'required'
        );
        $this->form_validation->set_rules(
            'items[0][satuan_panjang]',
            'Satuan Panjang',
            'required'
        );
        $this->form_validation->set_rules(
            'item_color[]',
            'Warna',
            'required'
        );
        $this->form_validation->set_rules(
            'item_pieces[]',
            'Jumlah',
            'required'
        );
    }

    public function add_item()
    {
        $this->inputValidation();
        // require JSON POST
        $raw = file_get_contents('php://input');
        $post = json_decode($raw, true);

        $order_id = $this->session->userdata('order_id')
            ?: $this->session->userdata('id');
        if (!$order_id || empty($post['item'])) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false]));
        }

        // basic validation (you can expand this)
        $i = $post['item'];
        if (empty($i['description']) || empty($i['jumlah'])) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false]));
        }
        // 2) numeric non-negativity check
        foreach (['size', 'width', 'length', 'jumlah'] as $fld) {
            if (!isset($i[$fld]) || !is_numeric($i[$fld]) || $i[$fld] < 0) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'success' => false,
                        'error' => ucfirst($fld) . ' must be a non-negative number'
                    ]));
            }
        }

        $newId = $this->Order_model->insert_order_item($order_id, $i);
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => true,
                'id' => $newId,
                'description' => $i['description'],
                'jumlah' => $i['jumlah'],
            ]));
    }
    public function delete($itemId)
    {
        // only allow agents who have an active order in session
        $order_id = $this->session->userdata('order_id')
            ?: $this->session->userdata('id');
        if (!$order_id) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'error' => 'no order']));
        }

        $ok = $this->Order_model->delete_order_by_id($itemId);

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => $ok]));
    }


    public function update_item($itemId)
    {
        $order_id = $this->session->userdata('order_id')
            ?: $this->session->userdata('id');
        if (!$order_id) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'error' => 'no order']));
        }

        $input = json_decode(file_get_contents('php://input'), true) ?: [];
        // validate required fields
        foreach (['tate_yoko', 'ikatan', 'description', 'size', 'satuan', 'width', 'length', 'satuan_panjang', 'color', 'jumlah'] as $f) {
            if (empty($input[$f])) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['success' => false, 'error' => "missing {$f}"]));
            }
        }
        // 2) numeric non-negativity check
        foreach (['size', 'width', 'length', 'jumlah'] as $fld) {
            if (!is_numeric($input[$fld]) || $input[$fld] < 0) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'success' => false,
                        'error' => ucfirst($fld) . ' must be a non-negative number'
                    ]));
            }
        }

        $data = [
            'tate_yoko' => $input['tate_yoko'],
            'ikatan' => $input['ikatan'],
            'description' => $input['description'],
            'size' => $input['size'],
            'satuan' => $input['satuan'],
            'width' => $input['width'],
            'length' => $input['length'],
            'satuan_panjang' => $input['satuan_panjang'],
            'color' => $input['color'],
            'pieces' => $input['jumlah'],
        ];

        $ok = $this->Order_model->update_order_item((int) $itemId, $data);
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => $ok]));
    }

    public function finalize_item(int $itemId)
    {
        // ensure agent is logged in
        if (!$this->session->userdata('logged_in')) {
            return redirect('login');
        }

        // set only that one item
        $ok = $this->Order_model->set_item_status($itemId, 1);

        if ($ok) {
            $this->session->set_flashdata('success_msg', 'Item finalized.');
        } else {
            $this->session->set_flashdata('error_msg', 'Could not finalize item.');
        }

        // back to live‐order page
        return redirect('order/live');
    }

    public function live()
    {
        // fetch dropdown data
        $custId = (int) $this->session->userdata('id');
        if (!$custId) {
            // not logged in (or no “id” in session) → send them to login
            return redirect('login');
        }

        // 2) fetch that customer record + their items
        $data['customer'] = $this->Order_model->get_order_by_id($custId);
        $data['items'] = $this->Order_model->get_items_by_order($custId);

        // 3) render
        $this->load->view('live_orders_page', $data);
    }

    public function live_admin()
    {
        // only admins here
        if ($this->session->userdata('role') !== 'admin') {
            show_error('You are not allowed here', 403);
        }

        // GET param for selected customer
        $custId = (int) $this->input->get('existing_order_id', true)
            ?: 0;

        // populate dropdown
        $data['existing'] = $this->Order_model->get_all_orders();

        if ($custId) {
            $data['customer'] = $this->Order_model->get_order_by_id($custId);
            $data['items'] = $this->Order_model->get_items_by_order_admin($custId);
        } else {
            $data['customer'] = null;
            $data['items'] = [];
        }

        $this->load->view('admin/admin_live_orders_page', $data);
    }

    public function approve_item(int $itemId)
    {
        if ($this->session->userdata('role') !== 'admin') {
            show_error('Forbidden', 403);
        }

        $ok = $this->Order_model->approve_item($itemId);
        if (!$ok) {
            $this->session->set_flashdata('error_msg', 'Could not approve item.');
        }
        // redirect back to the admin live‐order page, preserving the customer filter
        $cust = $this->input->get('existing_order_id') ?? '';
        redirect("admin/order/live?existing_order_id={$cust}");
    }

    /**
     * Reject a single order‐item (visible=2)
     */
    public function reject_item(int $itemId)
    {
        if ($this->session->userdata('role') !== 'admin') {
            show_error('Forbidden', 403);
        }

        $ok = $this->Order_model->reject_item($itemId);
        if (!$ok) {
            $this->session->set_flashdata('error_msg', 'Could not reject item.');
        }
        $cust = $this->input->get('existing_order_id') ?? '';
        redirect("admin/order/live?existing_order_id={$cust}");
    }


    /** Flip all items from 0→1 and finish */
    public function submit()
    { {
            $order_id = $this->session->userdata('order_id')
                ?: $this->session->userdata('id');
            if (!$order_id) {
                return redirect('welcome/index');
            }

            $this->Order_model->finalize_items($order_id);
            $this->session->set_flashdata('success_msg', 'Your order has been placed!');
            // clear session so they can start over
            $this->session->unset_userdata(['order_id', 'customer']);
            return redirect('dashboard');
        }
    }

}
