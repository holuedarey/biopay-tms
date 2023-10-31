<?php

namespace App\Http\Middleware;

use App\Helpers\MyResponse;
use App\Repository\Teqrypt;
use Closure;
use Illuminate\Http\Request;

class DecodePayload
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            $payload = $request->get('payload');
            $teqrypt = new Teqrypt;

            $data = $teqrypt->decrypt($payload);

            if ( $data['success'] !== true ) {
                return MyResponse::failed('Invalid data');
            }

            $payload = json_decode($data['data']);

            if( !$payload ) {
                return MyResponse::failed('Invalid data');
            }


            $request->merge(collect($payload)->toArray());

            $request->request->remove('payload');
        }

        return $next($request);
    }
}
