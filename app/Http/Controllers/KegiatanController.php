<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Program;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $master_kegiatan = Kegiatan::all();

        return view('master_kegiatan.kegiatan', [
            'master_kegiatan' => $master_kegiatan
        ]);
    }

    public function getKegiatan(Request $request)
    {
        $program = $request->get('program');
        $master_kegiatan = Kegiatan::where('nama_program', $program)->get();
        return response()->json($master_kegiatan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tahun = Program::all()->pluck('tahun')->unique();
        $program = Program::all();
        return view('master_kegiatan.create_kegiatan')
            ->with('url_form', url('/kegiatan'))
            ->with('tahun', $tahun)
            ->with('program', $program);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'program' => 'required',
            'rekening_kegiatan' => 'required|string|max:20',
            'nama_kegiatan' => 'required|string|max:20',
        ]);

        $insert = new Kegiatan();
        $insert->program_id = $request->program;
        $insert->no_rekening = $request->rekening_kegiatan;
        $insert->nama_kegiatan = $request->nama_kegiatan;
        $insert->save();

        if ($insert) {
            return redirect('kegiatan')->with('success', 'Data Berhasil Ditambahkan');
        } else {
            return back()->with('error', 'Data Gagal Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $program = Program::all();
        $master_kegiatan = Kegiatan::where('id', $id)->first();

        return view('master_kegiatan.create_kegiatan')
            ->with('url_form', url('/kegiatan' . $id))
            ->with('master_kegiatan', $master_kegiatan)
            ->with('program', $program);
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
        $request->validate([
            'program' => 'required',
            'no_rekening' => 'required|string|max:20',
            'nama_kegiatan' => 'required|string|max:20',
        ]);

        $cariProgram = Program::where('id', $request->program)->first();

        $update = Kegiatan::where('id', $id)->update([
            'rekening_program' => $cariProgram->no_rekening,
            'nama_program' => $cariProgram->nama_program,
            'rekening_kegiatan' => $request->rekening_kegiatan,
            'nama_kegiatan' => $request->nama_kegiatan
            
        ]);

        if ($update) {
            return redirect('master_kegiatan')->with('success', 'Data Berhasil Ditambahkan');
        } else {
            return back()->with('error', 'Data Gagal Ditambahkan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Kegiatan::where('id', '=', $id)->delete();
        return redirect('master_kegiatan')
            ->with('success', 'data Berhasil Dihapus');
    }
}