<?php
namespace App\Controller;

class AdminController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Articles');
        $this->viewBuilder()->setLayout('admin');
    }

    public function isAuthorized($user)
    {
        // If you are a user, you can access this dashboard.
        return (boolean) $user->id;
    }

    public function index()
    {
        $query = $this->Articles->find();
        $popularArticles = $query->select([
                'id' => 'Articles.id',
                'body' => 'Articles.body',
                'slug' => 'Articles.slug',
                'title' => 'Articles.title',
                'views' => $query->func()->count('ArticleViews.id'),
            ])
            ->innerJoinWith('ArticleViews')
            ->group(['Articles.id'])
            ->order(['views DESC'])
            ->limit(3);

        $this->set(compact('popularArticles'));
    }

}