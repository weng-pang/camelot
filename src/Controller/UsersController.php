<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

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
        return $user['id'] > 0;
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
        $this->viewBuilder()->setLayout('register');
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            $allUsers = TableRegistry::get('users');

            // Checking if the email already exists. If it does, the account has already been created and
            // all that is left to do is assign role = 1 and update the other information
            $emailExists = $allUsers->exists(['email' => $user->email]);

            // Returns the first (and in this case, only) row associated with the email
            // We assume the email is unique in the Users table
            $oldaccount = $allUsers->find()->where(['email' => $user->email])->first();

            // If the email/ account does exist, then we update the old account details, and avoid creating a new account
            if ($emailExists == 1 && $oldaccount->role < 1) {

                $user = $this->Users->patchEntity($oldaccount, ['role' => 1, 'password' => $this->request->getData(['password']), 'name' => $user->name, 'mobile_phone' => $user->mobile_phone, 'modified' => Time::now()]);

            }
                if ($this->Users->save($user)) {

                    $this->Flash->success(__('You have successfully registered!'));

                    return $this->redirect(['action' => 'login']);
                }
                $this->Flash->error(__('There seems to be an issue. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->render('edit');
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
        $this->viewBuilder()->setLayout('admin-login');
        if ($this->getRequest()->is('post')) {
            $settings = TableRegistry::get('Settings')->find()->firstOrFail();
            if ($settings->is_demo_site && $this->getRequest()->getData('email') === 'root@example.com' && $this->getRequest()->getData('password') === 'demo password') {
                $user = $this->Users->find()->firstOrFail();
            } else {
                $user = $this->Auth->identify();
            }

            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Your username or password is incorrect.');
        }
    }
}
