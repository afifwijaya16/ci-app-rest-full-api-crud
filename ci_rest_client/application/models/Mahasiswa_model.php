<?php 

use GuzzleHttp\Client;

class Mahasiswa_model extends CI_model {
    
    private $_client;

    public function __construct() {
      $this->_client = new Client([
          'base_uri' => 'http://localhost/CI_Rest_Server/api/',
          'auth' => ['admin', '1234']
      ]);


    }
    public function getAllMahasiswa()
    {
        // return $this->db->get('mahasiswa')->result_array();

        $response = $this->_client->request('GET', 'Mahasiswa', [
            'query' => [
                'X-API-KEY' => 'belajar_rest'
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return $result['data'];
    }

    public function getMahasiswaById($id)
    {
        $client = new Client();

        $response = $this->_client->request('GET', 'Mahasiswa', [
            'query' => [
                'X-API-KEY' => 'belajar_rest',
                'id' => $id
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return $result['data'] [0];
    }

    public function tambahDataMahasiswa()
    {
        $data = [
            "nama" => $this->input->post('nama', true),
            "nrp" => $this->input->post('nrp', true),
            "email" => $this->input->post('email', true),
            "jurusan" => $this->input->post('jurusan', true),
            'X-API-KEY' => 'belajar_rest'
        ];

        // $this->db->insert('mahasiswa', $data);

        $response = $this->_client->request('POST', 'Mahasiswa', [
            'form_params' => $data
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return $result;
    }

    public function hapusDataMahasiswa($id)
    {
        // $this->db->where('id', $id);
        // $this->db->delete('mahasiswa', ['id' => $id]);

        $response = $this->_client->request('DELETE', 'Mahasiswa' , [
            'form_params' => [
                'X-API-KEY' => 'belajar_rest',
                'id' => $id
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return $result;
    }

    public function ubahDataMahasiswa()
    {
        $data = [
            "nama" => $this->input->post('nama', true),
            "nrp" => $this->input->post('nrp', true),
            "email" => $this->input->post('email', true),
            "jurusan" => $this->input->post('jurusan', true),
            "id" => $this->input->post('id', true),  
            'X-API-KEY' => 'belajar_rest'
        ];

        // $this->db->where('id', $this->input->post('id'));
        // $this->db->update('mahasiswa', $data);

        $response = $this->_client->request('PUT', 'Mahasiswa', [
            'form_params' => $data, 
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return $result;
    }

    public function cariDataMahasiswa()
    {
        $keyword = $this->input->post('keyword', true);
        $this->db->like('nama', $keyword);
        $this->db->or_like('jurusan', $keyword);
        $this->db->or_like('nrp', $keyword);
        $this->db->or_like('email', $keyword);
        return $this->db->get('mahasiswa')->result_array();
    }
}