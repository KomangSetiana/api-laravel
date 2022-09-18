<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anggota;
use Illuminate\Support\Facades\Storage;


class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anggota = Anggota::all();

        return $this->sendResponse($anggota, 'sukses menampilkan data');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'name' => 'required',
            'nik' => 'required',
            'alamat' => '',
            'image' => 'image',
            'telp' => '',
            'tabungan_id' => 'required'
        ]);

        if ($request->file('image')) {
            $validasi['image'] = $request->file('image')->store('anggota-images');
        }

        $data =   Anggota::create($validasi);

        return $this->sendResponse($data, 'sukses');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Anggota::where('id', $id)->get();

        if ($data) {
            return $this->sendResponse($data, 'Show sukses');
        } else {
            abort(404, 'data not found');
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $rules = [
            'name' => 'required',
            'nik' => '',
            'alamat' => '',
            'image' => 'image',
            'telp' => '',
            'tabungan_id' => ''
        ];


        $validateData = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->image) {
                Storage::delete($request->image);
            }
            $validateData['image'] = $request->file('image')->store('anggota-images');
        }







        Anggota::where('id', $id)->update($validateData);




        return $this->sendResponse($validateData, 'sukses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $anggota = Anggota::where('id', $id);

        $data = $anggota->delete();

        if ($data) {
            return $this->sendResponse($data, 'Sukses delete');
        } else {
            abort(404, 'data not found');
        }
    }
}
