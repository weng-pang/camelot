<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 *
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{

    public function isAuthorized($user)
    {
        // return $user['id'] > 0;
        return $this->Auth->user('role') > 2;
    }

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['storeIndex']);
        $this->viewBuilder()->setLayout('admin');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $products = $this->paginate($this->Products->find('all')->where(['Products.archived'=> false])->contain([]));

        $this->set(compact('products'));
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => []
        ]);

        $this->set('product', $product);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEntity();
        if ($this->request->is('post')) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $this->set(compact('product', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $this->set(compact('product','categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function archive($id=null){
        $product = $this->Products->get($id);

        // If the product doesn't exist, then this will cause a PHP null reference error.
        // Given that we know this is a possibility (because $id is user input and they can type whatever they want there, doesn't have to be a valid ID)
        // then we should instead send a 404 error to the user.
        // I think the best way to do this in a CakepHP way is to use the "firstOrFail()" method instead of "get()", because that will throw the appropriate exception.
        // Whether we appropriately display an error message in response is the next question I'd ask myself, because I don't think we do, but it is a good first step.
        $product->archived = true;

        // As with enquiries. See comment there (for close() action).
        if ($this->Products->save($product)) {
            $this->Flash->success(__('This product has been archived.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('Unable to archive this product.'));
    }

    public function restore($id=null){
        $product = $this->Products->get($id);
        $product->archived = false;

        if ($this->Products->save($product)) {
            $this->Flash->success(__('This product has been restored.'));
            return $this->redirect(['action' => 'archiveIndex']);
        }
        $this->Flash->error(__('Unable to restore this product.'));
    }

    public function archiveIndex(){
        $archivedProducts = TableRegistry::get('Products')->find('all')->where(['Products.archived'=> true])->contain([]);
        $this->set('archivedProducts', $this->paginate($archivedProducts));
    }

    public function storeIndex(){
        $this->viewBuilder()->setLayout('store');
        $this->loadComponent('Paginator');
        $products = $this->Paginator->paginate(
            $this->Products->find()->where(['archived' => false]), [
                'limit' => 20,
                'order' => [
                    'Products.created' => 'DESC',
                ]
            ]
        );
        $this->set(compact('products'));
    }
}
