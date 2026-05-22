<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Interfaces\MenuInterface;



class MenuRepository implements MenuInterface
{
    protected Menu $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    public function get()
    {
        return $this->menu
        ->latest()
        ->get();
    }

    public function detail(string $id)
    {
        return $this->menu
        ->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->menu
        ->create($data);
    }

    public function update(
        array $data,
        string $id
    ){
        $menu = $this->menu
        ->findOrFail($id);

        $menu->update($data);

        return $menu->fresh();
    }

    public function delete(string $id)
    {
        $menu = $this->menu
        ->findOrFail($id);

        $menu->delete();

        return $menu;
    }
public function tambah(string $menuid, int $stok)
{
    $menu = $this->menu
        ->findOrFail($menuid);

    $menu->increment('stok', $stok);

    return $menu->fresh();
}
}