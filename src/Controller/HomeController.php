<?php
namespace App\Controller;

class HomeController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Articles');
        $this->Auth->allow(['index']);
    }


    public function isAuthorized() {
        return true;
    }

    public function index()
    {
        $this->loadComponent('Paginator');
        $articles = $this->Paginator->paginate(
            $this->Articles->find()->where(['published' => true, 'archived' => false]), [
                'limit' => 4,
                'order' => [
                    'Articles.created' => 'DESC',
                ]
            ]
        );
        $this->set(compact('articles'));
    }

}
