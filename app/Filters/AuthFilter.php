<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
	public function before(RequestInterface $request, $arguments = null)
	{
		// If user is not logged in, redirect to login page
		if (!session()->get('logged_in')) {
			return redirect()->to('/login');
		}
	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		// Do nothing here
	}
}
