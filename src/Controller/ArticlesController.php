<?php
namespace App\Controller;
use App\Model\Entity\ArticleView;
use App\Model\Table\ArticlesTable;
use App\Model\Table\ArticleViewsTable;

/**
 * @property ArticlesTable $Articles
 * @property ArticleViewsTable $ArticleViews
 */
class ArticlesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['tags', 'view', 'search']);
        $this->loadModel('ArticleViews');
        $this->viewBuilder()->setLayout('admin');
    }

    public function index()
    {
        $this->loadComponent('Paginator');
        $articles = $this->Paginator->paginate($this->Articles->find());
        $this->set(compact('articles'));
    }

    /**
     * Perform a search of the database for all articles matching a set of search terms.
     * Specifically, we expect the URL to include a "?query=..." parameter, which we will inspect
     * to find the terms we want to search for.
     */
    public function search()
    {
        $this->loadComponent('Paginator');

        $queryTerms = $this->getRequest()->getQuery('query');

        // Search both the 'title' and the 'body' field, but make sure to use "OR". By default, the
        // where() function joins all of the criteria together with "AND". That is, if the title matches the search
        // term, then we don't also need the body to match for it to be interesting, we are happy to return it as
        // a matching result.
        $articles = $this->Articles->find()
            ->where([
                'OR' => [
                    'title LIKE' => "%{$queryTerms}%",
                    'body LIKE' => "%{$queryTerms}%",
                ]
            ]);
        $this->set('articles', $this->Paginator->paginate($articles));

        // Pass the query the user asked for to the view, so we can say somethign like "Results for 'Blah'..." to
        // confirm that we did indeed search what they asked us to.
        $this->set('query', $queryTerms);

        $this->viewBuilder()->setLayout('default');
    }

    public function view($slug = null)
    {
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        $view = new ArticleView([
            'article_id' => $article->id,
            'user_id' => $this->Auth->user()['id']
        ]);
        $this->ArticleViews->save($view);
        $this->viewBuilder()->setLayout('default');
        $this->set(compact('article'));
    }

    public function add()
    {
        $article = $this->Articles->newEntity();
        if ($this->getRequest()->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());

            $article->user_id = $this->Auth->user('id');

            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }

        $tags = $this->Articles->Tags->find('list');

        $this->set('tags', $tags);
        $this->set('article', $article);

        $this->render('edit');
    }

    public function edit($slug)
    {
        $article = $this->Articles
            ->findBySlug($slug)
            ->contain('Tags') // load associated Tags
            ->firstOrFail();
        if ($this->getRequest()->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->getRequest()->getData(), [
                'accessibleFields' => ['user_id' => false]
            ]);
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your article.'));
        }

        $tags = $this->Articles->Tags->find('list');

        $this->set('tags', $tags);
        $this->set('article', $article);
    }

    public function delete($slug)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);

        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The {0} article has been deleted.', $article->title));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function tags()
    {
        // The 'pass' key is provided by CakePHP and contains all
        // the passed URL path segments in the request.
        $tags = $this->getRequest()->getParam('pass');

        // Use the ArticlesTable to find tagged articles.
        $articles = $this->Articles->find('tagged', [
            'tags' => $tags
        ]);

        // Pass variables into the view template context.
        $this->set([
            'articles' => $articles,
            'tags' => $tags
        ]);
    }

    public function isAuthorized($user)
    {
        return $user['id'] > 0;
    }

}