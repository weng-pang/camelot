<?php
namespace App\Controller;

class AdminController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Articles');
        $this->loadModel('ArticleViews');
        $this->loadModel('Settings');
        $this->viewBuilder()->setLayout('admin');
    }

    public function isAuthorized($user)
    {
        // If you are a user, you can access this dashboard.
        return $user['id'] > 0;
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

    /**
     * Settings form
     *
     * @return \Cake\Http\Response|null Redirects to itself after saving.
     */
    public function settings()
    {
        $settings = $this->Settings->find()->firstOrFail();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $settings = $this->Settings->patchEntity($settings, $this->request->getData());
            if ($this->Settings->save($settings)) {
                $this->Flash->success(__('The setting has been saved.'));

                return $this->redirect(['action' => 'settings']);
            }
            $this->Flash->error(__('The setting could not be saved. Please, try again.'));
        }
        $this->set(compact('settings'));
    }

}