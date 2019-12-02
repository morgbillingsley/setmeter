<?php

class Home extends Controller
{
    public function index(string $path)
    {
        return $this->view('home/index.html', [
            'title' => 'Home'
        ]);
    }
}


?>