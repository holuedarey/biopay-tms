<?php

namespace App\Helpers;



use Illuminate\Support\Collection;

class Result
{
    /**
     * @param bool $success
     * @param array|Collection|null $data
     * @param string|null $message
     */
    public function __construct(public bool $success, public array|Collection|null $data = null, public string|null $message = null)
    {
        if (is_array($this->data)) $this->data = collect($this->data);
    }
}
