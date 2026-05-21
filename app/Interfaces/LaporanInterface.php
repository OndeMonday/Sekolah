<?php

namespace App\Interfaces;

interface LaporanInterface
{
public function create(array $data,string $pelapor);

public function update(string $id, array $laporanData);

public function delete(string $id);

public function get();

public function satu(string $laporanid);

public function laporanorang( string $userid, ?string $search = null);

public function jenislaporan(string $pelanggaranid,?string $search=null);

public function active(string $data);

public function laporansemua(?string $search = null);

public function pelanggaransaya(string $userid,);

public function nilai(string $laporanid,array $data);
}