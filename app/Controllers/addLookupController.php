<?php namespace App\Controllers;

use App\Models\subjekFailAmModel;
use App\Models\lokasiModel;
use App\Models\peminjamModel;
use App\Models\bhgnCwgnModel;

class addLookupController extends BaseController{
    public function addSubjek()
    {
        return view('/addLookup/addSubjek');
    }

    public function storeSubjek()
    {
        $subjekFailAmModel = new subjekFailAmModel();
        $data = [
            'ABJAD'=> $this->request->getPost('ABJAD') ?: NULL,
            'KodSubjek'=> $this->request->getPost('KodSubjek') ?: NULL,
            'SUBJEK'=> $this->request->getPost('SUBJEK') ?: NULL,
        ];
        $subjekFailAmModel->save($data);
        return redirect()->to('/addLookup/addSubjek')->with('status', 'Subjek berjaya ditambah');
    }

    public function addLokasi()
    {
        return view('/addLookup/addLokasi');
    }

    public function storeLokasi()
    {
        $lokasiModel = new lokasiModel();
        $data = [
            'Lokasi_Fail'=> $this->request->getPost('Lokasi_Fail') ?: NULL,
        ];
        $lokasiModel->save($data);
        return redirect()->to('/addLookup/addLokasi')->with('status', 'Lokasi fail berjaya ditambah');
    }

    public function addPeminjam()
    {
        return view('/addLookup/addPeminjam');
    }

    public function storePeminjam()
    {
        $peminjamModel = new peminjamModel();
        $data = [
            'user'=> $this->request->getPost('user') ?: NULL,
            'phone'=> $this->request->getPost('phone') ?: NULL,
            'email'=> $this->request->getPost('email') ?: NULL,
        ];
        $peminjamModel->save($data);
        return redirect()->to('/addLookup/tablePeminjam')->with('statusindexpeminjam', 'Peminjam berjaya ditambah');
    }

    public function tablePeminjam()
    {
        $peminjamModel = new peminjamModel();
        $data['peminjam'] = $peminjamModel->findAll();
        return view('/addLookup/tablePeminjam', $data);
    }

    public function editPeminjam($id)
    {
        $peminjamModel = new peminjamModel();
        $data['peminjam'] = $peminjamModel->find($id);
        return view('/addLookup/editPeminjam', $data);
    }

    public function updatePeminjam($id)
    {
        $peminjamModel = new peminjamModel();
        $data = [
            'user' => $this->request->getPost('user'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
        ];
        $peminjamModel->update($id, $data);
        return redirect()->to(base_url('/addLookup/tablePeminjam'))->with('statusindexpeminjam', 'Peminjam berjaya dikemaskini!');
    }

    public function deletePeminjam($id)
    {
        $peminjamModel = new peminjamModel();
        $peminjamModel->delete($id);
        return;
    }

    public function addBhgnCwgn()
    {
        return view('/addLookup/addBhgnCwgn');
    }

    public function storeBhgnCwgn()
    {
        $bhgnCwgnModel = new bhgnCwgnModel();
        $data = [
            'Bhgn_cwgn'=> $this->request->getPost('Bhgn_cwgn') ?: NULL,
        ];
        $bhgnCwgnModel->save($data);
        return redirect()->to('/addLookup/addBhgnCwgn')->with('status', 'Bahagian / Cawangan berjaya ditambah');
    }
}
?>