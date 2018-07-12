<?php
namespace App\Controller;

use App\Model\Entity\Role;
use Cake\Http\Exception\NotFoundException;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

/**
 * Enquiries Controller
 *
 * @property \App\Model\Table\EnquiriesTable $Enquiries
 *
 * @method \App\Model\Entity\Enquiry[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EnquiriesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add', 'view', 'myEnquiries']);
        $this->viewBuilder()->setLayout('admin');
    }

    public function isAuthorized($user)
    {
        return Role::isAdmin($user['role']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $enquiries = $this->paginate($this->Enquiries->find('all')->where(['Enquiries.closed'=> false])->contain([]));

        $this->set(compact('enquiries'));
    }

    /**
     * View method
     *
     *
     *
     * Right now, any user can access any enquiry. I think you need to ensure that if the user is a customer, then the $id must correspond to an enquiry that they created.
     * For example:
     *
     *   if (Role::isGuest($this->Auth->user() && $enquiry->user != $this->Auth->user('id')) {
     *     somehow send a 403 forbidden error in the appropriate CakePHP way
     *     (or even a 404 error, to hide the fact that the record even exists to those who don't need to know).
     *   }
     *
     * @param string|null $id Enquiry id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $enquiry = $this->Enquiries->get($id, [
            'contain' => []
        ]);

        if ($enquiry == null || !$enquiry->canAccess($this->Auth->user())) {
            throw new NotFoundException('Enquiry not found');
        }

        if (!Role::isAdmin($this->Auth->user())) {
            $this->viewBuilder()->setLayout('customer');
        }

        $this->set('enquiry', $enquiry);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $enquiry = $this->Enquiries->newEntity();
        if ($this->getRequest()->is('post')) {
            $enquiry = $this->Enquiries->patchEntity($enquiry, $this->request->getData());

            // If the user is logged in, we assign the user id foreign key to the enquiry.
            if ($this->Auth->user()){
                // Associate enquiry with this user's ID
                $enquiry->user_id = $this->Auth->user('id');
            }

            /*
            // Retrieving Users table for use
            $usersTable = TableRegistry::get('users');

            // Query to find out if a user with the email already exists
            $existingAccount = $usersTable->findByEmail($enquiry->temp_email);

            // If no user is found with the email submitted, create a dummy account for the user and assign the
            // email to it.
            if ($existingAccount == null){
                $newUser = $usersTable->newEntity();
                $newUser->email = $enquiry->temp_email;
                $newUser->password = 'password123';
                $newUser->name = 'Temporary User';
                $newUser->mobile_phone = null;
                $newUser->created = Time::now();
                $newUser->modified = Time::now();
                $newUser->role = Role::GUEST;
                $usersTable->save($newUser);


                $enquiry->user_id = $newUser->id;
            }
            */

            if ($this->Enquiries->save($enquiry)) {
                $this->Flash->success(__('Your enquiry has been successfully sent!'));
                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The enquiry could not be saved. Please, try again.'));
        }

        $this->set('enquiry', $enquiry);

        // Using default instead of customer layout for this, because the first few tiems a user creates a new blog entry, they probably don't even know what the customer dashboard is, and it may feel like a different website to them.
        $this->viewBuilder()->setLayout('default');
    }

    /**
     * Delete method
     *
     * @param string|null $id Enquiry id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $enquiry = $this->Enquiries->get($id);
        if ($this->Enquiries->delete($enquiry)) {
            $this->Flash->success(__('The enquiry has been deleted.'));
        } else {
            $this->Flash->error(__('The enquiry could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'closed_enquiries']);
    }

    public function myEnquiries()
    {
        if ($this->Auth->user(['role']) < 2) {
            $this->viewBuilder()->setLayout('customer');
        }

        $enquiries = TableRegistry::get('Enquiries')->find();
        $this->paginate = ['contain' => ['Users']]; // ?

        $enquiries->where([
            'Enquiries.user_id' => $this->Auth->user('id')]);

        $this->set('my_enquiries', $this->paginate($enquiries));
    }

    public function close($id=null)
    {
        $enquiry = $this->Enquiries->get($id);

        $enquiry->closed = true;

        // Note how with the delete(...) action, the redirect happens regardless of whether it was successful or not,
        // the only difference is whether it does Flash->success() or Flash->error().
        // By only redirecting on success, the user will have to force a browser refresh for a POST request.
        if ($this->Enquiries->save($enquiry)) {
            $this->Flash->success(__('This enquiry has been closed.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('Unable to close this enquiry.'));
    }

    public function open($id=null){
        $enquiry = $this->Enquiries->get($id);
        $enquiry->closed = false;

        // See comment in close() action.
        if ($this->Enquiries->save($enquiry)) {
            $this->Flash->success(__('The enquiry has been re-opened.'));
            return $this->redirect(['action' => 'closed_enquiries']);
        }
        $this->Flash->error(__('Unable to re-open the enquiry.'));
    }

    public function closedEnquiries(){
        $archivedEnquiries = TableRegistry::get('Enquiries')->find('all')->where(['Enquiries.closed'=> true])->contain([]);
        $this->set('archivedEnquiries', $this->paginate($archivedEnquiries));
    }
}
