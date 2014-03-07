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

}