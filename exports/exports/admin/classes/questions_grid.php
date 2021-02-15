<?php
namespace PHPMaker2020\IDB_EcoMicro_BZ;

/**
 * Page class
 */
class questions_grid extends questions
{

	// Page ID
	public $PageID = "grid";

	// Project ID
	public $ProjectID = "{98C27E89-2937-4D47-9B89-35CA334C4E82}";

	// Table name
	public $TableName = 'questions';

	// Page object name
	public $PageObjName = "questions_grid";

	// Grid form hidden field names
	public $FormName = "fquestionsgrid";
	public $FormActionName = "k_action";
	public $FormKeyName = "k_key";
	public $FormOldKeyName = "k_oldkey";
	public $FormBlankRowName = "k_blankrow";
	public $FormKeyCountName = "key_count";

	// Page URLs
	public $AddUrl;
	public $EditUrl;
	public $CopyUrl;
	public $DeleteUrl;
	public $ViewUrl;
	public $ListUrl;

	// Page headings
	public $Heading = "";
	public $Subheading = "";
	public $PageHeader;
	public $PageFooter;

	// Token
	public $Token = "";
	public $TokenTimeout = 0;
	public $CheckToken;

	// Page heading
	public function pageHeading()
	{
		global $Language;
		if ($this->Heading != "")
			return $this->Heading;
		if (method_exists($this, "tableCaption"))
			return $this->tableCaption();
		return "";
	}

	// Page subheading
	public function pageSubheading()
	{
		global $Language;
		if ($this->Subheading != "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->phrase($this->PageID);
		return "";
	}

	// Page name
	public function pageName()
	{
		return CurrentPageName();
	}

	// Page URL
	public function pageUrl()
	{
		$url = CurrentPageName() . "?";
		if ($this->UseTokenInUrl)
			$url .= "t=" . $this->TableVar . "&"; // Add page token
		return $url;
	}

	// Messages
	private $_message = "";
	private $_failureMessage = "";
	private $_successMessage = "";
	private $_warningMessage = "";

	// Get message
	public function getMessage()
	{
		return isset($_SESSION[SESSION_MESSAGE]) ? $_SESSION[SESSION_MESSAGE] : $this->_message;
	}

	// Set message
	public function setMessage($v)
	{
		AddMessage($this->_message, $v);
		$_SESSION[SESSION_MESSAGE] = $this->_message;
	}

	// Get failure message
	public function getFailureMessage()
	{
		return isset($_SESSION[SESSION_FAILURE_MESSAGE]) ? $_SESSION[SESSION_FAILURE_MESSAGE] : $this->_failureMessage;
	}

	// Set failure message
	public function setFailureMessage($v)
	{
		AddMessage($this->_failureMessage, $v);
		$_SESSION[SESSION_FAILURE_MESSAGE] = $this->_failureMessage;
	}

	// Get success message
	public function getSuccessMessage()
	{
		return isset($_SESSION[SESSION_SUCCESS_MESSAGE]) ? $_SESSION[SESSION_SUCCESS_MESSAGE] : $this->_successMessage;
	}

	// Set success message
	public function setSuccessMessage($v)
	{
		AddMessage($this->_successMessage, $v);
		$_SESSION[SESSION_SUCCESS_MESSAGE] = $this->_successMessage;
	}

	// Get warning message
	public function getWarningMessage()
	{
		return isset($_SESSION[SESSION_WARNING_MESSAGE]) ? $_SESSION[SESSION_WARNING_MESSAGE] : $this->_warningMessage;
	}

	// Set warning message
	public function setWarningMessage($v)
	{
		AddMessage($this->_warningMessage, $v);
		$_SESSION[SESSION_WARNING_MESSAGE] = $this->_warningMessage;
	}

	// Clear message
	public function clearMessage()
	{
		$this->_message = "";
		$_SESSION[SESSION_MESSAGE] = "";
	}

	// Clear failure message
	public function clearFailureMessage()
	{
		$this->_failureMessage = "";
		$_SESSION[SESSION_FAILURE_MESSAGE] = "";
	}

	// Clear success message
	public function clearSuccessMessage()
	{
		$this->_successMessage = "";
		$_SESSION[SESSION_SUCCESS_MESSAGE] = "";
	}

	// Clear warning message
	public function clearWarningMessage()
	{
		$this->_warningMessage = "";
		$_SESSION[SESSION_WARNING_MESSAGE] = "";
	}

	// Clear messages
	public function clearMessages()
	{
		$this->clearMessage();
		$this->clearFailureMessage();
		$this->clearSuccessMessage();
		$this->clearWarningMessage();
	}

	// Show message
	public function showMessage()
	{
		$hidden = TRUE;
		$html = "";

		// Message
		$message = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($message, "");
		if ($message != "") { // Message in Session, display
			if (!$hidden)
				$message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message;
			$html .= '<div class="alert alert-info alert-dismissible ew-info"><i class="icon fas fa-info"></i>' . $message . '</div>';
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($warningMessage, "warning");
		if ($warningMessage != "") { // Message in Session, display
			if (!$hidden)
				$warningMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $warningMessage;
			$html .= '<div class="alert alert-warning alert-dismissible ew-warning"><i class="icon fas fa-exclamation"></i>' . $warningMessage . '</div>';
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($successMessage, "success");
		if ($successMessage != "") { // Message in Session, display
			if (!$hidden)
				$successMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $successMessage;
			$html .= '<div class="alert alert-success alert-dismissible ew-success"><i class="icon fas fa-check"></i>' . $successMessage . '</div>';
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$errorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($errorMessage, "failure");
		if ($errorMessage != "") { // Message in Session, display
			if (!$hidden)
				$errorMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $errorMessage;
			$html .= '<div class="alert alert-danger alert-dismissible ew-error"><i class="icon fas fa-ban"></i>' . $errorMessage . '</div>';
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo '<div class="ew-message-dialog' . (($hidden) ? ' d-none' : "") . '">' . $html . '</div>';
	}

	// Get message as array
	public function getMessages()
	{
		$ar = [];

		// Message
		$message = $this->getMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($message, "");

		if ($message != "") { // Message in Session, display
			$ar["message"] = $message;
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($warningMessage, "warning");

		if ($warningMessage != "") { // Message in Session, display
			$ar["warningMessage"] = $warningMessage;
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($successMessage, "success");

		if ($successMessage != "") { // Message in Session, display
			$ar["successMessage"] = $successMessage;
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$failureMessage = $this->getFailureMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($failureMessage, "failure");

		if ($failureMessage != "") { // Message in Session, display
			$ar["failureMessage"] = $failureMessage;
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		return $ar;
	}

	// Show Page Header
	public function showPageHeader()
	{
		$header = $this->PageHeader;
		$this->Page_DataRendering($header);
		if ($header != "") { // Header exists, display
			echo '<p id="ew-page-header">' . $header . '</p>';
		}
	}

	// Show Page Footer
	public function showPageFooter()
	{
		$footer = $this->PageFooter;
		$this->Page_DataRendered($footer);
		if ($footer != "") { // Footer exists, display
			echo '<p id="ew-page-footer">' . $footer . '</p>';
		}
	}

	// Validate page request
	protected function isPageRequest()
	{
		global $CurrentForm;
		if ($this->UseTokenInUrl) {
			if ($CurrentForm)
				return ($this->TableVar == $CurrentForm->getValue("t"));
			if (Get("t") !== NULL)
				return ($this->TableVar == Get("t"));
		}
		return TRUE;
	}

	// Valid Post
	protected function validPost()
	{
		if (!$this->CheckToken || !IsPost() || IsApi())
			return TRUE;
		if (Post(Config("TOKEN_NAME")) === NULL)
			return FALSE;
		$fn = Config("CHECK_TOKEN_FUNC");
		if (is_callable($fn))
			return $fn(Post(Config("TOKEN_NAME")), $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	public function createToken()
	{
		global $CurrentToken;
		$fn = Config("CREATE_TOKEN_FUNC"); // Always create token, required by API file/lookup request
		if ($this->Token == "" && is_callable($fn)) // Create token
			$this->Token = $fn();
		$CurrentToken = $this->Token; // Save to global variable
	}

	// Constructor
	public function __construct()
	{
		global $Language, $DashboardReport;
		global $UserTable;

		// Check token
		$this->CheckToken = Config("CHECK_TOKEN");

		// Initialize
		$this->FormActionName .= "_" . $this->FormName;
		$this->FormKeyName .= "_" . $this->FormName;
		$this->FormOldKeyName .= "_" . $this->FormName;
		$this->FormBlankRowName .= "_" . $this->FormName;
		$this->FormKeyCountName .= "_" . $this->FormName;
		$GLOBALS["Grid"] = &$this;
		$this->TokenTimeout = SessionTimeoutTime();

		// Language object
		if (!isset($Language))
			$Language = new Language();

		// Parent constuctor
		parent::__construct();

		// Table object (questions)
		if (!isset($GLOBALS["questions"]) || get_class($GLOBALS["questions"]) == PROJECT_NAMESPACE . "questions") {
			$GLOBALS["questions"] = &$this;

			// $GLOBALS["MasterTable"] = &$GLOBALS["Table"];
			// if (!isset($GLOBALS["Table"]))
			// 	$GLOBALS["Table"] = &$GLOBALS["questions"];

		}
		$this->AddUrl = "questionsadd.php";

		// Table object (users)
		if (!isset($GLOBALS['users']))
			$GLOBALS['users'] = new users();

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'grid');

		// Table name (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "TABLE_NAME"))
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'questions');

		// Start timer
		if (!isset($GLOBALS["DebugTimer"]))
			$GLOBALS["DebugTimer"] = new Timer();

		// Debug message
		LoadDebugMessage();

		// Open connection
		if (!isset($GLOBALS["Conn"]))
			$GLOBALS["Conn"] = $this->getConnection();

		// User table object (users)
		$UserTable = $UserTable ?: new users();

		// List options
		$this->ListOptions = new ListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Other options
		if (!$this->OtherOptions)
			$this->OtherOptions = new ListOptionsArray();
		$this->OtherOptions["addedit"] = new ListOptions("div");
		$this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
	}

	// Terminate page
	public function terminate($url = "")
	{
		global $ExportFileName, $TempImages, $DashboardReport;

		// Export
		global $questions;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
				$content = ob_get_contents();
			if ($ExportFileName == "")
				$ExportFileName = $this->TableVar;
			$class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
			if (class_exists($class)) {
				$doc = new $class($questions);
				$doc->Text = @$content;
				if ($this->isExport("email"))
					echo $this->exportEmail($doc->Text);
				else
					$doc->export();
				DeleteTempImages(); // Delete temp images
				exit();
			}
		}

//		$GLOBALS["Table"] = &$GLOBALS["MasterTable"];
		unset($GLOBALS["Grid"]);
		if ($url === "")
			return;
		if (!IsApi())
			$this->Page_Redirecting($url);

		// Return for API
		if (IsApi()) {
			$res = $url === TRUE;
			if (!$res) // Show error
				WriteJson(array_merge(["success" => FALSE], $this->getMessages()));
			return;
		}

		// Go to URL if specified
		if ($url != "") {
			if (!Config("DEBUG") && ob_get_length())
				ob_end_clean();
			SaveDebugMessage();
			AddHeader("Location", $url);
		}
		exit();
	}

	// Get records from recordset
	protected function getRecordsFromRecordset($rs, $current = FALSE)
	{
		$rows = [];
		if (is_object($rs)) { // Recordset
			while ($rs && !$rs->EOF) {
				$this->loadRowValues($rs); // Set up DbValue/CurrentValue
				$row = $this->getRecordFromArray($rs->fields);
				if ($current)
					return $row;
				else
					$rows[] = $row;
				$rs->moveNext();
			}
		} elseif (is_array($rs)) {
			foreach ($rs as $ar) {
				$row = $this->getRecordFromArray($ar);
				if ($current)
					return $row;
				else
					$rows[] = $row;
			}
		}
		return $rows;
	}

	// Get record from array
	protected function getRecordFromArray($ar)
	{
		$row = [];
		if (is_array($ar)) {
			foreach ($ar as $fldname => $val) {
				if (array_key_exists($fldname, $this->fields) && ($this->fields[$fldname]->Visible || $this->fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
					$fld = &$this->fields[$fldname];
					if ($fld->HtmlTag == "FILE") { // Upload field
						if (EmptyValue($val)) {
							$row[$fldname] = NULL;
						} else {
							if ($fld->DataType == DATATYPE_BLOB) {
								$url = FullUrl(GetApiUrl(Config("API_FILE_ACTION"),
									Config("API_OBJECT_NAME") . "=" . $fld->TableVar . "&" .
									Config("API_FIELD_NAME") . "=" . $fld->Param . "&" .
									Config("API_KEY_NAME") . "=" . rawurlencode($this->getRecordKeyValue($ar)))); //*** need to add this? API may not be in the same folder
								$row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
							} elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
								$url = FullUrl(GetApiUrl(Config("API_FILE_ACTION"),
									Config("API_OBJECT_NAME") . "=" . $fld->TableVar . "&" .
									"fn=" . Encrypt($fld->physicalUploadPath() . $val)));
								$row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
							} else { // Multiple files
								$files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
								$ar = [];
								foreach ($files as $file) {
									$url = FullUrl(GetApiUrl(Config("API_FILE_ACTION"),
										Config("API_OBJECT_NAME") . "=" . $fld->TableVar . "&" .
										"fn=" . Encrypt($fld->physicalUploadPath() . $file)));
									if (!EmptyValue($file))
										$ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
								}
								$row[$fldname] = $ar;
							}
						}
					} else {
						$row[$fldname] = $val;
					}
				}
			}
		}
		return $row;
	}

	// Get record key value from array
	protected function getRecordKeyValue($ar)
	{
		$key = "";
		if (is_array($ar)) {
			$key .= @$ar['id'];
		}
		return $key;
	}

	/**
	 * Hide fields for add/edit
	 *
	 * @return void
	 */
	protected function hideFieldsForAddEdit()
	{
		if ($this->isAdd() || $this->isCopy() || $this->isGridAdd())
			$this->id->Visible = FALSE;
	}

	// Lookup data
	public function lookup()
	{
		global $Language, $Security;
		if (!isset($Language))
			$Language = new Language(Config("LANGUAGE_FOLDER"), Post("language", ""));

		// Set up API request
		if (!ValidApiRequest())
			return FALSE;
		$this->setupApiSecurity();

		// Get lookup object
		$fieldName = Post("field");
		if (!array_key_exists($fieldName, $this->fields))
			return FALSE;
		$lookupField = $this->fields[$fieldName];
		$lookup = $lookupField->Lookup;
		if ($lookup === NULL)
			return FALSE;
		$tbl = $lookup->getTable();
		if (!$Security->allowLookup(Config("PROJECT_ID") . $tbl->TableName)) // Lookup permission
			return FALSE;

		// Get lookup parameters
		$lookupType = Post("ajax", "unknown");
		$pageSize = -1;
		$offset = -1;
		$searchValue = "";
		if (SameText($lookupType, "modal")) {
			$searchValue = Post("sv", "");
			$pageSize = Post("recperpage", 10);
			$offset = Post("start", 0);
		} elseif (SameText($lookupType, "autosuggest")) {
			$searchValue = Param("q", "");
			$pageSize = Param("n", -1);
			$pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
			if ($pageSize <= 0)
				$pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
			$start = Param("start", -1);
			$start = is_numeric($start) ? (int)$start : -1;
			$page = Param("page", -1);
			$page = is_numeric($page) ? (int)$page : -1;
			$offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
		}
		$userSelect = Decrypt(Post("s", ""));
		$userFilter = Decrypt(Post("f", ""));
		$userOrderBy = Decrypt(Post("o", ""));
		$keys = Post("keys");
		$lookup->LookupType = $lookupType; // Lookup type
		if ($keys !== NULL) { // Selected records from modal
			if (is_array($keys))
				$keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
			$lookup->FilterFields = []; // Skip parent fields if any
			$lookup->FilterValues[] = $keys; // Lookup values
			$pageSize = -1; // Show all records
		} else { // Lookup values
			$lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
		}
		$cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
		for ($i = 1; $i <= $cnt; $i++)
			$lookup->FilterValues[] = Post("v" . $i, "");
		$lookup->SearchValue = $searchValue;
		$lookup->PageSize = $pageSize;
		$lookup->Offset = $offset;
		if ($userSelect != "")
			$lookup->UserSelect = $userSelect;
		if ($userFilter != "")
			$lookup->UserFilter = $userFilter;
		if ($userOrderBy != "")
			$lookup->UserOrderBy = $userOrderBy;
		$lookup->toJson($this); // Use settings from current page
	}

	// Set up API security
	public function setupApiSecurity()
	{
		global $Security;

		// Setup security for API request
		if ($Security->isLoggedIn()) $Security->TablePermission_Loading();
		$Security->loadCurrentUserLevel(Config("PROJECT_ID") . $this->TableName);
		if ($Security->isLoggedIn()) $Security->TablePermission_Loaded();
		$Security->UserID_Loading();
		$Security->loadUserID();
		$Security->UserID_Loaded();
	}

	// Class variables
	public $ListOptions; // List options
	public $ExportOptions; // Export options
	public $SearchOptions; // Search options
	public $OtherOptions; // Other options
	public $FilterOptions; // Filter options
	public $ImportOptions; // Import options
	public $ListActions; // List actions
	public $SelectedCount = 0;
	public $SelectedIndex = 0;
	public $ShowOtherOptions = FALSE;
	public $DisplayRecords = 100;
	public $StartRecord;
	public $StopRecord;
	public $TotalRecords = 0;
	public $RecordRange = 10;
	public $PageSizes = "10,20,50,100,-1"; // Page sizes (comma separated)
	public $DefaultSearchWhere = ""; // Default search WHERE clause
	public $SearchWhere = ""; // Search WHERE clause
	public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
	public $SearchRowCount = 0; // For extended search
	public $SearchColumnCount = 0; // For extended search
	public $SearchFieldsPerRow = 1; // For extended search
	public $RecordCount = 0; // Record count
	public $EditRowCount;
	public $StartRowCount = 1;
	public $RowCount = 0;
	public $Attrs = []; // Row attributes and cell attributes
	public $RowIndex = 0; // Row index
	public $KeyCount = 0; // Key count
	public $RowAction = ""; // Row action
	public $RowOldKey = ""; // Row old key (for copy)
	public $MultiColumnClass = "col-sm";
	public $MultiColumnEditClass = "w-100";
	public $DbMasterFilter = ""; // Master filter
	public $DbDetailFilter = ""; // Detail filter
	public $MasterRecordExists;
	public $MultiSelectKey;
	public $Command;
	public $RestoreSearch = FALSE;
	public $DetailPages;
	public $OldRecordset;

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
			$FormError, $SearchError;

		// User profile
		$UserProfile = new UserProfile();

		// Security
		if (ValidApiRequest()) { // API request
			$this->setupApiSecurity(); // Set up API Security
		} else {
			$Security = new AdvancedSecurity();
			if (!$Security->isLoggedIn())
				$Security->autoLogin();
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loading();
			$Security->loadCurrentUserLevel($this->ProjectID . $this->TableName);
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loaded();
			if (!$Security->canList()) {
				$Security->saveLastUrl();
				$this->setFailureMessage(DeniedMessage()); // Set no permission
				$this->terminate(GetUrl("index.php"));
				return;
			}
			if ($Security->isLoggedIn()) {
				$Security->UserID_Loading();
				$Security->loadUserID();
				$Security->UserID_Loaded();
			}
		}

		// Get grid add count
		$gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->setupListOptions();
		$this->id->setVisibility();
		$this->title->setVisibility();
		$this->placeholder->setVisibility();
		$this->questions->setVisibility();
		$this->scores->setVisibility();
		$this->type->setVisibility();
		$this->section->setVisibility();
		$this->active->setVisibility();
		$this->created_at->setVisibility();
		$this->updated_at->setVisibility();
		$this->has_recommendations->setVisibility();
		$this->group->setVisibility();
		$this->category->setVisibility();
		$this->order->setVisibility();
		$this->recommendation_by_score->Visible = FALSE;
		$this->recommendation_score->setVisibility();
		$this->related->setVisibility();
		$this->trigger_related_val->setVisibility();
		$this->hideFieldsForAddEdit();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->validPost()) {
			Write($Language->phrase("InvalidPostRequest"));
			$this->terminate();
		}

		// Create Token
		$this->createToken();

		// Set up master detail parameters
		$this->setupMasterParms();

		// Setup other options
		$this->setupOtherOptions();

		// Set up lookup cache
		$this->setupLookupOptions($this->type);
		$this->setupLookupOptions($this->section);
		$this->setupLookupOptions($this->group);
		$this->setupLookupOptions($this->category);

		// Search filters
		$srchAdvanced = ""; // Advanced search filter
		$srchBasic = ""; // Basic search filter
		$filter = "";

		// Get command
		$this->Command = strtolower(Get("cmd"));
		if ($this->isPageRequest()) { // Validate request

			// Set up records per page
			$this->setupDisplayRecords();

			// Handle reset command
			$this->resetCmd();

			// Hide list options
			if ($this->isExport()) {
				$this->ListOptions->hideAllOptions(["sequence"]);
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->isGridAdd() || $this->isGridEdit()) {
				$this->ListOptions->hideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->isGridAdd() || $this->isGridEdit()) {
					$item = $this->ListOptions["griddelete"];
					if ($item)
						$item->Visible = TRUE;
				}
			}

			// Set up sorting order
			$this->setupSortOrder();
		}

		// Restore display records
		if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
			$this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecords = 100; // Load default
			$this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
		}

		// Load Sorting Order
		if ($this->Command != "json")
			$this->loadSortOrder();

		// Build filter
		$filter = "";
		if (!$Security->canList())
			$filter = "(0=1)"; // Filter all records

		// Restore master/detail filter
		$this->DbMasterFilter = $this->getMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->getDetailFilter(); // Restore detail filter
		AddFilter($filter, $this->DbDetailFilter);
		AddFilter($filter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "question_types") {
			global $question_types;
			$rsmaster = $question_types->loadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
				$this->terminate("question_typeslist.php"); // Return to master page
			} else {
				$question_types->loadListRowValues($rsmaster);
				$question_types->RowType = ROWTYPE_MASTER; // Master row
				$question_types->renderListRow();
				$rsmaster->close();
			}
		}

		// Load master record
		if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "sections") {
			global $sections;
			$rsmaster = $sections->loadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
				$this->terminate("sectionslist.php"); // Return to master page
			} else {
				$sections->loadListRowValues($rsmaster);
				$sections->RowType = ROWTYPE_MASTER; // Master row
				$sections->renderListRow();
				$rsmaster->close();
			}
		}

		// Load master record
		if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "question_groups") {
			global $question_groups;
			$rsmaster = $question_groups->loadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
				$this->terminate("question_groupslist.php"); // Return to master page
			} else {
				$question_groups->loadListRowValues($rsmaster);
				$question_groups->RowType = ROWTYPE_MASTER; // Master row
				$question_groups->renderListRow();
				$rsmaster->close();
			}
		}

