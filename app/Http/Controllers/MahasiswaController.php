<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::all();
        return view('mahasiswa.index', ['mahasiswas' => $mahasiswas]);
    }

    public function show(Mahasiswa $mahasiswa)
    {
        // dd($mahasiswa);
        return view('mahasiswa.show', ['mahasiswa' => $mahasiswa]);
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store (Request $request)
    {
        $validatedata= $request->validate([
            'nim'            => 'required|size:8|unique:mahasiswas',
            'nama'           => 'required|min:3|max:50',
            'jenis_kelamin'  => 'required|in:P,L',
            'jurusan'        => 'required',
            'alamat'         => '',
        ]);

        Mahasiswa::create($validatedata);
        // return view('mahasiswa.create');

        $request->session()->flash('pesan', "Penambahan data {$validatedata['nama']} berhasil!");
        return redirect()->route('mahasiswas.index');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', ['mahasiswa' => $mahasiswa]);
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
{
    $validatedata = $request->validate([
        'nim'            => 'required|size:8|unique:mahasiswas,nim,' .$mahasiswa->id,
        'nama'           => 'required|min:3|max:50',
        'jenis_kelamin' => 'required|in:P,L',
        'jurusan'        => 'required',
        'alamat'         => '',
    ]);

    // Corrected line: Use the update method directly on the $mahasiswa instance
    $mahasiswa->update($validatedata);

    return redirect()->route('mahasiswas.show', ['mahasiswa'=>$mahasiswa->id])
    ->with('pesan', "Update data {$validatedata['nama']} berhasil!");
}

    
    public function destroy (Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
            return redirect()->route('mahasiswas.index')
            ->with('pesan', "Hapus data $mahasiswa->nama berhasil!");
    }
}
