<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;

class CustomerController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('ArticleViews');
        $this->loadModel('Articles');
        $this->viewBuilder()->setLayout('customer');
    }

    public function isAuthorized($user)
    {
        // If you are a user, you can access this dashboard.
        return $this->Auth->user('role') > 0;
    }

    public function index()
    {
        $popularQuery = $this->Articles->find();
        $popularArticles = $popularQuery->select([
            'id' => 'Articles.id',
            'body' => 'Articles.body',
            'slug' => 'Articles.slug',
            'title' => 'Articles.title',
            'views' => $popularQuery->func()->count('ArticleViews.id'),
        ])
            ->innerJoinWith('ArticleViews')
            ->group(['Articles.id'])
            ->order(['views DESC'])
            ->limit(3);

        $timeQuery = $this->ArticleViews->find();
        $viewsOverTime = $timeQuery->select([
            'views' => $timeQuery->func()->count('ArticleViews.id'),
            'day' => $timeQuery->func()->extract('DAY', 'ArticleViews.created'),
            'month' => $timeQuery->func()->extract('MONTH', 'ArticleViews.created'),
            'year' => $timeQuery->func()->extract('YEAR', 'ArticleViews.created'),
        ])
            ->group(['year', 'month', 'day'])
            ->order(['year DESC', 'month DESC', 'day DESC']);

        $this->set(compact('popularArticles', 'viewsOverTime'));
    }

}
