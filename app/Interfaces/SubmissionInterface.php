<?php

namespace App\Interfaces;

interface SubmissionInterface
{
    public function create(array $data);

    public function update(int $id, array $data);

    public function approve(int $id, array $data);

    public function getByTaskId($taskId);
}