<?php namespace App\Controllers;

use App\Models\ResepObatModel;

class ResepObatController extends BaseController
{
    protected $resepObatModel;

    public function __construct()
    {
        $this->resepObatModel = new ResepObatModel();
    }

    public function ResepObat()
    {
        $data['resep_obat'] = $this->resepObatModel->findAll(); // Fetch all prescriptions
        return view('resep_obat/index', $data); // Pass data to view
    }

    public function createResep()
    {
        return view('resep_obat/create');
    }

    public function storeResep()
    {
        $data = [
            'id_obat' => $this->request->getPost('id_obat'),
            'nama_obat' => $this->request->getPost('nama_obat'),
            'jumlah' => $this->request->getPost('jumlah'),
        ];

        $this->resepObatModel->save($data);

        return redirect()->to('/resep_obat');
    }

    public function editResep($id)
    {
        $data['resep_obat'] = $this->resepObatModel->find($id);
        return view('resep_obat/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'id_obat' => $this->request->getPost('id_obat'),
            'nama_obat' => $this->request->getPost('nama_obat'),
            'jumlah' => $this->request->getPost('jumlah'),
        ];

        $this->resepObatModel->update($id, $data);

        return redirect()->to('/resep_obat');
    }

    public function deleteResep($id)
    {
        $this->resepObatModel->delete($id);
        return redirect()->to('/resep_obat');
    }
}
