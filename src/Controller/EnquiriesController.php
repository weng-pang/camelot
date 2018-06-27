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

    public function beforeFilter(Event $event)
    {
        //This specifically allows guests to access the contact form page, specifically the add action that enables this.
        parent::beforeFilter($event);
        $this->Auth->allow('add');
        $this->viewBuilder()->setLayout('admin');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $enquiries = $this->paginate($this->Enquiries);

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
        if ($this->request->is('post')) {
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
                    $enquiry = $this->Enquiries->patchEntity($enquiry, $this->request->getData());
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

        $this->set(compact('enquiry'));
        //Assigning layout for this specific action to default
        $this->layout = 'default';
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

        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user)
    {
        return $user['id'] > 0;
    }

    public function myEnquiries(){
        $enquiries = TableRegistry::get('Enquiries')->find();
        $this->paginate = ['contain' => ['Users']];

        //if ($enquiry->user_id == $this->Auth->user('id')) {

        $enquiries->where([
            'Enquiries.user_id LIKE' => $this->Auth->user('id')]);

        $this->set('my_enquiries', $this->paginate($enquiries));
    }
}
