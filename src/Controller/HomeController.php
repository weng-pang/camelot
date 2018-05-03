<?php
namespace App\Controller;

class HomeController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Articles');
    }


    public function isAuthorized() {
        return true;
    }

    public function index()
    {
        $this->loadComponent('Paginator');
        $articles = $this->Paginator->paginate($this->Articles->find());
        $this->set(compact('articles'));
    }

}