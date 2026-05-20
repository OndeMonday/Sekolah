<?php

namespace App\Interfaces;

interface SubmissionInterface
{
    public function create(array $data);

    public function update(string $id, array $data, int $diri);

    public function approve(string $id, array $data);

    public function getByTaskId(string $id);

    public function findbyids($teacher,string $TaskId);
}