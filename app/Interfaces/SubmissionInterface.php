<?php

namespace App\Interfaces;

interface SubmissionInterface
{
    public function create(array $data);

    public function update(string $id, array $data, int $diri);

    public function approve(string $id, array $data);

    public function getByTaskId(string $id);

    public function getAll(string $id);

    public function ceksub();

    Public function taskbyid(string $TaskId,int $diri);

    public function hapussub(int $TaskId,int $diri);

}