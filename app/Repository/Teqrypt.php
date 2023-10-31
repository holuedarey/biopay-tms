<?php

namespace App\Repository;

use Illuminate\Support\Collection;

class Teqrypt
{
    private string $key;
    private string $iv;
    private string $method;


    /**
     * Teqrypt constructor.
     */
    public function __construct()
    {
        $this->key = base64_decode(config('teqrypt.key'));
        $this->iv = base64_decode(config('teqrypt.iv'));
        $this->method = config('teqrypt.method');
    }


    /**
     * Encrypt data
     *
     * @param string|array|Collection $data
     * @return array
     */
    public function encrypt(string|array|Collection $data): array
    {
        if (is_array($data)) {
            $data = json_encode($data);
        }
        else if ($data instanceof Collection) {
            $data = json_encode($data->toArray());
        }

        $encrypted_data = openssl_encrypt($data, $this->method, $this->key, 0, $this->iv);

        if ( !$encrypted_data ) {
            return [
                'success' => false,
                'message' => 'Error with data encryption'
            ];
        }

        return [
            'success'   => true,
            'data'      => $encrypted_data
        ];
    }

    /**
     * Decrypt data
     *
     * @param string $data
     * @return array
     */
    public function decrypt(string $data): array
    {
        $decrypted_data = openssl_decrypt($data, $this->method, $this->key, 0, $this->iv);

        if ( ! $decrypted_data ) {
            return [
                'success' => false,
                'message' => 'Error with data decryption'
            ];
        }

        return [
            'success'   => true,
            'data'      => $decrypted_data
        ];
    }
}
