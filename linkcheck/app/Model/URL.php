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

}
