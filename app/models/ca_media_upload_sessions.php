<?php
/** ---------------------------------------------------------------------
 * app/models/ca_media_upload_sessions.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2020-2021 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 * 
 * @package CollectiveAccess
 * @subpackage models
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 * 
 * ----------------------------------------------------------------------
 */
 
 /**
   *
   */

BaseModel::$s_ca_models_definitions['ca_media_upload_sessions'] = array(
 	'NAME_SINGULAR' 	=> _t('Media upload'),
 	'NAME_PLURAL' 		=> _t('Media uploads'),
 	'FIELDS' 			=> array(
 		'session_id' => array(
			'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_HIDDEN, 
			'IDENTITY' => true, 'DISPLAY_WIDTH' => 10, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false, 
			'DEFAULT' => '','LABEL' => _t('CollectiveAccess id'), 'DESCRIPTION' => _t('Unique numeric identifier used by CollectiveAccess internally to identify this upload')
		),
		'user_id' => array(
			'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_OMIT,
			'DISPLAY_WIDTH' => 10, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false, 
			'DEFAULT' => null,
			'DONT_ALLOW_IN_UI' => true,
			'LABEL' => _t('Submitted by user'), 'DESCRIPTION' => _t('User submitting this upload.')
		),
		'created_on' => array(
			'FIELD_TYPE' => FT_TIMESTAMP, 'DISPLAY_TYPE' => DT_FIELD, 
			'DISPLAY_WIDTH' => 20, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false, 
			'DEFAULT' => null,
			'LABEL' => _t('Creation date'), 'DESCRIPTION' => _t('The date and time the upload was started on.')
		),
		'submitted_on' => array(
			'FIELD_TYPE' => FT_DATETIME, 'DISPLAY_TYPE' => DT_FIELD, 
			'DISPLAY_WIDTH' => 20, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => true, 
			'DEFAULT' => null,
			'LABEL' => _t('Submission  date'), 'DESCRIPTION' => _t('The date and time the upload was submitted on. An empty value indicates an unsubmitted upload.')
		),
		'completed_on' => array(
			'FIELD_TYPE' => FT_DATETIME, 'DISPLAY_TYPE' => DT_FIELD, 
			'DISPLAY_WIDTH' => 20, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => true, 
			'DEFAULT' => null,
			'LABEL' => _t('Upload completion date'), 'DESCRIPTION' => _t('The date and time the upload was completed on. An empty value indicates an incomplete upload.')
		),
		'last_activity_on' => array(
			'FIELD_TYPE' => FT_DATETIME, 'DISPLAY_TYPE' => DT_FIELD, 
			'DISPLAY_WIDTH' => 20, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => true, 
			'DEFAULT' => null,
			'LABEL' => _t('Date of last upload activity'), 'DESCRIPTION' => _t('The date and time activity was last recorded on the upload.')
		),
		'session_key' => array(
			'FIELD_TYPE' => FT_TEXT, 'DISPLAY_TYPE' => DT_FIELD, 
			'DISPLAY_WIDTH' => 40, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false, 
			'DEFAULT' => '',
			'LABEL' => _t('Upload key'), 'DESCRIPTION' => _t('Unique key for the upload.'),
			'BOUNDS_LENGTH' => array(1,36)
		),
		'source' => array(
			'FIELD_TYPE' => FT_TEXT, 'DISPLAY_TYPE' => DT_FIELD, 
			'DISPLAY_WIDTH' => 30, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false, 
			'BOUNDS_LENGTH' => [0, 30],
			'DEFAULT' => '',
			'LABEL' => _t('Source of session'), 'DESCRIPTION' => _t('Source of session. Use UPLOADER for file uploader; FORM:<form_code> for front-end importer forms.')
		),
		'status' => array(
			'FIELD_TYPE' => FT_TEXT, 'DISPLAY_TYPE' => DT_FIELD, 
			'DISPLAY_WIDTH' => 30, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false, 
			'BOUNDS_LENGTH' => [0, 30],
			'DEFAULT' => 'IN_PROGRESS',
			'BOUNDS_CHOICE_LIST' => array(
				_t('In progress') => 'IN_PROGRESS',
				_t('Submitted') => 'SUBMITTED',
				_t('Processing') => 'PROCESSING',
				_t('Processed') => 'PROCESSED',
				_t('In review') => 'IN_REVIEW',
				_t('Accepted') => 'ACCEPTED',
				_t('Rejected') => 'REJECTED'
			),
			'LABEL' => _t('Status of session'), 'DESCRIPTION' => _t('Status of session. Possible states: IN_PROGRESS, SUBMITTED, PROCESSING, PROCESSED, IN_REVIEW, ACCEPTED, REJECTED.')
		),
		'num_files' => array(
			'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_FIELD, 
			'DISPLAY_WIDTH' => 10, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false, 
			'DEFAULT' => 0,
			'LABEL' => _t('File count'), 'DESCRIPTION' => _t('Number of files in upload.')
		),
		'total_bytes' => array(
			'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_FIELD, 
			'DISPLAY_WIDTH' => 10, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false, 
			'DEFAULT' => 0,
			'LABEL' => _t('Total upload size'), 'DESCRIPTION' => _t('The total size of the upload for all files, in bytes.')
		),
		'error_code' => array(
			'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_FIELD, 
			'DISPLAY_WIDTH' => 10, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false, 
			'DEFAULT' => 0,
			'LABEL' => _t('Error code'), 'DESCRIPTION' => _t('Error code. Zero if no error.')
		),
		'metadata' => array(
			'FIELD_TYPE' => FT_VARS, 'DISPLAY_TYPE' => DT_OMIT, 
			'DISPLAY_WIDTH' => 10, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false, 
			'DEFAULT' => 0,
			'LABEL' => _t('Associated form metadata'), 'DESCRIPTION' => _t('User-entered metadata for upload.')
		)
 	)
);

