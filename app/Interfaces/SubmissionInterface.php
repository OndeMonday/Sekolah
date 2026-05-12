<?php

namespace App\Interfaces;

interface SubmissionInterface
{
    public function create(array $data);

    public function update(int $id, array $data, int $diri);

    public function approve(int $id, array $data);

    public function getByTaskId($id);
}