<?php
App::uses('AppController', 'Controller');
/**
 * UserSites Controller
 *
 * @property UserSite $UserSite
 * @property PaginatorComponent $Paginator
 */
class UserSitesController extends AppController {

/**
 * Components
 *
 * @var array
 */

    public $components = array('Paginator', 'Session');  // We need Session to use the Flash

    public $paginate = array(
        'contain' => array('UserSiteTag')
    );

    private $loggedInUser;

    public function beforeFilter() {
        require('../../../ckuser.php');
        if (!$validated) {
             $this->log("not validated", 'debug');
             // If not validated, I want to redirect to some "jail page"
             return $this->redirect(array('controller' => 'some_controller', 'action' => 'index'));
        } else {
            $this->loggedInUser = $theusername;
        }
    }

/**
 * index method
 *
 * @return void
 */
    public function index() {
        $this->UserSite->recursive = 1;
        $this->UserSite->unbindModel( array('belongsTo' => array('User')));
        $data = $this->Paginator->paginate(
            'UserSite', array('UserSite.UserID' => $this->loggedInUser));

        $this->set('userSites', $data);
    }

    public function showTags() {
        $mySites = $this->UserSite->getTagRecordsForUserSite(44);
        $this->log("in controller", 'debug');
        $this->log($mySites, 'debug');
        $this->set('mySites', $mySites);
    }

    public function showForAllUsers() {
        $this->UserSite->recursive = 1;
        $this->set('userSites', $this->Paginator->paginate());
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function view($id = null) {
        if (!$this->UserSite->exists($id)) {
            throw new NotFoundException(__('Invalid user site'));
        }
        $options = array('conditions' => array('UserSite.' . $this->UserSite->primaryKey => $id));
        $this->set('userSite', $this->UserSite->find('first', $options));
    }

/**
 * add method
 *
 * @return void
 */
    public function add() {
        if ($this->request->is('post')) {
            $this->UserSite->create();
            if ($this->UserSite->save($this->request->data)) {
                $this->Session->setFlash(__('The user site has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user site could not be saved. Please, try again.'));
            }
        }
        $urls = $this->UserSite->Url->find('list');
        $users = $this->UserSite->User->find('list');
        $this->set(compact('urls', 'users'));
    }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function edit($id = null) {
        if (!$this->UserSite->exists($id)) {
            throw new NotFoundException(__('Invalid user site'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->UserSite->save($this->request->data)) {
                $this->Session->setFlash(__('The user site has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user site could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('UserSite.' . $this->UserSite->primaryKey => $id));
            $this->request->data = $this->UserSite->find('first', $options);
        }
        $urls = $this->UserSite->Url->find('list');
        $users = $this->UserSite->User->find('list');
        $this->set(compact('urls', 'users'));
    }

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function delete($id = null) {
        $this->loadModel('URL');   // So we can use URL model
        $options = array('conditions' => array('UserSite.' . $this->UserSite->primaryKey => $id));
        $myUserSite = $this->UserSite->find('first', $options);  // read UserSite record
        $myURLID = $myUserSite['UserSite']['URLID'];  // get URLID

        $this->log("my URL ID: ".$myURLID, 'debug');

        $this->UserSite->id = $id;
        if (!$this->UserSite->exists()) {
            throw new NotFoundException(__('Invalid user site'));
        }
        $this->request->onlyAllow('post', 'delete');
        // Next line deletes the UserSite AND its dependent UserSiteTags
        if ($this->UserSite->delete()) {
            $this->Session->setFlash(__('The user site has been deleted.'));
            $myCount = $this->UserSite->find('count', array('conditions' => array('UserSite.URLID' => $myURLID)));
            $this->log("count: ".$myCount, 'debug');
            // If no more UserSites with this URL, we delete URL as well
            if ($myCount == 0) {
                $this->URL->delete($myURLID);
            }
        } else {
            $this->Session->setFlash(__('The user site could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }}