class ca_media_upload_sessions extends BaseModel {
	# ---------------------------------
	# --- Object attribute properties
	# ---------------------------------
	# Describe structure of content object's properties - eg. database fields and their
	# associated types, what modes are supported, et al.
	#

	# ------------------------------------------------------
	# --- Basic object parameters
	# ------------------------------------------------------
	# what table does this class represent?
	protected $TABLE = 'ca_media_upload_sessions';
	      
	# what is the primary key of the table?
	protected $PRIMARY_KEY = 'session_id';

	# ------------------------------------------------------
	# --- Properties used by standard editing scripts
	# 
	# These class properties allow generic scripts to properly display
	# records from the table represented by this class
	#
	# ------------------------------------------------------

	# Array of fields to display in a listing of records from this table
	protected $LIST_FIELDS = array('session_key');

	# When the list of "list fields" above contains more than one field,
	# the LIST_DELIMITER text is displayed between fields as a delimiter.
	# This is typically a comma or space, but can be any string you like
	protected $LIST_DELIMITER = ' ';


	# What you'd call a single record from this table (eg. a "person")
	protected $NAME_SINGULAR;

	# What you'd call more than one record from this table (eg. "people")
	protected $NAME_PLURAL;

	# List of fields to sort listing of records by; you can use 
	# SQL 'ASC' and 'DESC' here if you like.
	protected $ORDER_BY = array('created_on');

	# Maximum number of record to display per page in a listing
	protected $MAX_RECORDS_PER_PAGE = 20; 

	# How do you want to page through records in a listing: by number pages ordered
	# according to your setting above? Or alphabetically by the letters of the first
	# LIST_FIELD?
	protected $PAGE_SCHEME = 'alpha'; # alpha [alphabetical] or num [numbered pages; default]

	# If you want to order records arbitrarily, add a numeric field to the table and place
	# its name here. The generic list scripts can then use it to order table records.
	protected $RANK = '';
	
	
	# ------------------------------------------------------
	# Hierarchical table properties
	# ------------------------------------------------------
	protected $HIERARCHY_TYPE				=	null;
	protected $HIERARCHY_LEFT_INDEX_FLD 	= 	null;
	protected $HIERARCHY_RIGHT_INDEX_FLD 	= 	null;
	protected $HIERARCHY_PARENT_ID_FLD		=	null;
	protected $HIERARCHY_DEFINITION_TABLE	=	null;
	protected $HIERARCHY_ID_FLD				=	null;
	protected $HIERARCHY_POLY_TABLE			=	null;
	
