<?php
namespace App\Controller;
use App\Model\Entity\ArticleView;
use App\Model\Table\ArticlesTable;
use App\Model\Table\ArticleViewsTable;
use Cake\Database\Query;
use Cake\ORM\TableRegistry;

/**
 * @property ArticlesTable $Articles
 * @property ArticleViewsTable $ArticleViews
 */
class ArticlesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['tags', 'view', 'advancedSearch', 'simpleSearch']);
        $this->loadModel('ArticleViews');
        $this->viewBuilder()->setLayout('admin');
    }

    public function index()
    {
        $this->loadComponent('Paginator');

        // Only displaying non-archived articles
        $articles = $this->Paginator->paginate($this->Articles->find('all')->where(['Articles.archived'=> false])->contain([]));
        $this->set(compact('articles'));
    }


    /**
     * This checks for articles containing an exact phrase in either the title or the body.
     * @see advancedSearch() For a much more comprehensive search.
     */
    public function simpleSearch()
    {
        // The URL for this simple search is "/articles/simple-search?query=...". We are interested in the "?query=..."
        // part which is the search text entered by the user.
        $queryTerms = $this->getRequest()->getQuery('query');

        // The only thing we need to do to these search terms is to turn them into a wildcard to work correctly with
        // the LIKE clause. Otherwise, it will only search for articles where the title or body is EXACTLY what the
        // user searched, rather than matching articles where the title or body CONTAINS the search terms.
        $queryTermsWithWildCard = '%' . $queryTerms . '%';

        // Note that we are happy for either the title or the body to match.
        // If we were to have used: where(['title LIKE' => ..., 'body LIKE' => ...]) without using another array and
        // the OR keyword, then the default query would ask for articles where BOTH the title AND the body match the
        // search terms, which is typically not what the user expects when performing a search.
        $articles = $this->Articles->find()->where([
            'OR' => [
                'title LIKE' => $queryTermsWithWildCard,
                'body LIKE' => $queryTermsWithWildCard,
            ]
        ]);

        // In a large CMS, this search is likely to return a large number of articles, so the results should be
        // paginated.
        $this->loadComponent('Paginator');
        $paginatedArticles = $this->Paginator->paginate($articles);
        $this->set('articles', $paginatedArticles);

        // Even though this simple search doesn't support searching by tags, the 'search' view which is used to
        // show these results to the user WILL support searching by tags. As such, it will also expect there to
        // be a $selectedTagId variable available, so lets pass in a dummy value of zero.
        $this->set('selectedTagId', 0);

        // As above, although we don't support searching by tags in this simple search, the page which displays results
        // to the user will. As such, we will pass a list of tags to the view so that we can show a drop down list of
        // available tags for the user to select.
        $tagList = $this->Articles->Tags->find('list');
        $this->set('tagList', $tagList);

        // Pass the query the user asked for to the view, so we can say something like "Results for 'Blah'..." to
        // confirm that we did indeed search what they asked us to. It also means that we can populate the search
        // text input with the string, so the user can perform the search again.
        $this->set('query', $queryTerms);

        $this->viewBuilder()->setLayout('default');
        $this->viewBuilder()->setTemplate('search');
    }

    /**
     * Perform a search of the database for all articles matching a set of search terms.
     * Specifically, we expect the URL to include "?query=...&tag=..." parameters, which we will inspect
     * to find the terms we want to search for.
     *
     * Note, this is more complex than a typical search, because we want to make sure that we correctly search for
     * phrases with multiple words, and optionally search based on tags if a tag is selected. If we wanted to boil the
     * query down to its most simplistic form, then it would look like this:
     *
     *  $this->Articles->find()->where(['body' => $query]);
     *
     * There are several problems with this. Most notably, it is looking for articles where the body of the article
     * exactly matches the $query entered by the user. However we really only want articles where the body contains
     * the text entered by the user, and probably also contains other text too. This is done using the LIKE keyword, and
     * placing wildcards (represented by the % symbol) on either side ("%$query%"), but my preference is always to use
     * curly brackets when putting a variable in a string, to make it clearer where the start and ent of the variable is,
     * hence "%{$query}%":
     *
     *  $this->Articles->find()->where(['body LIKE' => "%{$query}%"])
     *
     * This still has problems though, because what about if the title matches? Really we want all articles where the
     * title matches OR where the body matches:
     *
     *  $this->Articles->find()->where([
     *      'OR' => [
     *          'body LIKE' => "%{$query}%",
     *          'title LIKE' => "%{$query}%",
     *      ]
     *  ]);
     * 
     * The trick with this statement is to read it inside out, instead of from top to bottom. If I read it in English
     * from top to bottom, I get: "Find where or body like ... title like ...". The "or" is out of place in this sentence.
     * Instead, I read the bit inside the where() method inside out: "Find where body like ... or title like ...".
     *
     * Starting to work better now. The only problem here is that if $query contains multiple words, it will only include
     * articles which match that exact phrase. So a $query of "article wow" will NOT match an article containing: "wow,
     * this article is great!". But we probably DO want to match that. How do we achieve this? We split the query into
     * multiple words, separating each word by whitespace:
     *
     *  $queryTermsArray = preg_split('/\s+/', $queryTermsString);
     *
     * And then we repeat the above comparison of 'body LIKE ... OR title LIKE ...' so that it checks once for each word,
     * something like this:
     *
     *  $this->Articles->find()->where([
     *      'AND' => [
     *          'OR' => [
     *              'body LIKE' => "%{$queryTermsArray[0]}%",
     *              'title LIKE' => "%{$queryTermsArray[0]}%",
     *          ],
     *          'OR' => [
     *              'body LIKE' => "%{$queryTermsArray[1]}%",
     *              'title LIKE' => "%{$queryTermsArray[1]}%",
     *          ],
     *      ]
     *  ]);
     *
     * Again, read this inside out, starting at the deepest part of the array and working outwards. So instead of:
     * "Find where AND OR body like ... title like ... OR body like ... title like ...", read it as follows:
     * "Find where body like OR ... title like ... AND body like ... OR title like ...". It takes a bit of practice to
     * be able to read these arrays in this manner when building conditions for a where() function.
     * 
     * Of course, we don't know how many query terms will actually be present. This depends on what the user types. There
     * could be one term, there could be 1000. As such, we need to loop over all of the query terms and build up an
     * array of conditions, which is done in this method, but will be left out of the rest of this documentation.
     *
     * Now we are getting somewhere, except that we also want to limit the query based on tags, so we add a further
     * condition. Given that the tags are actually in another table, we can't just say ->where(['Tags.id' => $selectedTagId]).
     * This doesn't work because we haven't told Cake that we also want to join onto the 'Tags' table in our query.
     * This is achieved using the matching() method as below:
     *
     *  $this->Articles->find()
     *     ->where([
     *          'AND' => [
     *              'OR' => [
     *                  'Articles.body LIKE' => "%{$queryTermsArray[0]}%",
     *                  'Articles.title LIKE' => "%{$queryTermsArray[0]}%",
     *              ],
     *              'OR' => [
     *                  'Articles.body LIKE' => "%{$queryTermsArray[1]}%",
     *                  'Articles.title LIKE' => "%{$queryTermsArray[1]}%",
     *              ],
     *          ]
     *      ])
     *     ->matching('Tags', function($q) use ($selectedTagId) {
     *         return $query->where(['Tags.id' => $selectedTagId]);
     *     });
     *
     * One thing to note above is that the part of the query where we asked for 'title LIKE ...' is now 'Articles.title LIKE ...'.
     * Now that we've joined onto the Tags query, we end up with two tables in our SQL query, Articles + Tags. Both of
     * these have a field called 'title', so we need to specify which 'title' we are comparing to the query terms. We
     * probably don't HAVE to change 'body LIKE' to 'Articles.body LIKE', because there is no 'body' column in the
     * Tags table. However, for consistency we may as well.
     *
     * Finally, note that in the function below, we only actually call ->matching('Tags', ...) on our $articlesQuery
     * if the user actually chose a tag (i.e. if ($selectedTagId > 0)). If they haven't chosen a tag to filter on,
     * then why bother? Worse yet, if the user didn't select a tag but we DID include the join, then we'd only return
     * articles where 'Tags.id' => 0. There are NO articles which join onto a tag with id 0, because there are no tags
     * with an id of zero.
     *
     * @see simpleSearch() for a search which may be easier to understand and start with, because it doesn't try to
     * do the absolute correct thing at every opportunity.
     */
    public function advancedSearch()
    {
        $this->loadComponent('Paginator');

        $queryTermsString = $this->getRequest()->getQuery('query');
        $selectedTagId = (int) $this->getRequest()->getQuery('tag');

        // Split the query string based on one or more whitespace characters (\s+).
        // This is done using a "Regular Expression" (regex). They are often difficult to make sense of when starting out
        // building websites, but they do get easier to understand the more you work with them. Proof of this is that
        // when I started my career, I would have had no idea what /\s+/ meant. But after a lot of practice, I'm able
        // to write a regex that does pretty much what I need for simpler tasks like this (Split on all whitespace characters).
        $queryTermsArray = preg_split('/\s+/', $queryTermsString);

        // We want to search for each term independently. If the user provided multiple terms, such as "PHP HTML", then
        // we should find all articles where:
        //  (The title includes "PHP" OR the body includes "PHP")
        //   AND
        //  (The title includes "HTML" OR the body includes "HTML")
        // Notice how for each term, we need to build a condition such as "title LIKE ... OR body LIKE ...".
        // This is what happens in the loop below, we build a collection of these "OR" statements.
        $queryTermConditions = [];
        foreach($queryTermsArray as $term) {
            $queryTermConditions[] = ['OR' => [
                'Articles.title LIKE' => "%{$term}%",
                'Articles.body LIKE' => "%{$term}%",
            ]];
        }

        // Once we have a collection of or (title LIKE ... OR body LIKE ...) statements, then we need to combine each
        // one using an AND (see comments above for example). By default, if we provide an array of conditions to
        // the where() method, then it will join them all together using AND, which is exactly what we want.
        $articlesQuery = $this->Articles->find()->where($queryTermConditions);

        // Filtering data by associations is documented here:
        // https://book.cakephp.org/3.0/en/orm/query-builder.html#filtering-by-associated-data
        // Indeed, the example at that piece of documentation is exactly what we are trying to do here - filter articles
        // by their tags.
        if ($selectedTagId > 0) {
            $articlesQuery->matching('Tags', function (Query $query) use ($selectedTagId) {
                return $query->where(['Tags.id' => $selectedTagId]);
            });
        }

        $this->set('articles', $this->Paginator->paginate($articlesQuery));

        // Passed to the view so that we can show a drop down list of available tags for the user to select.
        $tagList = $this->Articles->Tags->find('list');
        $this->set('tagList', $tagList);

        // Pass the query the user asked for to the view, so we can say something like "Results for 'Blah'..." to
        // confirm that we did indeed search what they asked us to. It also means that we can populate the search
        // text input with the string, so the user can perform the search again.
        $this->set('query', $queryTermsString);
        $this->set('selectedTagId', $selectedTagId);

        $this->viewBuilder()->setLayout('default');
        $this->viewBuilder()->setTemplate('search');
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

    public function hide($id=null){
        $article = $this->Articles->get($id);

        $article->published = false;

        if ($this->Articles->save($article)) {
            $this->Flash->success(__('Your article is now hidden.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('Unable to hide your article.'));
    }

    public function archive($id=null){
        $article = $this->Articles->get($id);

        // If an article is archived, it is "unpublished" as well
        $article->archived = true;
        $article->published = false;

        if ($this->Articles->save($article)) {
            $this->Flash->success(__('Your article has been archived.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('Unable to archive your article.'));
    }

    public function restore($id=null){
        $article = $this->Articles->get($id);
        $article->archived = false;

        if ($this->Articles->save($article)) {
            $this->Flash->success(__('Your article has been restored.'));
            return $this->redirect(['action' => 'archiveIndex']);
        }
        $this->Flash->error(__('Unable to restore your article.'));
    }

    public function publish($id=null){
        $article = $this->Articles->get($id);
        $article->published = true;

        if ($this->Articles->save($article)) {
            $this->Flash->success(__('Your article has been published.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('Unable to publish your article.'));
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
            return $this->redirect(['action' => 'archiveIndex']);
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

    public function archiveIndex(){
            $archivedArticles = TableRegistry::get('Articles')->find('all')->where(['Articles.archived'=> true])->contain([]);
            $this->set('archivedArticles', $this->paginate($archivedArticles));
    }

    public function isAuthorized($user)
    {
        return $this->Auth->user('role') > 2;
    }

}
