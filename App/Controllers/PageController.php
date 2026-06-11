<?php
namespace App\Controllers;

use App\Core\Controller;

class PageController extends Controller {
    public function home() {
        $this->view('pages/home', ['title' => 'Início']);
    }

    public function sobre() {
        $this->view('pages/sobre', ['title' => 'Sobre Nós']);
    }

    public function contato() {
        $this->view('pages/contato', ['title' => 'Contato']);
    }
}
