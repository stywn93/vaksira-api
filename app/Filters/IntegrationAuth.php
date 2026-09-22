<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class IntegrationAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $expected = env('INTEGRATION_API_KEY');
        $header = $request->getHeaderLine('Authorization');

        if (! $expected) {
            log_message('critical', 'INTEGRATION_API_KEY belum dikonfigurasi.');

            return service('response')
                ->setStatusCode(ResponseInterface::HTTP_SERVICE_UNAVAILABLE)
                ->setJSON(['status' => 'error', 'message' => 'Integrasi belum tersedia.']);
        }

        if (! preg_match('/^Bearer\s+(.+)$/i', $header, $matches)
            || ! hash_equals($expected, $matches[1])) {
            return service('response')
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)
                ->setHeader('WWW-Authenticate', 'Bearer')
                ->setJSON(['status' => 'error', 'message' => 'Unauthorized.']);
        }

        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return $response;
    }
}
