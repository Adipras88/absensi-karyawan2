<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\QRModel;
use Config\Services;
use App\Libraries\Ciqrcode;

use function bin2hex;
use function file_exists;
use function mkdir;

class QRCodeController extends BaseController
{

    public function __construct()
    {
        $this->qrModel = new QRModel();

        if (session()->get('level') != "admin") {
            echo 'Access denied';
            exit;
        }
    }

    public function index()
    {
        $today = date('Y-m-d');
        $qrs = $this->qrModel->findAll();
        $qrToday =  $this->qrModel->where('DATE(created_at)', $today)->first();
        $data = [
            'page' => 'QR',
            'qr' => $qrs,
            'qrToday' => $qrToday,
            'qrCreated' => $qrToday ? $qrToday['created_at'] : null
        ];

        return view('layouts/pages/admin/qr/index', $data);
    }

    public function create()
    {
        helper(['form']);
        $data = [
            'page' => 'QR',
            'validation' => Services::validation(),
        ];

        echo view('layouts/pages/admin/qr/create', $data);
    }

    public function generate_qrcode($data)
    {
        /* Load QR Code Library */
        // $this->load->library('Ciqrcode');
        $ciqrcode = new Ciqrcode;

        /* Data */
        $hex_data = bin2hex($data);
        $save_name = $hex_data . '.png';

        /* QR Code File Directory Initialize */
        $dir = 'assets/media/qrcode/';
        if (!file_exists($dir)) {
            mkdir($dir, 0775, true);
        }

        /* QR Configuration  */
        $config['cacheable'] = true;
        $config['imagedir'] = $dir;
        $config['quality'] = true;
        $config['size'] = '1024';
        $config['black'] = [255, 255, 255];
        $config['white'] = [255, 255, 255];
        $ciqrcode->initialize($config);

        /* QR Data  */
        $params['data'] = $data;
        $params['level'] = 'L';
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $save_name;

        $ciqrcode->generate($params);

        /* Return Data */
        return [
            'content' => $data,
            'file' => $dir . $save_name,
            'created_at' => date('Y-m-d H:i:s')
        ];
    }

    function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    public function add_data()
    {
        $data = $this->gen_uuid();
        $qr = $this->generate_qrcode($data);

        $this->qrModel->insert_data($qr);
        session()->setFlashdata('success_qr', 'Create QR Successfully.');
        return redirect()->to('/admin/qr');
    }

    public function edit_data($id)
    {
        /* Old QR Data */
        $old_data = $this->qrModel->qrModel($id);
        $old_file = FCPATH . $old_data['file'];

        /* Generate New QR Code */
        $data = $this->input->post('content');
        $qr = $this->generate_qrcode($data);

        /* Edit Data */
        if ($this->qrModel->qrModel($id, $old_file, $qr)) {
            session()->setFlashdata('success_qr', 'Delete QR Successfully.');
        } else {
            session()->setFlashdata('success_qr', 'Try Again!');
        }

        return redirect()->to(site_url('/'));
    }

    public function remove_data($id)
    {
        /* Delete Data */
        if ($this->qrModel->where(['qrId' => $id])->delete()) {
            session()->setFlashdata('success_qr', 'Delete QR Successfully.');
        } else {
            session()->setFlashdata('success_qr', 'Try Again!');
        }

        return redirect()->to(base_url('/admin/qr'));
    }

    protected function modal_feedback($type, $title, $desc, $button): void
    {
        $message = '
            <div id="modalFeedback" class="modal fade">
                <div class="modal-dialog modal-dialog-centered modal-confirm">
                    <div class="modal-content">
            
                        <div class="modal-header-' . $type . '">
                            <div class="icon-box">
                                <i class="material-icons">' . ($type == 'success' ? '&#xE876;' : '&#xE5CD;') . '</i>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        
                        <div class="modal-body text-center">
                            <h4>' . $title . '</h4>	
                            <p>' . $desc . '</p>
                            <button class="btn" data-dismiss="modal">' . $button . '</button>
                        </div>
                        
                    </div>
                </div>
            </div>  
        ';
        $this->session->set_flashdata('modal_message', $message);
    }
}
