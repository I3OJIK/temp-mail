<?php

namespace App\Http\Controllers;
use App\Services\EmailGeneratorService;

class Controller
{
    public function __construct(
        private EmailGeneratorService $emailGenerator,
    ) 
    {}

    public function index()
    {
        $email = $this->emailGenerator->create();
        dd($email->email);
    }
}