		// Load master record
		if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "question_category") {
			global $question_category;
			$rsmaster = $question_category->loadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
				$this->terminate("question_categorylist.php"); // Return to master page
			} else {
				$question_category->loadListRowValues($rsmaster);
				$question_category->RowType = ROWTYPE_MASTER; // Master row
				$question_category->renderListRow();
				$rsmaster->close();
			}
		}

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSql = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $filter;
		} else {
			$this->setSessionWhere($filter);
			$this->CurrentFilter = "";
		}
		if ($this->isGridAdd()) {
			if ($this->CurrentMode == "copy") {
				$selectLimit = $this->UseSelectLimit;
				if ($selectLimit) {
					$this->TotalRecords = $this->listRecordCount();
					$this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
				} else {
					if ($this->Recordset = $this->loadRecordset())
						$this->TotalRecords = $this->Recordset->RecordCount();
				}
				$this->StartRecord = 1;
				$this->DisplayRecords = $this->TotalRecords;
			} else {
				$this->CurrentFilter = "0=1";
				$this->StartRecord = 1;
				$this->DisplayRecords = $this->GridAddRowCount;
			}
			$this->TotalRecords = $this->DisplayRecords;
			$this->StopRecord = $this->DisplayRecords;
		} else {
			$selectLimit = $this->UseSelectLimit;
			if ($selectLimit) {
				$this->TotalRecords = $this->listRecordCount();
			} else {
				if ($this->Recordset = $this->loadRecordset())
					$this->TotalRecords = $this->Recordset->RecordCount();
			}
			$this->StartRecord = 1;
			$this->DisplayRecords = $this->TotalRecords; // Display all records
			if ($selectLimit)
				$this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
		}

		// Normal return
		if (IsApi()) {
			$rows = $this->getRecordsFromRecordset($this->Recordset);
			$this->Recordset->close();
			WriteJson(["success" => TRUE, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
			$this->terminate(TRUE);
		}

		// Set up pager
		$this->Pager = new PrevNextPager($this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);
	}

	// Set up number of records displayed per page
	protected function setupDisplayRecords()
	{
		$wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
		if ($wrk != "") {
			if (is_numeric($wrk)) {
				$this->DisplayRecords = (int)$wrk;
			} else {
				if (SameText($wrk, "all")) { // Display all records
					$this->DisplayRecords = -1;
				} else {
					$this->DisplayRecords = 100; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecords); // Save to Session

			// Reset start position
			$this->StartRecord = 1;
			$this->setStartRecordNumber($this->StartRecord);
		}
	}

	// Exit inline mode
	protected function clearInlineMode()
	{
		$this->recommendation_score->FormValue = ""; // Clear form value
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	protected function gridAddMode()
	{
		$this->CurrentAction = "gridadd";
		$_SESSION[SESSION_INLINE_MODE] = "gridadd";
		$this->hideFieldsForAddEdit();
	}

	// Switch to Grid Edit mode
	protected function gridEditMode()
	{
		$this->CurrentAction = "gridedit";
		$_SESSION[SESSION_INLINE_MODE] = "gridedit";
		$this->hideFieldsForAddEdit();
	}

	// Perform update to grid
	public function gridUpdate()
	{
		global $Language, $CurrentForm, $FormError;
		$gridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->buildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sql = $this->getCurrentSql();
		$conn = $this->getConnection();
		if ($rs = $conn->execute($sql)) {
			$rsold = $rs->getRows();
			$rs->close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}
		$key = "";

		// Update row index and get row key
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$CurrentForm->Index = $rowindex;
			$rowkey = strval($CurrentForm->getValue($this->FormKeyName));
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction != "insertdelete") { // Skip insert then deleted rows
				$this->loadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$gridUpdate = $this->setupKeyValues($rowkey); // Set up key values
				} else {
					$gridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->emptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($gridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->getRecordFilter();
						$gridUpdate = $this->deleteRows(); // Delete this row
					} else if (!$this->validateForm()) {
						$gridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($FormError);
					} else {
						if ($rowaction == "insert") {
							$gridUpdate = $this->addRow(); // Insert this row
						} else {
							if ($rowkey != "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$gridUpdate = $this->editRow(); // Update this row
							}
						} // End update
					}
				}
				if ($gridUpdate) {
					if ($key != "")
						$key .= ", ";
					$key .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($gridUpdate) {

			// Get new recordset
			if ($rs = $conn->execute($sql)) {
				$rsnew = $rs->getRows();
				$rs->close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			$this->clearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
		}
		return $gridUpdate;
	}

	// Build filter for all keys
	protected function buildKeyFilter()
	{
		global $CurrentForm;
		$wrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$CurrentForm->Index = $rowindex;
		$thisKey = strval($CurrentForm->getValue($this->FormKeyName));
		while ($thisKey != "") {
			if ($this->setupKeyValues($thisKey)) {
				$filter = $this->getRecordFilter();
				if ($wrkFilter != "")
					$wrkFilter .= " OR ";
				$wrkFilter .= $filter;
			} else {
				$wrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$CurrentForm->Index = $rowindex;
			$thisKey = strval($CurrentForm->getValue($this->FormKeyName));
		}
		return $wrkFilter;
	}

	// Set up key values
	protected function setupKeyValues($key)
	{
		$arKeyFlds = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
		if (count($arKeyFlds) >= 1) {
			$this->id->setOldValue($arKeyFlds[0]);
			if (!is_numeric($this->id->OldValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	public function gridInsert()
	{
		global $Language, $CurrentForm, $FormError;
		$rowindex = 1;
		$gridInsert = FALSE;
		$conn = $this->getConnection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
			return FALSE;
		}

		// Init key filter
		$wrkfilter = "";
		$addcnt = 0;
		$key = "";

		// Get row count
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$CurrentForm->Index = $rowindex;
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));
			if ($rowaction != "" && $rowaction != "insert")
				continue; // Skip
			if ($rowaction == "insert") {
				$this->RowOldKey = strval($CurrentForm->getValue($this->FormOldKeyName));
				$this->loadOldRecord(); // Load old record
			}
			$this->loadFormValues(); // Get form values
			if (!$this->emptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->validateForm()) {
					$gridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($FormError);
				} else {
					$gridInsert = $this->addRow($this->OldRecordset); // Insert this row
				}
				if ($gridInsert) {
					if ($key != "")
						$key .= Config("COMPOSITE_KEY_SEPARATOR");
					$key .= $this->id->CurrentValue;

					// Add filter for this record
					$filter = $this->getRecordFilter();
					if ($wrkfilter != "")
						$wrkfilter .= " OR ";
					$wrkfilter .= $filter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->clearInlineMode(); // Clear grid add mode and return
			return TRUE;
		}
		if ($gridInsert) {

			// Get new recordset
			$this->CurrentFilter = $wrkfilter;
			$sql = $this->getCurrentSql();
			if ($rs = $conn->execute($sql)) {
				$rsnew = $rs->getRows();
				$rs->close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			$this->clearInlineMode(); // Clear grid add mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
		}
		return $gridInsert;
	}

	// Check if empty row
	public function emptyRow()
	{
		global $CurrentForm;
		if ($CurrentForm->hasValue("x_title") && $CurrentForm->hasValue("o_title") && $this->title->CurrentValue != $this->title->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_placeholder") && $CurrentForm->hasValue("o_placeholder") && $this->placeholder->CurrentValue != $this->placeholder->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_questions") && $CurrentForm->hasValue("o_questions") && $this->questions->CurrentValue != $this->questions->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_scores") && $CurrentForm->hasValue("o_scores") && $this->scores->CurrentValue != $this->scores->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_type") && $CurrentForm->hasValue("o_type") && $this->type->CurrentValue != $this->type->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_section") && $CurrentForm->hasValue("o_section") && $this->section->CurrentValue != $this->section->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_active") && $CurrentForm->hasValue("o_active") && ConvertToBool($this->active->CurrentValue) != ConvertToBool($this->active->OldValue))
			return FALSE;
		if ($CurrentForm->hasValue("x_created_at") && $CurrentForm->hasValue("o_created_at") && $this->created_at->CurrentValue != $this->created_at->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_updated_at") && $CurrentForm->hasValue("o_updated_at") && $this->updated_at->CurrentValue != $this->updated_at->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_has_recommendations") && $CurrentForm->hasValue("o_has_recommendations") && $this->has_recommendations->CurrentValue != $this->has_recommendations->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_group") && $CurrentForm->hasValue("o_group") && $this->group->CurrentValue != $this->group->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_category") && $CurrentForm->hasValue("o_category") && $this->category->CurrentValue != $this->category->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_order") && $CurrentForm->hasValue("o_order") && $this->order->CurrentValue != $this->order->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_recommendation_score") && $CurrentForm->hasValue("o_recommendation_score") && $this->recommendation_score->CurrentValue != $this->recommendation_score->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_related") && $CurrentForm->hasValue("o_related") && $this->related->CurrentValue != $this->related->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_trigger_related_val") && $CurrentForm->hasValue("o_trigger_related_val") && $this->trigger_related_val->CurrentValue != $this->trigger_related_val->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	public function validateGridForm()
	{
		global $CurrentForm;

		// Get row count
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$CurrentForm->Index = $rowindex;
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));
			if ($rowaction != "delete" && $rowaction != "insertdelete") {
				$this->loadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->emptyRow()) {

					// Ignore
				} else if (!$this->validateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	public function getGridFormValues()
	{
		global $CurrentForm;

		// Get row count
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = [];

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$CurrentForm->Index = $rowindex;
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));
			if ($rowaction != "delete" && $rowaction != "insertdelete") {
				$this->loadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->emptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->getFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	public function restoreCurrentRowFormValues($idx)
	{
		global $CurrentForm;

		// Get row based on current index
		$CurrentForm->Index = $idx;
		$this->loadFormValues(); // Load form values
	}

	// Set up sort parameters
	protected function setupSortOrder()
	{

		// Check for "order" parameter
		if (Get("order") !== NULL) {
			$this->CurrentOrder = Get("order");
			$this->CurrentOrderType = Get("ordertype", "");
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	protected function loadSortOrder()
	{
		$orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($orderBy == "") {
			if ($this->getSqlOrderBy() != "") {
				$orderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($orderBy);
				$this->section->setSort("ASC");
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)

	protected function resetCmd()
	{

		// Check if reset command
		if (StartsString("reset", $this->Command)) {

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->type->setSessionValue("");
				$this->section->setSessionValue("");
				$this->group->setSessionValue("");
				$this->category->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$orderBy = "";
				$this->setSessionOrderBy($orderBy);
			}

			// Reset start position
			$this->StartRecord = 1;
			$this->setStartRecordNumber($this->StartRecord);
		}
	}

	// Set up list options
	protected function setupListOptions()
	{
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->add("griddelete");
			$item->CssClass = "text-nowrap";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->canView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->canEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->canAdd();
		$item->OnLeft = TRUE;

		// "delete"
		$item = &$this->ListOptions->add("delete");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->canDelete();
		$item->OnLeft = TRUE;

		// Drop down button for ListOptions
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;

		//$this->ListOptions->ButtonClass = ""; // Class for button group
		// Call ListOptions_Load event

		$this->ListOptions_Load();
		$item = $this->ListOptions[$this->ListOptions->GroupOptionName];
		$item->Visible = $this->ListOptions->groupOptionVisible();
	}

	// Render list options
	public function renderListOptions()
	{
		global $Security, $Language, $CurrentForm;
		$this->ListOptions->loadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode != "view") {
			$CurrentForm->Index = $this->RowIndex;
			$actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$keyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction != "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
			if ($CurrentForm->hasValue($this->FormOldKeyName))
				$this->RowOldKey = strval($CurrentForm->getValue($this->FormOldKeyName));
			if ($this->RowOldKey != "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($this->RowOldKey) . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $CurrentForm->getValue($this->FormKeyName);
				$this->setupKeyValues($rowkey);

				// Reload hidden key for delete
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $keyName . "\" id=\"" . $keyName . "\" value=\"" . HtmlEncode($rowkey) . "\">";
			}
			if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
				$options = &$this->ListOptions;
				$options->UseButtonGroup = TRUE; // Use button group for grid delete button
				$opt = $options["griddelete"];
				if (!$Security->canDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$opt->Body = "&nbsp;";
				} else {
					$opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" onclick=\"return ew.deleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->phrase("DeleteLink") . "</a>";
				}
			}
		}
		if ($this->CurrentMode == "view") { // View mode

		// "view"
		$opt = $this->ListOptions["view"];
		$viewcaption = HtmlTitle($Language->phrase("ViewLink"));
		if ($Security->canView()) {
			if (IsMobile())
				$opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode($this->ViewUrl) . "\">" . $Language->phrase("ViewLink") . "</a>";
			else
				$opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"questions\" data-caption=\"" . $viewcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,url:'" . HtmlEncode($this->ViewUrl) . "',btn:null});\">" . $Language->phrase("ViewLink") . "</a>";
		} else {
			$opt->Body = "";
		}

		// "edit"
		$opt = $this->ListOptions["edit"];
		$editcaption = HtmlTitle($Language->phrase("EditLink"));
		if ($Security->canEdit()) {
			if (IsMobile())
				$opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode($this->EditUrl) . "\">" . $Language->phrase("EditLink") . "</a>";
			else
				$opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"questions\" data-caption=\"" . $editcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,btn:'SaveBtn',url:'" . HtmlEncode($this->EditUrl) . "'});\">" . $Language->phrase("EditLink") . "</a>";
		} else {
			$opt->Body = "";
		}

		// "copy"
		$opt = $this->ListOptions["copy"];
		$copycaption = HtmlTitle($Language->phrase("CopyLink"));
		if ($Security->canAdd()) {
			if (IsMobile())
				$opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode($this->CopyUrl) . "\">" . $Language->phrase("CopyLink") . "</a>";
			else
				$opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-table=\"questions\" data-caption=\"" . $copycaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,btn:'AddBtn',url:'" . HtmlEncode($this->CopyUrl) . "'});\">" . $Language->phrase("CopyLink") . "</a>";
		} else {
			$opt->Body = "";
		}

		// "delete"
		$opt = $this->ListOptions["delete"];
		if ($Security->canDelete())
			$opt->Body = "<a class=\"ew-row-link ew-delete\"" . " onclick=\"return ew.confirmDelete(this);\"" . " title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" href=\"" . HtmlEncode($this->DeleteUrl) . "\">" . $Language->phrase("DeleteLink") . "</a>";
		else
			$opt->Body = "";
		} // End View mode
		if ($this->CurrentMode == "edit" && is_numeric($this->RowIndex) && $this->RowAction != "delete") {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $keyName . "\" id=\"" . $keyName . "\" value=\"" . $this->id->CurrentValue . "\">";
		}
		$this->renderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set record key
	public function setRecordKey(&$key, $rs)
	{
		$key = "";
		if ($key != "")
			$key .= Config("COMPOSITE_KEY_SEPARATOR");
		$key .= $rs->fields('id');
	}

	// Set up other options
	protected function setupOtherOptions()
	{
		global $Language, $Security;
		$option = $this->OtherOptions["addedit"];
		$option->UseDropDownButton = FALSE;
		$option->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
		$option->UseButtonGroup = TRUE;

		//$option->ButtonClass = ""; // Class for button group
		$item = &$option->add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Add
		if ($this->CurrentMode == "view") { // Check view mode
			$item = &$option->add("add");
			$addcaption = HtmlTitle($Language->phrase("AddLink"));
			$this->AddUrl = $this->getAddUrl();
			if (IsMobile())
				$item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode($this->AddUrl) . "\">" . $Language->phrase("AddLink") . "</a>";
			else
				$item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"questions\" data-caption=\"" . $addcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,btn:'AddBtn',url:'" . HtmlEncode($this->AddUrl) . "'});\">" . $Language->phrase("AddLink") . "</a>";
			$item->Visible = $this->AddUrl != "" && $Security->canAdd();
		}
	}

	// Render other options
	public function renderOtherOptions()
	{
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if (($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") && !$this->isConfirm()) { // Check add/copy/edit mode
			if ($this->AllowAddDeleteRow) {
				$option = $options["addedit"];
				$option->UseDropDownButton = FALSE;
				$item = &$option->add("addblankrow");
				$item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" href=\"#\" onclick=\"return ew.addGridRow(this);\">" . $Language->phrase("AddBlankRow") . "</a>";
				$item->Visible = $Security->canAdd();
				$this->ShowOtherOptions = $item->Visible;
			}
		}
		if ($this->CurrentMode == "view") { // Check view mode
			$option = $options["addedit"];
			$item = $option["add"];
			$this->ShowOtherOptions = $item && $item->Visible;
		}
	}

	// Set up list options (extended codes)
	protected function setupListOptionsExt()
	{
	}

	// Render list options (extended codes)
	protected function renderListOptionsExt()
	{
	}

	// Get upload files
	protected function getUploadFiles()
	{
		global $CurrentForm, $Language;
	}

	// Load default values
	protected function loadDefaultValues()
	{
		$this->id->CurrentValue = NULL;
		$this->id->OldValue = $this->id->CurrentValue;
		$this->title->CurrentValue = NULL;
		$this->title->OldValue = $this->title->CurrentValue;
		$this->placeholder->CurrentValue = NULL;
		$this->placeholder->OldValue = $this->placeholder->CurrentValue;
		$this->questions->CurrentValue = NULL;
		$this->questions->OldValue = $this->questions->CurrentValue;
		$this->scores->CurrentValue = NULL;
		$this->scores->OldValue = $this->scores->CurrentValue;
		$this->type->CurrentValue = NULL;
		$this->type->OldValue = $this->type->CurrentValue;
		$this->section->CurrentValue = NULL;
		$this->section->OldValue = $this->section->CurrentValue;
		$this->active->CurrentValue = NULL;
		$this->active->OldValue = $this->active->CurrentValue;
		$this->created_at->CurrentValue = NULL;
		$this->created_at->OldValue = $this->created_at->CurrentValue;
		$this->updated_at->CurrentValue = NULL;
		$this->updated_at->OldValue = $this->updated_at->CurrentValue;
		$this->has_recommendations->CurrentValue = NULL;
		$this->has_recommendations->OldValue = $this->has_recommendations->CurrentValue;
		$this->group->CurrentValue = NULL;
		$this->group->OldValue = $this->group->CurrentValue;
		$this->category->CurrentValue = NULL;
		$this->category->OldValue = $this->category->CurrentValue;
		$this->order->CurrentValue = NULL;
		$this->order->OldValue = $this->order->CurrentValue;
		$this->recommendation_by_score->CurrentValue = NULL;
		$this->recommendation_by_score->OldValue = $this->recommendation_by_score->CurrentValue;
		$this->recommendation_score->CurrentValue = NULL;
		$this->recommendation_score->OldValue = $this->recommendation_score->CurrentValue;
		$this->related->CurrentValue = NULL;
		$this->related->OldValue = $this->related->CurrentValue;
		$this->trigger_related_val->CurrentValue = NULL;
		$this->trigger_related_val->OldValue = $this->trigger_related_val->CurrentValue;
	}

	// Load form values
	protected function loadFormValues()
	{

		// Load from form
		global $CurrentForm;
		$CurrentForm->FormName = $this->FormName;

		// Check field name 'id' first before field var 'x_id'
		$val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
		if (!$this->id->IsDetailKey && !$this->isGridAdd() && !$this->isAdd())
			$this->id->setFormValue($val);

		// Check field name 'title' first before field var 'x_title'
		$val = $CurrentForm->hasValue("title") ? $CurrentForm->getValue("title") : $CurrentForm->getValue("x_title");
		if (!$this->title->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->title->Visible = FALSE; // Disable update for API request
			else
				$this->title->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_title"))
			$this->title->setOldValue($CurrentForm->getValue("o_title"));

		// Check field name 'placeholder' first before field var 'x_placeholder'
		$val = $CurrentForm->hasValue("placeholder") ? $CurrentForm->getValue("placeholder") : $CurrentForm->getValue("x_placeholder");
		if (!$this->placeholder->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->placeholder->Visible = FALSE; // Disable update for API request
			else
				$this->placeholder->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_placeholder"))
			$this->placeholder->setOldValue($CurrentForm->getValue("o_placeholder"));

		// Check field name 'questions' first before field var 'x_questions'
		$val = $CurrentForm->hasValue("questions") ? $CurrentForm->getValue("questions") : $CurrentForm->getValue("x_questions");
		if (!$this->questions->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->questions->Visible = FALSE; // Disable update for API request
			else
				$this->questions->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_questions"))
			$this->questions->setOldValue($CurrentForm->getValue("o_questions"));

		// Check field name 'scores' first before field var 'x_scores'
		$val = $CurrentForm->hasValue("scores") ? $CurrentForm->getValue("scores") : $CurrentForm->getValue("x_scores");
		if (!$this->scores->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->scores->Visible = FALSE; // Disable update for API request
			else
				$this->scores->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_scores"))
			$this->scores->setOldValue($CurrentForm->getValue("o_scores"));

		// Check field name 'type' first before field var 'x_type'
		$val = $CurrentForm->hasValue("type") ? $CurrentForm->getValue("type") : $CurrentForm->getValue("x_type");
		if (!$this->type->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->type->Visible = FALSE; // Disable update for API request
			else
				$this->type->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_type"))
			$this->type->setOldValue($CurrentForm->getValue("o_type"));

		// Check field name 'section' first before field var 'x_section'
		$val = $CurrentForm->hasValue("section") ? $CurrentForm->getValue("section") : $CurrentForm->getValue("x_section");
		if (!$this->section->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->section->Visible = FALSE; // Disable update for API request
			else
				$this->section->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_section"))
			$this->section->setOldValue($CurrentForm->getValue("o_section"));

		// Check field name 'active' first before field var 'x_active'
		$val = $CurrentForm->hasValue("active") ? $CurrentForm->getValue("active") : $CurrentForm->getValue("x_active");
		if (!$this->active->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->active->Visible = FALSE; // Disable update for API request
			else
				$this->active->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_active"))
			$this->active->setOldValue($CurrentForm->getValue("o_active"));

		// Check field name 'created_at' first before field var 'x_created_at'
		$val = $CurrentForm->hasValue("created_at") ? $CurrentForm->getValue("created_at") : $CurrentForm->getValue("x_created_at");
		if (!$this->created_at->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->created_at->Visible = FALSE; // Disable update for API request
			else
				$this->created_at->setFormValue($val);
			$this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
		}
		if ($CurrentForm->hasValue("o_created_at"))
			$this->created_at->setOldValue($CurrentForm->getValue("o_created_at"));

		// Check field name 'updated_at' first before field var 'x_updated_at'
		$val = $CurrentForm->hasValue("updated_at") ? $CurrentForm->getValue("updated_at") : $CurrentForm->getValue("x_updated_at");
		if (!$this->updated_at->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->updated_at->Visible = FALSE; // Disable update for API request
			else
				$this->updated_at->setFormValue($val);
			$this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, 0);
		}
		if ($CurrentForm->hasValue("o_updated_at"))
			$this->updated_at->setOldValue($CurrentForm->getValue("o_updated_at"));

		// Check field name 'has_recommendations' first before field var 'x_has_recommendations'
		$val = $CurrentForm->hasValue("has_recommendations") ? $CurrentForm->getValue("has_recommendations") : $CurrentForm->getValue("x_has_recommendations");
		if (!$this->has_recommendations->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->has_recommendations->Visible = FALSE; // Disable update for API request
			else
				$this->has_recommendations->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_has_recommendations"))
			$this->has_recommendations->setOldValue($CurrentForm->getValue("o_has_recommendations"));

		// Check field name 'group' first before field var 'x_group'
		$val = $CurrentForm->hasValue("group") ? $CurrentForm->getValue("group") : $CurrentForm->getValue("x_group");
		if (!$this->group->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->group->Visible = FALSE; // Disable update for API request
			else
				$this->group->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_group"))
			$this->group->setOldValue($CurrentForm->getValue("o_group"));

		// Check field name 'category' first before field var 'x_category'
		$val = $CurrentForm->hasValue("category") ? $CurrentForm->getValue("category") : $CurrentForm->getValue("x_category");
		if (!$this->category->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->category->Visible = FALSE; // Disable update for API request
			else
				$this->category->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_category"))
			$this->category->setOldValue($CurrentForm->getValue("o_category"));

		// Check field name 'order' first before field var 'x_order'
		$val = $CurrentForm->hasValue("order") ? $CurrentForm->getValue("order") : $CurrentForm->getValue("x_order");
		if (!$this->order->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->order->Visible = FALSE; // Disable update for API request
			else
				$this->order->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_order"))
			$this->order->setOldValue($CurrentForm->getValue("o_order"));

		// Check field name 'recommendation_score' first before field var 'x_recommendation_score'
		$val = $CurrentForm->hasValue("recommendation_score") ? $CurrentForm->getValue("recommendation_score") : $CurrentForm->getValue("x_recommendation_score");
		if (!$this->recommendation_score->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->recommendation_score->Visible = FALSE; // Disable update for API request
			else
				$this->recommendation_score->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_recommendation_score"))
			$this->recommendation_score->setOldValue($CurrentForm->getValue("o_recommendation_score"));

		// Check field name 'related' first before field var 'x_related'
		$val = $CurrentForm->hasValue("related") ? $CurrentForm->getValue("related") : $CurrentForm->getValue("x_related");
		if (!$this->related->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->related->Visible = FALSE; // Disable update for API request
			else
				$this->related->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_related"))
			$this->related->setOldValue($CurrentForm->getValue("o_related"));

		// Check field name 'trigger_related_val' first before field var 'x_trigger_related_val'
		$val = $CurrentForm->hasValue("trigger_related_val") ? $CurrentForm->getValue("trigger_related_val") : $CurrentForm->getValue("x_trigger_related_val");
		if (!$this->trigger_related_val->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->trigger_related_val->Visible = FALSE; // Disable update for API request
			else
				$this->trigger_related_val->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_trigger_related_val"))
			$this->trigger_related_val->setOldValue($CurrentForm->getValue("o_trigger_related_val"));
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		if (!$this->isGridAdd() && !$this->isAdd())
			$this->id->CurrentValue = $this->id->FormValue;
		$this->title->CurrentValue = $this->title->FormValue;
		$this->placeholder->CurrentValue = $this->placeholder->FormValue;
		$this->questions->CurrentValue = $this->questions->FormValue;
		$this->scores->CurrentValue = $this->scores->FormValue;
		$this->type->CurrentValue = $this->type->FormValue;
		$this->section->CurrentValue = $this->section->FormValue;
		$this->active->CurrentValue = $this->active->FormValue;
		$this->created_at->CurrentValue = $this->created_at->FormValue;
		$this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
		$this->updated_at->CurrentValue = $this->updated_at->FormValue;
		$this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, 0);
		$this->has_recommendations->CurrentValue = $this->has_recommendations->FormValue;
		$this->group->CurrentValue = $this->group->FormValue;
		$this->category->CurrentValue = $this->category->FormValue;
		$this->order->CurrentValue = $this->order->FormValue;
		$this->recommendation_score->CurrentValue = $this->recommendation_score->FormValue;
		$this->related->CurrentValue = $this->related->FormValue;
		$this->trigger_related_val->CurrentValue = $this->trigger_related_val->FormValue;
	}

	// Load recordset
	public function loadRecordset($offset = -1, $rowcnt = -1)
	{

		// Load List page SQL
		$sql = $this->getListSql();
		$conn = $this->getConnection();

		// Load recordset
		$dbtype = GetConnectionType($this->Dbid);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = Config("ERROR_FUNC");
			if ($dbtype == "MSSQL") {
				$rs = $conn->selectLimit($sql, $rowcnt, $offset, ["_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())]);
			} else {
				$rs = $conn->selectLimit($sql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = "";
		} else {
			$rs = LoadRecordset($sql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	public function loadRow()
	{
		global $Security, $Language;
		$filter = $this->getRecordFilter();

		// Call Row Selecting event
		$this->Row_Selecting($filter);

		// Load SQL based on filter
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn = $this->getConnection();
		$res = FALSE;
		$rs = LoadRecordset($sql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->loadRowValues($rs); // Load row values
			$rs->close();
		}
		return $res;
	}

	// Load row values from recordset
	public function loadRowValues($rs = NULL)
	{
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->newRow();

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->id->setDbValue($row['id']);
		$this->title->setDbValue($row['title']);
		$this->placeholder->setDbValue($row['placeholder']);
		$this->questions->setDbValue($row['questions']);
		$this->scores->setDbValue($row['scores']);
		$this->type->setDbValue($row['type']);
		$this->section->setDbValue($row['section']);
		$this->active->setDbValue($row['active']);
		$this->created_at->setDbValue($row['created_at']);
		$this->updated_at->setDbValue($row['updated_at']);
		$this->has_recommendations->setDbValue($row['has_recommendations']);
		$this->group->setDbValue($row['group']);
		$this->category->setDbValue($row['category']);
		$this->order->setDbValue($row['order']);
		$this->recommendation_by_score->setDbValue($row['recommendation_by_score']);
		$this->recommendation_score->setDbValue($row['recommendation_score']);
		$this->related->setDbValue($row['related']);
		$this->trigger_related_val->setDbValue($row['trigger_related_val']);
	}

	// Return a row with default values
	protected function newRow()
	{
		$this->loadDefaultValues();
		$row = [];
		$row['id'] = $this->id->CurrentValue;
		$row['title'] = $this->title->CurrentValue;
		$row['placeholder'] = $this->placeholder->CurrentValue;
		$row['questions'] = $this->questions->CurrentValue;
		$row['scores'] = $this->scores->CurrentValue;
		$row['type'] = $this->type->CurrentValue;
		$row['section'] = $this->section->CurrentValue;
		$row['active'] = $this->active->CurrentValue;
		$row['created_at'] = $this->created_at->CurrentValue;
		$row['updated_at'] = $this->updated_at->CurrentValue;
		$row['has_recommendations'] = $this->has_recommendations->CurrentValue;
		$row['group'] = $this->group->CurrentValue;
		$row['category'] = $this->category->CurrentValue;
		$row['order'] = $this->order->CurrentValue;
		$row['recommendation_by_score'] = $this->recommendation_by_score->CurrentValue;
		$row['recommendation_score'] = $this->recommendation_score->CurrentValue;
		$row['related'] = $this->related->CurrentValue;
		$row['trigger_related_val'] = $this->trigger_related_val->CurrentValue;
		return $row;
	}

	// Load old record
	protected function loadOldRecord()
	{

		// Load key values from Session
		$validKey = TRUE;
		$keys = [$this->RowOldKey];
		$cnt = count($keys);
		if ($cnt >= 1) {
			if (strval($keys[0]) != "")
				$this->id->OldValue = strval($keys[0]); // id
			else
				$validKey = FALSE;
		} else {
			$validKey = FALSE;
		}

		// Load old record
		$this->OldRecordset = NULL;
		if ($validKey) {
			$this->CurrentFilter = $this->getRecordFilter();
			$sql = $this->getCurrentSql();
			$conn = $this->getConnection();
			$this->OldRecordset = LoadRecordset($sql, $conn);
		}
		$this->loadRowValues($this->OldRecordset); // Load row values
		return $validKey;
	}

	// Render row values based on field settings
	public function renderRow()
	{
		global $Security, $Language, $CurrentLanguage;

		// Initialize URLs
		$this->ViewUrl = $this->getViewUrl();
		$this->EditUrl = $this->getEditUrl();
		$this->CopyUrl = $this->getCopyUrl();
		$this->DeleteUrl = $this->getDeleteUrl();

		// Convert decimal values if posted back
		if ($this->recommendation_score->FormValue == $this->recommendation_score->CurrentValue && is_numeric(ConvertToFloatString($this->recommendation_score->CurrentValue)))
			$this->recommendation_score->CurrentValue = ConvertToFloatString($this->recommendation_score->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// title
		// placeholder
		// questions
		// scores
		// type
		// section
		// active
		// created_at
		// updated_at
		// has_recommendations
		// group
		// category
		// order
		// recommendation_by_score
		// recommendation_score
		// related
		// trigger_related_val

		if ($this->RowType == ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewValue = FormatNumber($this->id->ViewValue, 0, -2, -2, -2);
			$this->id->ViewCustomAttributes = "";

			// title
			$this->title->ViewValue = $this->title->CurrentValue;
			$this->title->ViewCustomAttributes = "";

			// placeholder
			$this->placeholder->ViewValue = $this->placeholder->CurrentValue;
			$this->placeholder->ViewCustomAttributes = "";

			// questions
			$this->questions->ViewValue = $this->questions->CurrentValue;
			$this->questions->ViewCustomAttributes = "";

			// scores
			$this->scores->ViewValue = $this->scores->CurrentValue;
			$this->scores->ViewCustomAttributes = "";

			// type
			$curVal = strval($this->type->CurrentValue);
			if ($curVal != "") {
				$this->type->ViewValue = $this->type->lookupCacheOption($curVal);
				if ($this->type->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->type->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$this->type->ViewValue = $this->type->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->type->ViewValue = $this->type->CurrentValue;
					}
				}
			} else {
				$this->type->ViewValue = NULL;
			}
			$this->type->ViewCustomAttributes = "";

			// section
			$this->section->ViewValue = $this->section->CurrentValue;
			$curVal = strval($this->section->CurrentValue);
			if ($curVal != "") {
				$this->section->ViewValue = $this->section->lookupCacheOption($curVal);
				if ($this->section->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->section->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = FormatNumber($rswrk->fields('df'), 0, -2, -2, -2);
						$arwrk[2] = $rswrk->fields('df2');
						$this->section->ViewValue = $this->section->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->section->ViewValue = $this->section->CurrentValue;
					}
				}
			} else {
				$this->section->ViewValue = NULL;
			}
			$this->section->ViewCustomAttributes = "";

			// active
			if (ConvertToBool($this->active->CurrentValue)) {
				$this->active->ViewValue = $this->active->tagCaption(1) != "" ? $this->active->tagCaption(1) : "Yes";
			} else {
				$this->active->ViewValue = $this->active->tagCaption(2) != "" ? $this->active->tagCaption(2) : "No";
			}
			$this->active->ViewCustomAttributes = "";

			// created_at
			$this->created_at->ViewValue = $this->created_at->CurrentValue;
			$this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
			$this->created_at->ViewCustomAttributes = "";

			// updated_at
			$this->updated_at->ViewValue = $this->updated_at->CurrentValue;
			$this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
			$this->updated_at->ViewCustomAttributes = "";

			// has_recommendations
			if (strval($this->has_recommendations->CurrentValue) != "") {
				$this->has_recommendations->ViewValue = new OptionValues();
				$arwrk = explode(",", strval($this->has_recommendations->CurrentValue));
				$cnt = count($arwrk);
				for ($ari = 0; $ari < $cnt; $ari++)
					$this->has_recommendations->ViewValue->add($this->has_recommendations->optionCaption(trim($arwrk[$ari])));
			} else {
				$this->has_recommendations->ViewValue = NULL;
			}
			$this->has_recommendations->ViewCustomAttributes = "";

			// group
			$curVal = strval($this->group->CurrentValue);
			if ($curVal != "") {
				$this->group->ViewValue = $this->group->lookupCacheOption($curVal);
				if ($this->group->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->group->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$this->group->ViewValue = $this->group->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->group->ViewValue = $this->group->CurrentValue;
					}
				}
			} else {
				$this->group->ViewValue = NULL;
			}
			$this->group->ViewCustomAttributes = "";

			// category
			$curVal = strval($this->category->CurrentValue);
			if ($curVal != "") {
				$this->category->ViewValue = $this->category->lookupCacheOption($curVal);
				if ($this->category->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->category->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$this->category->ViewValue = $this->category->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->category->ViewValue = $this->category->CurrentValue;
					}
				}
			} else {
				$this->category->ViewValue = NULL;
			}
			$this->category->ViewCustomAttributes = "";

			// order
			$this->order->ViewValue = $this->order->CurrentValue;
			$this->order->ViewValue = FormatNumber($this->order->ViewValue, 0, -2, -2, -2);
			$this->order->ViewCustomAttributes = "";

			// recommendation_score
			$this->recommendation_score->ViewValue = $this->recommendation_score->CurrentValue;
			$this->recommendation_score->ViewValue = FormatNumber($this->recommendation_score->ViewValue, 2, -2, -2, -2);
			$this->recommendation_score->ViewCustomAttributes = "";

			// related
			$this->related->ViewValue = $this->related->CurrentValue;
			$this->related->ViewValue = FormatNumber($this->related->ViewValue, 0, -2, -2, -2);
			$this->related->ViewCustomAttributes = "";

			// trigger_related_val
			$this->trigger_related_val->ViewValue = $this->trigger_related_val->CurrentValue;
			$this->trigger_related_val->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";
			$this->title->TooltipValue = "";

			// placeholder
			$this->placeholder->LinkCustomAttributes = "";
			$this->placeholder->HrefValue = "";
			$this->placeholder->TooltipValue = "";

			// questions
			$this->questions->LinkCustomAttributes = "";
			$this->questions->HrefValue = "";
			$this->questions->TooltipValue = "";

			// scores
			$this->scores->LinkCustomAttributes = "";
			$this->scores->HrefValue = "";
			$this->scores->TooltipValue = "";

			// type
			$this->type->LinkCustomAttributes = "";
			$this->type->HrefValue = "";
			$this->type->TooltipValue = "";

			// section
			$this->section->LinkCustomAttributes = "";
			$this->section->HrefValue = "";
			$this->section->TooltipValue = "";

			// active
			$this->active->LinkCustomAttributes = "";
			$this->active->HrefValue = "";
			$this->active->TooltipValue = "";

			// created_at
			$this->created_at->LinkCustomAttributes = "";
			$this->created_at->HrefValue = "";
			$this->created_at->TooltipValue = "";

			// updated_at
			$this->updated_at->LinkCustomAttributes = "";
			$this->updated_at->HrefValue = "";
			$this->updated_at->TooltipValue = "";

			// has_recommendations
			$this->has_recommendations->LinkCustomAttributes = "";
			$this->has_recommendations->HrefValue = "";
			$this->has_recommendations->TooltipValue = "";

			// group
			$this->group->LinkCustomAttributes = "";
			$this->group->HrefValue = "";
			$this->group->TooltipValue = "";

			// category
			$this->category->LinkCustomAttributes = "";
			$this->category->HrefValue = "";
			$this->category->TooltipValue = "";

			// order
			$this->order->LinkCustomAttributes = "";
			$this->order->HrefValue = "";
			$this->order->TooltipValue = "";

			// recommendation_score
			$this->recommendation_score->LinkCustomAttributes = "";
			$this->recommendation_score->HrefValue = "";
			$this->recommendation_score->TooltipValue = "";

			// related
			$this->related->LinkCustomAttributes = "";
			$this->related->HrefValue = "";
			$this->related->TooltipValue = "";

			// trigger_related_val
			$this->trigger_related_val->LinkCustomAttributes = "";
			$this->trigger_related_val->HrefValue = "";
			$this->trigger_related_val->TooltipValue = "";
		} elseif ($this->RowType == ROWTYPE_ADD) { // Add row

			// id
			// title

			$this->title->EditAttrs["class"] = "form-control";
			$this->title->EditCustomAttributes = "";
			if (!$this->title->Raw)
				$this->title->CurrentValue = HtmlDecode($this->title->CurrentValue);
			$this->title->EditValue = HtmlEncode($this->title->CurrentValue);
			$this->title->PlaceHolder = RemoveHtml($this->title->caption());

			// placeholder
			$this->placeholder->EditAttrs["class"] = "form-control";
			$this->placeholder->EditCustomAttributes = "";
			$this->placeholder->EditValue = HtmlEncode($this->placeholder->CurrentValue);
			$this->placeholder->PlaceHolder = RemoveHtml($this->placeholder->caption());

			// questions
			$this->questions->EditAttrs["class"] = "form-control";
			$this->questions->EditCustomAttributes = "";
			$this->questions->EditValue = HtmlEncode($this->questions->CurrentValue);
			$this->questions->PlaceHolder = RemoveHtml($this->questions->caption());

			// scores
			$this->scores->EditAttrs["class"] = "form-control";
			$this->scores->EditCustomAttributes = "";
			$this->scores->EditValue = HtmlEncode($this->scores->CurrentValue);
			$this->scores->PlaceHolder = RemoveHtml($this->scores->caption());

			// type
			$this->type->EditCustomAttributes = "";
			if ($this->type->getSessionValue() != "") {
				$this->type->CurrentValue = $this->type->getSessionValue();
				$this->type->OldValue = $this->type->CurrentValue;
				$curVal = strval($this->type->CurrentValue);
				if ($curVal != "") {
					$this->type->ViewValue = $this->type->lookupCacheOption($curVal);
					if ($this->type->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->type->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->type->ViewValue = $this->type->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->type->ViewValue = $this->type->CurrentValue;
						}
					}
				} else {
					$this->type->ViewValue = NULL;
				}
				$this->type->ViewCustomAttributes = "";
			} else {
				$curVal = trim(strval($this->type->CurrentValue));
				if ($curVal != "")
					$this->type->ViewValue = $this->type->lookupCacheOption($curVal);
				else
					$this->type->ViewValue = $this->type->Lookup !== NULL && is_array($this->type->Lookup->Options) ? $curVal : NULL;
				if ($this->type->ViewValue !== NULL) { // Load from cache
					$this->type->EditValue = array_values($this->type->Lookup->Options);
					if ($this->type->ViewValue == "")
						$this->type->ViewValue = $Language->phrase("PleaseSelect");
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`id`" . SearchString("=", $this->type->CurrentValue, DATATYPE_NUMBER, "");
					}
					$sqlWrk = $this->type->Lookup->getSql(TRUE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = HtmlEncode($rswrk->fields('df'));
						$this->type->ViewValue = $this->type->displayValue($arwrk);
					} else {
						$this->type->ViewValue = $Language->phrase("PleaseSelect");
					}
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->type->EditValue = $arwrk;
				}
			}

			// section
			$this->section->EditAttrs["class"] = "form-control";
			$this->section->EditCustomAttributes = "";
			if ($this->section->getSessionValue() != "") {
				$this->section->CurrentValue = $this->section->getSessionValue();
				$this->section->OldValue = $this->section->CurrentValue;
				$this->section->ViewValue = $this->section->CurrentValue;
				$curVal = strval($this->section->CurrentValue);
				if ($curVal != "") {
					$this->section->ViewValue = $this->section->lookupCacheOption($curVal);
					if ($this->section->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->section->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = FormatNumber($rswrk->fields('df'), 0, -2, -2, -2);
							$arwrk[2] = $rswrk->fields('df2');
							$this->section->ViewValue = $this->section->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->section->ViewValue = $this->section->CurrentValue;
						}
					}
				} else {
					$this->section->ViewValue = NULL;
				}
				$this->section->ViewCustomAttributes = "";
			} else {
				$this->section->EditValue = HtmlEncode($this->section->CurrentValue);
				$curVal = strval($this->section->CurrentValue);
				if ($curVal != "") {
					$this->section->EditValue = $this->section->lookupCacheOption($curVal);
					if ($this->section->EditValue === NULL) { // Lookup from database
						$filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->section->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = HtmlEncode(FormatNumber($rswrk->fields('df'), 0, -2, -2, -2));
							$arwrk[2] = HtmlEncode($rswrk->fields('df2'));
							$this->section->EditValue = $this->section->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->section->EditValue = HtmlEncode($this->section->CurrentValue);
						}
					}
				} else {
					$this->section->EditValue = NULL;
				}
				$this->section->PlaceHolder = RemoveHtml($this->section->caption());
			}

			// active
			$this->active->EditCustomAttributes = "";
			$this->active->EditValue = $this->active->options(FALSE);

			// created_at
			$this->created_at->EditAttrs["class"] = "form-control";
			$this->created_at->EditCustomAttributes = "";
			$this->created_at->EditValue = HtmlEncode(FormatDateTime($this->created_at->CurrentValue, 8));
			$this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

			// updated_at
			$this->updated_at->EditAttrs["class"] = "form-control";
			$this->updated_at->EditCustomAttributes = "";
			$this->updated_at->EditValue = HtmlEncode(FormatDateTime($this->updated_at->CurrentValue, 8));
			$this->updated_at->PlaceHolder = RemoveHtml($this->updated_at->caption());

			// has_recommendations
			$this->has_recommendations->EditCustomAttributes = "";
			$this->has_recommendations->EditValue = $this->has_recommendations->options(FALSE);

			// group
			$this->group->EditAttrs["class"] = "form-control";
			$this->group->EditCustomAttributes = "";
			if ($this->group->getSessionValue() != "") {
				$this->group->CurrentValue = $this->group->getSessionValue();
				$this->group->OldValue = $this->group->CurrentValue;
				$curVal = strval($this->group->CurrentValue);
				if ($curVal != "") {
					$this->group->ViewValue = $this->group->lookupCacheOption($curVal);
					if ($this->group->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->group->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->group->ViewValue = $this->group->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->group->ViewValue = $this->group->CurrentValue;
						}
					}
				} else {
					$this->group->ViewValue = NULL;
				}
				$this->group->ViewCustomAttributes = "";
			} else {
				$curVal = trim(strval($this->group->CurrentValue));
				if ($curVal != "")
					$this->group->ViewValue = $this->group->lookupCacheOption($curVal);
				else
					$this->group->ViewValue = $this->group->Lookup !== NULL && is_array($this->group->Lookup->Options) ? $curVal : NULL;
				if ($this->group->ViewValue !== NULL) { // Load from cache
					$this->group->EditValue = array_values($this->group->Lookup->Options);
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`id`" . SearchString("=", $this->group->CurrentValue, DATATYPE_NUMBER, "");
					}
					$sqlWrk = $this->group->Lookup->getSql(TRUE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->group->EditValue = $arwrk;
				}
			}

			// category
			$this->category->EditAttrs["class"] = "form-control";
			$this->category->EditCustomAttributes = "";
			if ($this->category->getSessionValue() != "") {
				$this->category->CurrentValue = $this->category->getSessionValue();
				$this->category->OldValue = $this->category->CurrentValue;
				$curVal = strval($this->category->CurrentValue);
				if ($curVal != "") {
					$this->category->ViewValue = $this->category->lookupCacheOption($curVal);
					if ($this->category->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->category->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->category->ViewValue = $this->category->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->category->ViewValue = $this->category->CurrentValue;
						}
					}
				} else {
					$this->category->ViewValue = NULL;
				}
				$this->category->ViewCustomAttributes = "";
			} else {
				$curVal = trim(strval($this->category->CurrentValue));
				if ($curVal != "")
					$this->category->ViewValue = $this->category->lookupCacheOption($curVal);
				else
					$this->category->ViewValue = $this->category->Lookup !== NULL && is_array($this->category->Lookup->Options) ? $curVal : NULL;
				if ($this->category->ViewValue !== NULL) { // Load from cache
					$this->category->EditValue = array_values($this->category->Lookup->Options);
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`id`" . SearchString("=", $this->category->CurrentValue, DATATYPE_NUMBER, "");
					}
					$sqlWrk = $this->category->Lookup->getSql(TRUE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->category->EditValue = $arwrk;
				}
			}

			// order
			$this->order->EditAttrs["class"] = "form-control";
			$this->order->EditCustomAttributes = "";
			$this->order->EditValue = HtmlEncode($this->order->CurrentValue);
			$this->order->PlaceHolder = RemoveHtml($this->order->caption());

			// recommendation_score
			$this->recommendation_score->EditAttrs["class"] = "form-control";
			$this->recommendation_score->EditCustomAttributes = "";
			$this->recommendation_score->EditValue = HtmlEncode($this->recommendation_score->CurrentValue);
			$this->recommendation_score->PlaceHolder = RemoveHtml($this->recommendation_score->caption());
			if (strval($this->recommendation_score->EditValue) != "" && is_numeric($this->recommendation_score->EditValue)) {
				$this->recommendation_score->EditValue = FormatNumber($this->recommendation_score->EditValue, -2, -2, -2, -2);
				$this->recommendation_score->OldValue = $this->recommendation_score->EditValue;
			}
			

			// related
			$this->related->EditAttrs["class"] = "form-control";
			$this->related->EditCustomAttributes = "";
			$this->related->EditValue = HtmlEncode($this->related->CurrentValue);
			$this->related->PlaceHolder = RemoveHtml($this->related->caption());

			// trigger_related_val
			$this->trigger_related_val->EditAttrs["class"] = "form-control";
			$this->trigger_related_val->EditCustomAttributes = "";
			if (!$this->trigger_related_val->Raw)
				$this->trigger_related_val->CurrentValue = HtmlDecode($this->trigger_related_val->CurrentValue);
			$this->trigger_related_val->EditValue = HtmlEncode($this->trigger_related_val->CurrentValue);
			$this->trigger_related_val->PlaceHolder = RemoveHtml($this->trigger_related_val->caption());

			// Add refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";

			// placeholder
			$this->placeholder->LinkCustomAttributes = "";
			$this->placeholder->HrefValue = "";

			// questions
			$this->questions->LinkCustomAttributes = "";
			$this->questions->HrefValue = "";

			// scores
			$this->scores->LinkCustomAttributes = "";
			$this->scores->HrefValue = "";

			// type
			$this->type->LinkCustomAttributes = "";
			$this->type->HrefValue = "";

			// section
			$this->section->LinkCustomAttributes = "";
			$this->section->HrefValue = "";

			// active
			$this->active->LinkCustomAttributes = "";
			$this->active->HrefValue = "";

			// created_at
			$this->created_at->LinkCustomAttributes = "";
			$this->created_at->HrefValue = "";

			// updated_at
			$this->updated_at->LinkCustomAttributes = "";
			$this->updated_at->HrefValue = "";

			// has_recommendations
			$this->has_recommendations->LinkCustomAttributes = "";
			$this->has_recommendations->HrefValue = "";

			// group
			$this->group->LinkCustomAttributes = "";
			$this->group->HrefValue = "";

			// category
			$this->category->LinkCustomAttributes = "";
			$this->category->HrefValue = "";

			// order
			$this->order->LinkCustomAttributes = "";
			$this->order->HrefValue = "";

			// recommendation_score
			$this->recommendation_score->LinkCustomAttributes = "";
			$this->recommendation_score->HrefValue = "";

			// related
			$this->related->LinkCustomAttributes = "";
			$this->related->HrefValue = "";

			// trigger_related_val
			$this->trigger_related_val->LinkCustomAttributes = "";
			$this->trigger_related_val->HrefValue = "";
		} elseif ($this->RowType == ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->EditValue = FormatNumber($this->id->EditValue, 0, -2, -2, -2);
			$this->id->ViewCustomAttributes = "";

			// title
			$this->title->EditAttrs["class"] = "form-control";
			$this->title->EditCustomAttributes = "";
			if (!$this->title->Raw)
				$this->title->CurrentValue = HtmlDecode($this->title->CurrentValue);
			$this->title->EditValue = HtmlEncode($this->title->CurrentValue);
			$this->title->PlaceHolder = RemoveHtml($this->title->caption());

			// placeholder
			$this->placeholder->EditAttrs["class"] = "form-control";
			$this->placeholder->EditCustomAttributes = "";
			$this->placeholder->EditValue = HtmlEncode($this->placeholder->CurrentValue);
			$this->placeholder->PlaceHolder = RemoveHtml($this->placeholder->caption());

			// questions
			$this->questions->EditAttrs["class"] = "form-control";
			$this->questions->EditCustomAttributes = "";
			$this->questions->EditValue = HtmlEncode($this->questions->CurrentValue);
			$this->questions->PlaceHolder = RemoveHtml($this->questions->caption());

			// scores
			$this->scores->EditAttrs["class"] = "form-control";
			$this->scores->EditCustomAttributes = "";
			$this->scores->EditValue = HtmlEncode($this->scores->CurrentValue);
			$this->scores->PlaceHolder = RemoveHtml($this->scores->caption());

			// type
			$this->type->EditCustomAttributes = "";
			if ($this->type->getSessionValue() != "") {
				$this->type->CurrentValue = $this->type->getSessionValue();
				$this->type->OldValue = $this->type->CurrentValue;
				$curVal = strval($this->type->CurrentValue);
				if ($curVal != "") {
					$this->type->ViewValue = $this->type->lookupCacheOption($curVal);
					if ($this->type->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->type->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->type->ViewValue = $this->type->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->type->ViewValue = $this->type->CurrentValue;
						}
					}
				} else {
					$this->type->ViewValue = NULL;
				}
				$this->type->ViewCustomAttributes = "";
			} else {
				$curVal = trim(strval($this->type->CurrentValue));
				if ($curVal != "")
					$this->type->ViewValue = $this->type->lookupCacheOption($curVal);
				else
					$this->type->ViewValue = $this->type->Lookup !== NULL && is_array($this->type->Lookup->Options) ? $curVal : NULL;
				if ($this->type->ViewValue !== NULL) { // Load from cache
					$this->type->EditValue = array_values($this->type->Lookup->Options);
					if ($this->type->ViewValue == "")
						$this->type->ViewValue = $Language->phrase("PleaseSelect");
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`id`" . SearchString("=", $this->type->CurrentValue, DATATYPE_NUMBER, "");
					}
					$sqlWrk = $this->type->Lookup->getSql(TRUE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = HtmlEncode($rswrk->fields('df'));
						$this->type->ViewValue = $this->type->displayValue($arwrk);
					} else {
						$this->type->ViewValue = $Language->phrase("PleaseSelect");
					}
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->type->EditValue = $arwrk;
				}
			}

			// section
			$this->section->EditAttrs["class"] = "form-control";
			$this->section->EditCustomAttributes = "";
			if ($this->section->getSessionValue() != "") {
				$this->section->CurrentValue = $this->section->getSessionValue();
				$this->section->OldValue = $this->section->CurrentValue;
				$this->section->ViewValue = $this->section->CurrentValue;
				$curVal = strval($this->section->CurrentValue);
				if ($curVal != "") {
					$this->section->ViewValue = $this->section->lookupCacheOption($curVal);
					if ($this->section->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->section->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = FormatNumber($rswrk->fields('df'), 0, -2, -2, -2);
							$arwrk[2] = $rswrk->fields('df2');
							$this->section->ViewValue = $this->section->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->section->ViewValue = $this->section->CurrentValue;
						}
					}
				} else {
					$this->section->ViewValue = NULL;
				}
				$this->section->ViewCustomAttributes = "";
			} else {
				$this->section->EditValue = HtmlEncode($this->section->CurrentValue);
				$curVal = strval($this->section->CurrentValue);
				if ($curVal != "") {
					$this->section->EditValue = $this->section->lookupCacheOption($curVal);
					if ($this->section->EditValue === NULL) { // Lookup from database
						$filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->section->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = HtmlEncode(FormatNumber($rswrk->fields('df'), 0, -2, -2, -2));
							$arwrk[2] = HtmlEncode($rswrk->fields('df2'));
							$this->section->EditValue = $this->section->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->section->EditValue = HtmlEncode($this->section->CurrentValue);
						}
					}
				} else {
					$this->section->EditValue = NULL;
				}
				$this->section->PlaceHolder = RemoveHtml($this->section->caption());
			}

			// active
			$this->active->EditCustomAttributes = "";
			$this->active->EditValue = $this->active->options(FALSE);

			// created_at
			$this->created_at->EditAttrs["class"] = "form-control";
			$this->created_at->EditCustomAttributes = "";
			$this->created_at->EditValue = HtmlEncode(FormatDateTime($this->created_at->CurrentValue, 8));
			$this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

			// updated_at
			$this->updated_at->EditAttrs["class"] = "form-control";
			$this->updated_at->EditCustomAttributes = "";
			$this->updated_at->EditValue = HtmlEncode(FormatDateTime($this->updated_at->CurrentValue, 8));
			$this->updated_at->PlaceHolder = RemoveHtml($this->updated_at->caption());

			// has_recommendations
			$this->has_recommendations->EditCustomAttributes = "";
			$this->has_recommendations->EditValue = $this->has_recommendations->options(FALSE);

			// group
			$this->group->EditAttrs["class"] = "form-control";
			$this->group->EditCustomAttributes = "";
			if ($this->group->getSessionValue() != "") {
				$this->group->CurrentValue = $this->group->getSessionValue();
				$this->group->OldValue = $this->group->CurrentValue;
				$curVal = strval($this->group->CurrentValue);
				if ($curVal != "") {
					$this->group->ViewValue = $this->group->lookupCacheOption($curVal);
					if ($this->group->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->group->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->group->ViewValue = $this->group->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->group->ViewValue = $this->group->CurrentValue;
						}
					}
				} else {
					$this->group->ViewValue = NULL;
				}
				$this->group->ViewCustomAttributes = "";
			} else {
				$curVal = trim(strval($this->group->CurrentValue));
				if ($curVal != "")
					$this->group->ViewValue = $this->group->lookupCacheOption($curVal);
				else
					$this->group->ViewValue = $this->group->Lookup !== NULL && is_array($this->group->Lookup->Options) ? $curVal : NULL;
				if ($this->group->ViewValue !== NULL) { // Load from cache
					$this->group->EditValue = array_values($this->group->Lookup->Options);
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`id`" . SearchString("=", $this->group->CurrentValue, DATATYPE_NUMBER, "");
					}
					$sqlWrk = $this->group->Lookup->getSql(TRUE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->group->EditValue = $arwrk;
				}
			}

			// category
			$this->category->EditAttrs["class"] = "form-control";
			$this->category->EditCustomAttributes = "";
			if ($this->category->getSessionValue() != "") {
				$this->category->CurrentValue = $this->category->getSessionValue();
				$this->category->OldValue = $this->category->CurrentValue;
				$curVal = strval($this->category->CurrentValue);
				if ($curVal != "") {
					$this->category->ViewValue = $this->category->lookupCacheOption($curVal);
					if ($this->category->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->category->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->category->ViewValue = $this->category->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->category->ViewValue = $this->category->CurrentValue;
						}
					}
				} else {
					$this->category->ViewValue = NULL;
				}
				$this->category->ViewCustomAttributes = "";
			} else {
				$curVal = trim(strval($this->category->CurrentValue));
				if ($curVal != "")
					$this->category->ViewValue = $this->category->lookupCacheOption($curVal);
				else
					$this->category->ViewValue = $this->category->Lookup !== NULL && is_array($this->category->Lookup->Options) ? $curVal : NULL;
				if ($this->category->ViewValue !== NULL) { // Load from cache
					$this->category->EditValue = array_values($this->category->Lookup->Options);
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`id`" . SearchString("=", $this->category->CurrentValue, DATATYPE_NUMBER, "");
					}
					$sqlWrk = $this->category->Lookup->getSql(TRUE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->category->EditValue = $arwrk;
				}
			}

			// order
			$this->order->EditAttrs["class"] = "form-control";
			$this->order->EditCustomAttributes = "";
			$this->order->EditValue = HtmlEncode($this->order->CurrentValue);
			$this->order->PlaceHolder = RemoveHtml($this->order->caption());

			// recommendation_score
			$this->recommendation_score->EditAttrs["class"] = "form-control";
			$this->recommendation_score->EditCustomAttributes = "";
			$this->recommendation_score->EditValue = HtmlEncode($this->recommendation_score->CurrentValue);
			$this->recommendation_score->PlaceHolder = RemoveHtml($this->recommendation_score->caption());
			if (strval($this->recommendation_score->EditValue) != "" && is_numeric($this->recommendation_score->EditValue)) {
				$this->recommendation_score->EditValue = FormatNumber($this->recommendation_score->EditValue, -2, -2, -2, -2);
				$this->recommendation_score->OldValue = $this->recommendation_score->EditValue;
			}
			

			// related
			$this->related->EditAttrs["class"] = "form-control";
			$this->related->EditCustomAttributes = "";
			$this->related->EditValue = HtmlEncode($this->related->CurrentValue);
			$this->related->PlaceHolder = RemoveHtml($this->related->caption());

			// trigger_related_val
			$this->trigger_related_val->EditAttrs["class"] = "form-control";
			$this->trigger_related_val->EditCustomAttributes = "";
			if (!$this->trigger_related_val->Raw)
				$this->trigger_related_val->CurrentValue = HtmlDecode($this->trigger_related_val->CurrentValue);
			$this->trigger_related_val->EditValue = HtmlEncode($this->trigger_related_val->CurrentValue);
			$this->trigger_related_val->PlaceHolder = RemoveHtml($this->trigger_related_val->caption());

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";

			// placeholder
			$this->placeholder->LinkCustomAttributes = "";
			$this->placeholder->HrefValue = "";

			// questions
			$this->questions->LinkCustomAttributes = "";
			$this->questions->HrefValue = "";

			// scores
			$this->scores->LinkCustomAttributes = "";
			$this->scores->HrefValue = "";

			// type
			$this->type->LinkCustomAttributes = "";
			$this->type->HrefValue = "";

			// section
			$this->section->LinkCustomAttributes = "";
			$this->section->HrefValue = "";

			// active
			$this->active->LinkCustomAttributes = "";
			$this->active->HrefValue = "";

			// created_at
			$this->created_at->LinkCustomAttributes = "";
			$this->created_at->HrefValue = "";

			// updated_at
			$this->updated_at->LinkCustomAttributes = "";
			$this->updated_at->HrefValue = "";

			// has_recommendations
			$this->has_recommendations->LinkCustomAttributes = "";
			$this->has_recommendations->HrefValue = "";

			// group
			$this->group->LinkCustomAttributes = "";
			$this->group->HrefValue = "";

			// category
			$this->category->LinkCustomAttributes = "";
			$this->category->HrefValue = "";

			// order
			$this->order->LinkCustomAttributes = "";
			$this->order->HrefValue = "";

			// recommendation_score
			$this->recommendation_score->LinkCustomAttributes = "";
			$this->recommendation_score->HrefValue = "";

			// related
			$this->related->LinkCustomAttributes = "";
			$this->related->HrefValue = "";

			// trigger_related_val
			$this->trigger_related_val->LinkCustomAttributes = "";
			$this->trigger_related_val->HrefValue = "";
		}
		if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->setupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType != ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	protected function validateForm()
	{
		global $Language, $FormError;

		// Check if validation required
		if (!Config("SERVER_VALIDATE"))
			return ($FormError == "");
		if ($this->id->Required) {
			if (!$this->id->IsDetailKey && $this->id->FormValue != NULL && $this->id->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
			}
		}
		if ($this->title->Required) {
			if (!$this->title->IsDetailKey && $this->title->FormValue != NULL && $this->title->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->title->caption(), $this->title->RequiredErrorMessage));
			}
		}
		if ($this->placeholder->Required) {
			if (!$this->placeholder->IsDetailKey && $this->placeholder->FormValue != NULL && $this->placeholder->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->placeholder->caption(), $this->placeholder->RequiredErrorMessage));
			}
		}
		if ($this->questions->Required) {
			if (!$this->questions->IsDetailKey && $this->questions->FormValue != NULL && $this->questions->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->questions->caption(), $this->questions->RequiredErrorMessage));
			}
		}
		if ($this->scores->Required) {
			if (!$this->scores->IsDetailKey && $this->scores->FormValue != NULL && $this->scores->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->scores->caption(), $this->scores->RequiredErrorMessage));
			}
		}
		if ($this->type->Required) {
			if (!$this->type->IsDetailKey && $this->type->FormValue != NULL && $this->type->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->type->caption(), $this->type->RequiredErrorMessage));
			}
		}
		if ($this->section->Required) {
			if (!$this->section->IsDetailKey && $this->section->FormValue != NULL && $this->section->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->section->caption(), $this->section->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->section->FormValue)) {
			AddMessage($FormError, $this->section->errorMessage());
		}
		if ($this->active->Required) {
			if ($this->active->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->active->caption(), $this->active->RequiredErrorMessage));
			}
		}
		if ($this->created_at->Required) {
			if (!$this->created_at->IsDetailKey && $this->created_at->FormValue != NULL && $this->created_at->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->created_at->caption(), $this->created_at->RequiredErrorMessage));
			}
		}
		if (!CheckDate($this->created_at->FormValue)) {
			AddMessage($FormError, $this->created_at->errorMessage());
		}
		if ($this->updated_at->Required) {
			if (!$this->updated_at->IsDetailKey && $this->updated_at->FormValue != NULL && $this->updated_at->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->updated_at->caption(), $this->updated_at->RequiredErrorMessage));
			}
		}
		if (!CheckDate($this->updated_at->FormValue)) {
			AddMessage($FormError, $this->updated_at->errorMessage());
		}
		if ($this->has_recommendations->Required) {
			if ($this->has_recommendations->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->has_recommendations->caption(), $this->has_recommendations->RequiredErrorMessage));
			}
		}
		if ($this->group->Required) {
			if (!$this->group->IsDetailKey && $this->group->FormValue != NULL && $this->group->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->group->caption(), $this->group->RequiredErrorMessage));
			}
		}
		if ($this->category->Required) {
			if (!$this->category->IsDetailKey && $this->category->FormValue != NULL && $this->category->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->category->caption(), $this->category->RequiredErrorMessage));
			}
		}
		if ($this->order->Required) {
			if (!$this->order->IsDetailKey && $this->order->FormValue != NULL && $this->order->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->order->caption(), $this->order->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->order->FormValue)) {
			AddMessage($FormError, $this->order->errorMessage());
		}
		if ($this->recommendation_score->Required) {
			if (!$this->recommendation_score->IsDetailKey && $this->recommendation_score->FormValue != NULL && $this->recommendation_score->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->recommendation_score->caption(), $this->recommendation_score->RequiredErrorMessage));
			}
		}
		if (!CheckNumber($this->recommendation_score->FormValue)) {
			AddMessage($FormError, $this->recommendation_score->errorMessage());
		}
		if ($this->related->Required) {
			if (!$this->related->IsDetailKey && $this->related->FormValue != NULL && $this->related->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->related->caption(), $this->related->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->related->FormValue)) {
			AddMessage($FormError, $this->related->errorMessage());
		}
		if ($this->trigger_related_val->Required) {
			if (!$this->trigger_related_val->IsDetailKey && $this->trigger_related_val->FormValue != NULL && $this->trigger_related_val->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->trigger_related_val->caption(), $this->trigger_related_val->RequiredErrorMessage));
			}
		}

		// Return validate result
		$validateForm = ($FormError == "");

		// Call Form_CustomValidate event
		$formCustomError = "";
		$validateForm = $validateForm && $this->Form_CustomValidate($formCustomError);
		if ($formCustomError != "") {
			AddMessage($FormError, $formCustomError);
		}
		return $validateForm;
	}

	// Delete records based on current filter
	protected function deleteRows()
	{
		global $Language, $Security;
		if (!$Security->canDelete()) {
			$this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$deleteRows = TRUE;
		$sql = $this->getCurrentSql();
		$conn = $this->getConnection();
		$conn->raiseErrorFn = Config("ERROR_FUNC");
		$rs = $conn->execute($sql);
		$conn->raiseErrorFn = "";
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->phrase("NoRecord")); // No record found
			$rs->close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->getRows() : [];

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->close();

		// Call row deleting event
		if ($deleteRows) {
			foreach ($rsold as $row) {
				$deleteRows = $this->Row_Deleting($row);
				if (!$deleteRows)
					break;
			}
		}
		if ($deleteRows) {
			$key = "";
			foreach ($rsold as $row) {
				$thisKey = "";
				if ($thisKey != "")
					$thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
				$thisKey .= $row['id'];
				if (Config("DELETE_UPLOADED_FILES")) // Delete old files
					$this->deleteUploadedFiles($row);
				$conn->raiseErrorFn = Config("ERROR_FUNC");
				$deleteRows = $this->delete($row); // Delete
				$conn->raiseErrorFn = "";
				if ($deleteRows === FALSE)
					break;
				if ($key != "")
					$key .= ", ";
				$key .= $thisKey;
			}
		}
		if (!$deleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage != "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->phrase("DeleteCancelled"));
			}
		}

		// Call Row Deleted event
		if ($deleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}

		// Write JSON for API request (Support single row only)
		if (IsApi() && $deleteRows) {
			$row = $this->getRecordsFromRecordset($rsold, TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $deleteRows;
	}

	// Update record based on key values
	protected function editRow()
	{
		global $Security, $Language;
		$oldKeyFilter = $this->getRecordFilter();
		$filter = $this->applyUserIDFilters($oldKeyFilter);
		$conn = $this->getConnection();
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn->raiseErrorFn = Config("ERROR_FUNC");
		$rs = $conn->execute($sql);
		$conn->raiseErrorFn = "";
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
			$editRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->loadDbValues($rsold);
			$rsnew = [];

			// title
			$this->title->setDbValueDef($rsnew, $this->title->CurrentValue, NULL, $this->title->ReadOnly);

			// placeholder
			$this->placeholder->setDbValueDef($rsnew, $this->placeholder->CurrentValue, NULL, $this->placeholder->ReadOnly);

			// questions
			$this->questions->setDbValueDef($rsnew, $this->questions->CurrentValue, NULL, $this->questions->ReadOnly);

			// scores
			$this->scores->setDbValueDef($rsnew, $this->scores->CurrentValue, NULL, $this->scores->ReadOnly);

			// type
			$this->type->setDbValueDef($rsnew, $this->type->CurrentValue, NULL, $this->type->ReadOnly);

			// section
			$this->section->setDbValueDef($rsnew, $this->section->CurrentValue, NULL, $this->section->ReadOnly);

			// active
			$tmpBool = $this->active->CurrentValue;
			if ($tmpBool != "1" && $tmpBool != "0")
				$tmpBool = !empty($tmpBool) ? "1" : "0";
			$this->active->setDbValueDef($rsnew, $tmpBool, NULL, $this->active->ReadOnly);

			// created_at
			$this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, 0), NULL, $this->created_at->ReadOnly);

			// updated_at
			$this->updated_at->setDbValueDef($rsnew, UnFormatDateTime($this->updated_at->CurrentValue, 0), NULL, $this->updated_at->ReadOnly);

			// has_recommendations
			$this->has_recommendations->setDbValueDef($rsnew, $this->has_recommendations->CurrentValue, NULL, $this->has_recommendations->ReadOnly);

			// group
			$this->group->setDbValueDef($rsnew, $this->group->CurrentValue, NULL, $this->group->ReadOnly);

			// category
			$this->category->setDbValueDef($rsnew, $this->category->CurrentValue, NULL, $this->category->ReadOnly);

			// order
			$this->order->setDbValueDef($rsnew, $this->order->CurrentValue, NULL, $this->order->ReadOnly);

			// recommendation_score
			$this->recommendation_score->setDbValueDef($rsnew, $this->recommendation_score->CurrentValue, NULL, $this->recommendation_score->ReadOnly);

			// related
			$this->related->setDbValueDef($rsnew, $this->related->CurrentValue, NULL, $this->related->ReadOnly);

			// trigger_related_val
			$this->trigger_related_val->setDbValueDef($rsnew, $this->trigger_related_val->CurrentValue, NULL, $this->trigger_related_val->ReadOnly);

			// Call Row Updating event
			$updateRow = $this->Row_Updating($rsold, $rsnew);

			// Check for duplicate key when key changed
			if ($updateRow) {
				$newKeyFilter = $this->getRecordFilter($rsnew);
				if ($newKeyFilter != $oldKeyFilter) {
					$rsChk = $this->loadRs($newKeyFilter);
					if ($rsChk && !$rsChk->EOF) {
						$keyErrMsg = str_replace("%f", $newKeyFilter, $Language->phrase("DupKey"));
						$this->setFailureMessage($keyErrMsg);
						$rsChk->close();
						$updateRow = FALSE;
					}
				}
			}
			if ($updateRow) {
				$conn->raiseErrorFn = Config("ERROR_FUNC");
				if (count($rsnew) > 0)
					$editRow = $this->update($rsnew, "", $rsold);
				else
					$editRow = TRUE; // No field to update
				$conn->raiseErrorFn = "";
				if ($editRow) {
				}
			} else {
				if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage != "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->phrase("UpdateCancelled"));
				}
				$editRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($editRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->close();

		// Clean upload path if any
		if ($editRow) {
		}

		// Write JSON for API request
		if (IsApi() && $editRow) {
			$row = $this->getRecordsFromRecordset([$rsnew], TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $editRow;
	}

	// Add record
	protected function addRow($rsold = NULL)
	{
		global $Language, $Security;

		// Set up foreign key field value from Session
			if ($this->getCurrentMasterTable() == "question_types") {
				$this->type->CurrentValue = $this->type->getSessionValue();
			}
			if ($this->getCurrentMasterTable() == "sections") {
				$this->section->CurrentValue = $this->section->getSessionValue();
			}
			if ($this->getCurrentMasterTable() == "question_groups") {
				$this->group->CurrentValue = $this->group->getSessionValue();
			}
			if ($this->getCurrentMasterTable() == "question_category") {
				$this->category->CurrentValue = $this->category->getSessionValue();
			}
		$conn = $this->getConnection();

		// Load db values from rsold
		$this->loadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = [];

		// title
		$this->title->setDbValueDef($rsnew, $this->title->CurrentValue, NULL, FALSE);

		// placeholder
		$this->placeholder->setDbValueDef($rsnew, $this->placeholder->CurrentValue, NULL, FALSE);

		// questions
		$this->questions->setDbValueDef($rsnew, $this->questions->CurrentValue, NULL, FALSE);

		// scores
		$this->scores->setDbValueDef($rsnew, $this->scores->CurrentValue, NULL, FALSE);

		// type
		$this->type->setDbValueDef($rsnew, $this->type->CurrentValue, NULL, FALSE);

		// section
		$this->section->setDbValueDef($rsnew, $this->section->CurrentValue, NULL, FALSE);

		// active
		$tmpBool = $this->active->CurrentValue;
		if ($tmpBool != "1" && $tmpBool != "0")
			$tmpBool = !empty($tmpBool) ? "1" : "0";
		$this->active->setDbValueDef($rsnew, $tmpBool, NULL, FALSE);

		// created_at
		$this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, 0), NULL, FALSE);

		// updated_at
		$this->updated_at->setDbValueDef($rsnew, UnFormatDateTime($this->updated_at->CurrentValue, 0), NULL, FALSE);

		// has_recommendations
		$this->has_recommendations->setDbValueDef($rsnew, $this->has_recommendations->CurrentValue, NULL, FALSE);

		// group
		$this->group->setDbValueDef($rsnew, $this->group->CurrentValue, NULL, FALSE);

		// category
		$this->category->setDbValueDef($rsnew, $this->category->CurrentValue, NULL, FALSE);

		// order
		$this->order->setDbValueDef($rsnew, $this->order->CurrentValue, NULL, FALSE);

		// recommendation_score
		$this->recommendation_score->setDbValueDef($rsnew, $this->recommendation_score->CurrentValue, NULL, FALSE);

		// related
		$this->related->setDbValueDef($rsnew, $this->related->CurrentValue, NULL, FALSE);

		// trigger_related_val
		$this->trigger_related_val->setDbValueDef($rsnew, $this->trigger_related_val->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold) ? $rsold->fields : NULL;
		$insertRow = $this->Row_Inserting($rs, $rsnew);
		if ($insertRow) {
			$conn->raiseErrorFn = Config("ERROR_FUNC");
			$addRow = $this->insert($rsnew);
			$conn->raiseErrorFn = "";
			if ($addRow) {
			}
		} else {
			if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage != "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->phrase("InsertCancelled"));
			}
			$addRow = FALSE;
		}
		if ($addRow) {

			// Call Row Inserted event
			$rs = ($rsold) ? $rsold->fields : NULL;
			$this->Row_Inserted($rs, $rsnew);
		}

		// Clean upload path if any
		if ($addRow) {
		}

		// Write JSON for API request
		if (IsApi() && $addRow) {
			$row = $this->getRecordsFromRecordset([$rsnew], TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $addRow;
	}

	// Set up master/detail based on QueryString
	protected function setupMasterParms()
	{

		// Hide foreign keys
		$masterTblVar = $this->getCurrentMasterTable();
		if ($masterTblVar == "question_types") {
			$this->type->Visible = FALSE;
			if ($GLOBALS["question_types"]->EventCancelled)
				$this->EventCancelled = TRUE;
		}
		if ($masterTblVar == "sections") {
			$this->section->Visible = FALSE;
			if ($GLOBALS["sections"]->EventCancelled)
				$this->EventCancelled = TRUE;
		}
		if ($masterTblVar == "question_groups") {
			$this->group->Visible = FALSE;
			if ($GLOBALS["question_groups"]->EventCancelled)
				$this->EventCancelled = TRUE;
		}
		if ($masterTblVar == "question_category") {
			$this->category->Visible = FALSE;
			if ($GLOBALS["question_category"]->EventCancelled)
				$this->EventCancelled = TRUE;
		}
		$this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
	}

	// Setup lookup options
	public function setupLookupOptions($fld)
	{
		if ($fld->Lookup !== NULL && $fld->Lookup->Options === NULL) {

			// Get default connection and filter
			$conn = $this->getConnection();
			$lookupFilter = "";

			// No need to check any more
			$fld->Lookup->Options = [];

			// Set up lookup SQL and connection
			switch ($fld->FieldVar) {
				case "x_type":
					break;
				case "x_section":
					break;
				case "x_active":
					break;
				case "x_has_recommendations":
					break;
				case "x_group":
					break;
				case "x_category":
					break;
				default:
					$lookupFilter = "";
					break;
			}

			// Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
			$sql = $fld->Lookup->getSql(FALSE, "", $lookupFilter, $this);

			// Set up lookup cache
			if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
				$totalCnt = $this->getRecordCount($sql, $conn);
				if ($totalCnt > $fld->LookupCacheCount) // Total count > cache count, do not cache
					return;
				$rs = $conn->execute($sql);
				$ar = [];
				while ($rs && !$rs->EOF) {
					$row = &$rs->fields;

					// Format the field values
					switch ($fld->FieldVar) {
						case "x_type":
							break;
						case "x_section":
							$row[1] = FormatNumber($row[1], 0, -2, -2, -2);
							$row['df'] = $row[1];
							break;
						case "x_group":
							break;
						case "x_category":
							break;
					}
					$ar[strval($row[0])] = $row;
					$rs->moveNext();
				}
				if ($rs)
					$rs->close();
				$fld->Lookup->Options = $ar;
			}
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$customError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions["new"]->Body = "xxx";

	}
} // End class
?>