<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Role;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['logout', 'register']);
        $this->viewBuilder()->setLayout('admin');
    }

    public function isAuthorized($user) {
        return $this->Auth->user('role') > 2;
    }

    public function logout()
    {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [
                'Articles' => ['Users']
            ]
        ]);

        $this->set('user', $user);
        $this->viewBuilder()->setLayout('default');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->render('edit');
    }

    public function register()
    {
        $this->viewBuilder()->setLayout('auth');
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->role = Role::REGISTERED;

            if ($this->Users->save($user)) {

                // Force the user to be logged in, to prevent them having to re-enter their credentials just after
                // entering them in the initial signup form.
                $this->Auth->setUser($user);

                $this->Flash->success(__('You have successfully registered!'));

                return $this->redirect(['controller' => 'home', 'action' => 'index']);
            }
            $this->Flash->error(__('There seems to be an issue. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->render('register');
    }
    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            // Don't try to save a blank password when editing an existing user and they didn't submit a password.
            // What has really happened is they edited the user, but opted not to change the password.
            $data = $this->request->getData();
            if (!$data['password']) {
                unset($data['password']);
            }

            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Auth->user('id') === $user->id) {
            $this->Flash->error(__('Cannot delete yourself.'));
        } else if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        $this->viewBuilder()->setTheme('AdminLTE');
        $this->viewBuilder()->setClassName('AdminLTE.AdminLTE');
        $this->viewBuilder()->setLayout('AdminLTE-login');

//        $this->viewBuilder()->setLayout('auth');
        $settings = TableRegistry::get('Settings')->find()->firstOrFail();
        if ($this->getRequest()->is('post')) {
            if ($settings->is_demo_site && $this->getRequest()->getData('email') === 'root@example.com' && $this->getRequest()->getData('password') === 'demo password') {
                $user = $this->Users->find()->firstOrFail();
            } else {
                $user = $this->Auth->identify();
            }

            if ($user) {
                if (Role::isAdmin($user['role'])) {
                    $this->Auth->setUser($user);
                    return $this->redirect(['controller' => 'admin','action' => 'index']);
                } else if ($user['role'] < 3){
                    $this->Auth->setUser($user);
                    return $this->redirect(['controller' => 'customer', 'action' => 'index']);
                }
            } else {
                $this->Flash->error('Your username or password is incorrect.');
            }
        }
    }
}
