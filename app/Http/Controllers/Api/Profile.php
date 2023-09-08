<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Profile extends Controller
{
    private array $update_fields = ['first_name', 'other_names', 'name', 'phone', 'address', 'avatar'];

    public function index(Request $request)
    {
        return MyResponse::success('Profile fetched', $request->user()->only($this->update_fields));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'string',
            'other_names' => 'string',
            'phone' => 'digits_between:11,15',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|max:2000'
        ]);

        $request->user()->update($data);

        return MyResponse::success('Profile updated', $request->user()->only($this->update_fields));
    }
}
