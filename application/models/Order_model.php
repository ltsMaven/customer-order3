<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    //ini buat registrasi nanti
    public function insert_customer_info(array $data)
    {
        if (!$this->db->insert('orders', $data)) {
            // log the error so it appears in application/logs/
            log_message('error', 'orders insert failed: ' . print_r($this->db->error(), true));
            return false;
        }
        return $this->db->insert_id();
    }



    //insert order item to the temp array
    public function insert_order_item(int $order_id, array $item): int
    {

        $data = [
            'order_id' => $order_id,
            'tate_yoko' => $item['tate_yoko'],
            'ikatan' => $item['ikatan'],
            'satuan' => $item['satuan'],
            'description' => $item['description'],
            'size' => $item['size'],
            'width' => $item['width'],
            'length' => $item['length'],
            'satuan_panjang' => $item['satuan_panjang'],
            'color' => $item['color'],
            // our table calls this column `pieces`, but your form field is `jumlah`
            'pieces' => $item['jumlah'],
            'visible' => 0,          // default “not yet finalized”
        ];

        $this->db->insert('order_items', $data);
        return $this->db->insert_id();
    }
    public function get_order_by_id(int $orderId)
    {
        return $this->db
            ->where('id', $orderId)
            ->get('orders')
            ->row_array();
    }
    public function count_all()
    {
        return $this->db
            ->from('order_items')
            ->where('visible', 1)
            ->count_all_results();
    }

    public function get_all_orders()
    {
        return $this->db->get('orders')->result_array();
    }

    /** fetch items for a given order ID */
    public function get_items_by_order($orderId)
    {
        return $this->db
            ->where('order_id', $orderId)
            ->get('order_items')
            ->result_array();
    }
    public function get_items_by_order_admin($orderId)
    {
        return $this->db
            ->where('order_id', $orderId)
            ->where('visible !=', 0)
            ->get('order_items')
            ->result_array();
    }


    public function get_items_status_by_order_admin(int $orderId): array
{
    return $this->db
        ->select('oi.*, s.expected_time, s.reject_reason')
        ->from('order_items AS oi')
        ->join('item_status AS s', 's.item_id = oi.id', 'left')
        ->where('oi.order_id', $orderId)
        ->get()
        ->result_array();
}

    public function get_unfinalized_items(int $orderId)
    {
        return $this->db
            ->where('order_id', $orderId)
            ->where('visible', 0)
            ->get('order_items')
            ->result_array();
    }

    public function delete_order_by_id(int $itemId)
    {
        return (bool) $this->db
            ->where('id', $itemId)
            ->delete('order_items');
    }

    public function update_order_item(int $itemId, array $fields): bool
    {
        return (bool) $this->db
            ->where('id', $itemId)
            ->update('order_items', $fields);
    }



    //admin
    protected function record_item_status(int $itemId, int $status, ?string $expectedTime = null, ?string $reason = null): bool
    {
        $data = [
            'item_id' => $itemId,
            'visible' => $status,
            'expected_time' => $expectedTime,
            'reject_reason' => $reason,
            // `created_at` will default to CURRENT_TIMESTAMP
        ];

        $this->db->insert('item_status', $data);
        return $this->db->affected_rows() > 0;
    }


    public function set_item_status(int $itemId, int $status): bool
    {
        $this->db
            ->set('visible', $status)
            ->where('id', $itemId)               // make sure 'id' is the correct PK column
            ->update('order_items');

        return $this->db->affected_rows();
    }

    public function finalize_items($orderId)
    {
        return $this->db
            ->where('order_id', $orderId)
            ->where('visible', 0)
            ->update('order_items', ['visible' => 1]);

    }



    public function approve_item(int $itemId, ?string $expectedTime = null): bool
    {

        if (empty($expectedTime)) {
            return false;
        }
        // 1) update the live flag
        $ok1 = $this->set_item_status($itemId, 3);

        // 2) record the history
        $ok2 = $this->record_item_status($itemId, 3, $expectedTime, null);

        return $ok1 && $ok2;
    }

    /**
     * Reject an item: update both order_items and write item_status.
     */
    public function reject_item(int $itemId, ?string $reason = null): bool
    {
        if (empty(trim($reason))) {
            return false; // guard: must supply a reason
        }
        $ok1 = $this->set_item_status($itemId, 2);
        $ok2 = $this->record_item_status($itemId, 2, null, $reason);

        return $ok1 && $ok2;
    }








}