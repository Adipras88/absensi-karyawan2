<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\QRModel;
use App\Libraries\Ciqrcode;

use function bin2hex;
use function file_exists;
use function mkdir;

class QRServiceController extends BaseController
{

    public function __construct()
    {
        $this->qrModel = new QRModel();
    }

    public function create()
    {
        // Check if qr alredy generate for today
        $today = date('Y-m-d');
        $qrToday =  $this->qrModel->where('DATE(created_at)', $today)->first();

        if ($qrToday) {
            log_message('error', 'Unable to generate QR Code because it was already created for today!');
            $result = "Unable to generate QR Code because it was already created for today!";
        } else {
            $data = $this->gen_uuid();
            $qr = $this->generate_qrcode($data);

            $this->qrModel->insert_data($qr);
            log_message('error', 'Create QR Successfully');
            $result = "Create QR Successfully";
        }
        return $result;
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

    function gen_uuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}
