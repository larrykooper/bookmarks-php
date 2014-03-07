<?php
class UserSiteTagsController extends AppController {
    public function usersite($usersite_id = null) {
        if (!$usersite_id ) {
            throw new NotFoundException(__('Invalid usersite'));
        }

        $usersite = $this->UserSiteTag->UserSite->findById($usersite_id );
        if (!$usersite) {
            throw new NotFoundException(__('Invalid usersite'));
        }
        $this->set('usersite', $usersite);
    }   
    
    
    public function view($id = null) {
		if (!$this->UserSiteTag->exists($id)) {
			throw new NotFoundException(__('Invalid user site tag'));
		}
		$options = array('conditions' => array('UserSiteTag.' . $this->UserSiteTag->primaryKey => $id));
		$this->set('userSiteTag', $this->UserSiteTag->find('first', $options));
	}
    
    
    
}