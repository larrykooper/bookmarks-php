<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	
	public $components = array('Paginator',
    'Auth'=> array(
        'authenticate' => array(
            'Form' => array(
                'fields' => array('username' => 'UserID', 'password' => 'Password')
            )
        )
    )
);

	public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->fields = array('username' => 'UserID', 'password' => 'Password');
        $this->Auth->allow('add', 'logout');
    }

    public function login() {
        $this->log('Message 609', 'debug');
        $this->log($this->Auth->user('username'), 'debug');
        
        //if already logged-in, redirect
        if($this->Session->check('Auth.User')){
            $this->redirect(array('controller'=> 'UserSites', 'action' => 'index'));
        }
        
        $this->log($this->data, 'debug');
        if ($this->request->is('post')) {
            if ($this->Auth->login($this->data['User'])) {
                $this->Session->setFlash(__('Welcome, '. $this->Session->read('Auth.User')['UserID']));
                return $this->redirect($this->Auth->redirect());
            }
            $this->Session->setFlash(__('Invalid username or password, try again'));
        }
    }
    
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
   

/**
 * index method
 *
 * @return void
 */
	public function index() {
	    $this->log("Message: In UsersController;user is next line", 'debug');
	    $myThing = $this->Session->read('Auth.User');
        $this->log($myThing, 'debug');
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
