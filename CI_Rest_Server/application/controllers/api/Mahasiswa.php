<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';
/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Mahasiswa extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mahasiswa_model', 'Model');
        // $this->methods['index_get']['limit'] = 500;
    }

    public function index_get() {

        $id= $this->get('id');

        if ($id === null) {
            $mahasiswa = $this->Model->getMahasiswa();
        } else {
            $mahasiswa = $this->Model->getMahasiswa($id);
        }

        if($mahasiswa) {
            
            $this->response([
                'status' => true,
                'data' => $mahasiswa
            ], REST_Controller::HTTP_OK);

        } else {
            $this->response([
                'status' => false,
                'message' => 'Data Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }


    public function index_delete() {

        $id = $this->delete('id');

        if($id === null) {

            $this->response([
                'status' => false,
                'message' => 'Provide an Id'
            ], REST_Controller::HTTP_BAD_REQUEST);

        } else {

            if($this->Model->deleteMahasiswa($id) > 0) {

                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'Deleted',
                ], REST_Controller::HTTP_OK);

            }
            else {
                $this->response([
                    'status' => false,
                    'message' => 'Id not found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post() {

        $data = [
            'nrp' => $this->post('nrp'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan'),
        ];

        if($this->Model->createMahasiswa($data) > 0 ) {
            $this->response([
                'status' => true,
                'message' => 'New data has been created',
            ], REST_Controller::HTTP_CREATED);
        }
        else {
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put(){
        
        $id = $this->put('id');
        $data = [
            'nrp' => $this->put('nrp'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan'),
        ];

        if($this->Model->updateMahasiswa($data, $id) > 0 ) {
            $this->response([
                'status' => true,
                'message' => 'Data has been updated',
            ], REST_Controller::HTTP_OK);
        }
        else {
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}