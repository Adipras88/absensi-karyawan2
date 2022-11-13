<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthGuard implements FilterInterface
{
    private $roleSession;

    public function before(RequestInterface $request, $arguments = null)
    {
         if (!session()->get('isLoggedIn')){
             return redirect()->to('/login');
         }
         !session()->get('isLoggedIn');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}