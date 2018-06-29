<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
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
        // return $user['id'] > 0;
        return $this->Auth->user('role') > 2;
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
     * @param string|null $id Enquiry id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if ($this->Auth->user(['role']) < 2) {
            $this->viewBuilder()->setLayout('customer');
        }

        $enquiry = $this->Enquiries->get($id, [
            'contain' => []
        ]);

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

            if ($this->Enquiries->save($enquiry)) {
                $this->Flash->success(__('Your enquiry has been successfully sent!'));

                // Retrieving Users table for use
                $usersTable = TableRegistry::get('users');

                // Query to find out if a user with the email already exists
                $emailExists = $usersTable->exists(['email' => $enquiry->temp_email]);

                // If no user is found with the email submitted, create a dummy account for the user and assign the
                // email to it.
                if ($emailExists == 0){
                        $newUser = $usersTable->newEntity();
                        $newUser->email = $enquiry->temp_email;
                        $newUser->password = 'password123';
                        $newUser->name = 'Temporary User';
                        $newUser->mobile_phone = null;
                        $newUser->created = Time::now();
                        $newUser->modified = Time::now();
                        $newUser->role = 0;
                        $usersTable->save($newUser);


                        $enquiry->user_id = $newUser->id;
                        $this->Enquiries->save($enquiry);
                }

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The enquiry could not be saved. Please, try again.'));
        }

        $this->set('enquiry', $enquiry);
        //Assigning layout for this specific action to default
        $this->viewBuilder()->setLayout('default');
    }

    /**
     * Edit method
     *
     * @param string|null $id Enquiry id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */

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

    public function myEnquiries(){

        if ($this->Auth->user(['role']) < 2) {
            $this->viewBuilder()->setLayout('customer');
        }

        $enquiries = TableRegistry::get('Enquiries')->find();
        $this->paginate = ['contain' => ['Users']];

        //if ($enquiry->user_id == $this->Auth->user('id')) {

        $enquiries->where([
            'Enquiries.user_id LIKE' => $this->Auth->user('id')]);

        $this->set('my_enquiries', $this->paginate($enquiries));
    }

    public function close($id=null){
        $enquiry = $this->Enquiries->get($id);

        $enquiry->closed = true;

        if ($this->Enquiries->save($enquiry)) {
            $this->Flash->success(__('This enquiry has been closed.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('Unable to close this enquiry.'));
    }

    public function open($id=null){
        $enquiry = $this->Enquiries->get($id);
        $enquiry->closed = false;

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
