<?php

namespace App\Http\Controllers;
use App\Models\MuridTelegramKontak;
use Illuminate\Http\Request;


class MuridTelegramKontakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'student_nisn' => 'required',
        'nama' => 'required',
        'chat_id' => 'required',
    ]);

    $data = MuridTelegramKontak::create($request->all());

    return response()->json([
        'message' => 'Berhasil tambah kontak',
        'data' => $data
    ]);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
