<?php
App::uses('AppModel', 'Model');
/**
 * URL Model
 *
 */
class URL extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'URL';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'URLID';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'URL';

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'UserSite' => array(
			'className' => 'UserSite',
			'foreignKey' => 'URLID',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'UserSiteTag' => array(
			'className' => 'UserSiteTag',
			'foreignKey' => 'URLID',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

    public function changeUrlToRedirectLocation($id) {
        $options = array('conditions' => array('URL.' . $this->primaryKey => $id));
        $myURL = $this->find('first', $options);
        $myURL['URL']['URL'] = $myURL['URL']['RedirectLocation'];
        $this->log("Message 18: about to save", 'debug');
        $this->save($myURL);
        $this->log("Message 19: saved", 'debug');
        $retval = array('id' => $id, 'newUrl' => $myURL['URL']['RedirectLocation']);
        return $retval;
    }

}