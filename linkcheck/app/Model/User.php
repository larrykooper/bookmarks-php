<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property UserSite $UserSite
 * @property UserSiteTag $UserSiteTag
 */
class User extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'User';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'UserID';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'UserID';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'UserSite' => array(
			'className' => 'UserSite',
			'foreignKey' => 'UserID',
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
			'foreignKey' => 'UserID',
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

}
