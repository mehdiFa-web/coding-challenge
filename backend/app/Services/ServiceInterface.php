<?php


namespace App\Services;


interface ServiceInterface
{
    /**
     * @return array
     */
    public function get(): array;

    /**
     * @param array $data
     * @param int $id
     */
    public function update(array $data, int $id);

    /**
     * @param int $id
     */
    public function delete(int $id);

    /**
     * @param array $data
     */
    public function create(array $data);
}
