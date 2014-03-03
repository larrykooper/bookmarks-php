<?php
App::uses('AppModel', 'Model');
/**
 * UserSiteTag Model
 *
 * @property User $User
 * @property Url $Url
 */
class UserSiteTag extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'UserSiteTag';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'UserSiteTagID';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'Tag';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'UserID',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Url' => array(
			'className' => 'Url',
			'foreignKey' => 'URLID',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
