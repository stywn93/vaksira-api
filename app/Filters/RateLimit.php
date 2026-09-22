<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RateLimit implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        [$capacity, $seconds] = array_map('intval', $arguments ?: [60, 60]);
        $key = hash('sha256', $request->getIPAddress() . '|' . $request->getUri()->getPath());
        $throttler = service('throttler');

        if ($throttler->check($key, max(1, $capacity), max(1, $seconds), 1)) {
            return $request;
        }

        return service('response')
            ->setStatusCode(ResponseInterface::HTTP_TOO_MANY_REQUESTS)
            ->setHeader('Retry-After', (string) $throttler->getTokenTime())
            ->setJSON([
                'status'  => 'error',
                'message' => 'Terlalu banyak permintaan. Coba lagi nanti.',
            ]);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return $response;
    }
}