	# ------------------------------------------------------
	# Change logging
	# ------------------------------------------------------
	protected $UNIT_ID_FIELD = null;
	protected $LOG_CHANGES_TO_SELF = false;
	protected $LOG_CHANGES_USING_AS_SUBJECT = array(
		"FOREIGN_KEYS" => [],
		"RELATED_TABLES" => []
	);
	# ------------------------------------------------------
	# $FIELDS contains information about each field in the table. The order in which the fields
	# are listed here is the order in which they will be returned using getFields()

	protected $FIELDS;
	
	# ------------------------------------------------------
	# --- Constructor
	#
	# This is a function called when a new instance of this object is created. This
	# standard constructor supports three calling modes:
	#
	# 1. If called without parameters, simply creates a new, empty objects object
	# 2. If called with a single, valid primary key value, creates a new objects object and loads
	#    the record identified by the primary key value
	#
	# ------------------------------------------------------
	public function __construct($pn_id=null) {
		parent::__construct($pn_id);	# call superclass constructor
	}
	# ------------------------------------------------------
	/**
	 *
	 */
	public function updateStats() {
		if(!$this->isLoaded()) { return null; }
		$files = $this->getFileList();
		
		$this->set('num_files', sizeof($files));
		
		$total_bytes = 0;
		foreach($files as $f) {
			$total_bytes += $f['total_bytes'];
		}	
	
		$this->set('total_bytes', $total_bytes);	
		
		return $this->update();
	}
	# ------------------------------------------------------
	/**
	 * Check if currently loaded upload is marked as complete
	 *
	 * @return int Unix timestamp for date/time completed, null if no upload is loaded, or false if the uploaf is not complete.
	 */
	public function isComplete() {
		if(!$this->isLoaded()) { return null; }
		$completed_on = $this->get('completed_on', ['getDirectDate' => true]);
		return ($completed_on > 0) ? $completed_on : false;
	}
	# ------------------------------------------------------
	/**
	 * Check if currently loaded upload is marked as errored
	 *
	 * @return int Error code, or false if no error
	 */
	public function hasError() {
		if(!$this->isLoaded()) { return null; }
		return ($error_code = (int)$this->get('error_code')) ? $error_code : false;
	}
	# ------------------------------------------------------
	/**
	 * 
	 *
	 * @return array
	 */
	public function getFileList() : ?array {
		if(!$this->isLoaded()) { return null; }
		
		$db = $this->getDb();
		
		$qr = $db->query("SELECT * FROM ca_media_upload_session_files WHERE session_id = ?", [$this->getPrimaryKey()]);
		
		$files = [];
		while($qr->nextRow()) {
			$row = $qr->getRow();
			$files[$row['filename']] = $row;
		}
		
		return $files;
	}
	# ------------------------------------------------------
	/**
	 * 
	 *
	 * @return 
	 */
	public function getFile(string $filename) : ?ca_media_upload_session_files {
		if(!$this->isLoaded()) { return null; }
		
		return ca_media_upload_session_files::find(
			['session_id' => $this->getPrimaryKey(), 'filename' => $filename], 
			['returnAs' => 'firstModelInstance']
		);
	}
	# ------------------------------------------------------
	/**
	 * 
	 *
	 * @return bool
	 */
	public function setFile(string $filename, array $data, ?array $options=null) : ?ca_media_upload_session_files {
		if(!$this->isLoaded()) { return false; }
		
		if(!($t_file = $this->getFile($filename))) {
			$t_file = new ca_media_upload_session_files();
			$t_file->set('filename', $filename);
			$t_file->set('session_id', $this->getPrimaryKey());
		}
		
		foreach(['completed_on', 'last_activity_on', 'bytes_received', 'total_bytes', 'error_code'] as $f) {
			if(isset($data[$f])) {
				$t_file->set($f, $data[$f]);
			}
		}
		if($t_file->getPrimaryKey() ? $t_file->update() : $t_file->insert()) {
			return $t_file;
		}
		$this->errors = $t_file->errors;
		return null;
	}
	# ------------------------------------------------------
}