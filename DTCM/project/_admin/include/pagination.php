<?php
class PS_Pagination {
	var $php_self;
	var $site_url;
	var $rows_per_page = 10; //Number of records to display per page
	var $total_rows = 0; //Total number of rows returned by the query
	var $links_per_page = 5; //Number of links to display per page
	var $append = ""; //Paremeters to append to pagination links
	var $sql = "";
	var $count_sql = "";
	var $debug = false;
	var $conn = false;
	var $page = 1;
	var $max_pages = 0;
	var $offset = 0;
	var $total_fetch_rows = 0;
	
	/**
	 * Constructor
	 *
	 * @param resource $connection Mysql connection link
	 * @param string $sql SQL query to paginate. Example : SELECT * FROM users
	 * @param integer $rows_per_page Number of records to display per page. Defaults to 10
	 * @param integer $links_per_page Number of links to display per page. Defaults to 5
	 * @param string $append Parameters to be appended to pagination links 
	 */
	
	function PS_Pagination($count_sql, $sql, $rows_per_page = 10, $links_per_page = 5, $append = "") {
		//$this->conn = $conn;
		$this->sql = $sql;
		$this->count_sql = $count_sql;
		$this->rows_per_page = (int)$rows_per_page;
		if (intval($links_per_page ) > 0) {
			$this->links_per_page = (int)$links_per_page;
		} else {
			$this->links_per_page = 5;
		}
		
		$this->append = $append;
		if($this->append != ""){
			$this->append = "&".$this->append;
		}
		//$this->php_self = htmlspecialchars($_SERVER['PHP_SELF'] );
		
		//get and make url
		$protocol = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https' : 'http';
		$this->php_self = $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		if (isset($_GET['page'] )) {
			$this->page = intval($_GET['page'] );
		}
		else {
			$this->page = 1;
		}
		
		if($this->page >= 1)
			{
			//remove last slash and page # from url
			$remove_string = strrchr($this->php_self,"?");
			$remove_string_length = strlen($remove_string);
			
			//final url
			$this->php_self = substr($this->php_self,0,-$remove_string_length);
			//$this->site_url = $config['SITE_URL'];
			}
		
		
	}
	
	/**
	 * Executes the SQL query and initializes internal variables
	 *
	 * @access public
	 * @return resource
	 */
	function paginate() {
		global $conn;
		//Check for valid mysql connection
		/*if (! $this->conn || ! is_resource($this->conn )) {
			if ($this->debug)
				echo "MySQL connection missing<br />";
			return false;
		}*/
		
		//Find total number of rows
		$all_rs = @mysqli_query($conn,$this->count_sql);
		if (! $all_rs) {
			if ($this->debug)
				echo "SQL query failed. Check your query.<br /><br />Error Returned: " . mysqli_error($conn);
			return false;
		}
		$total_fetch_rows = mysqli_fetch_row($all_rs);
		$this->total_rows = $total_fetch_rows[0];
		@mysqli_close($all_rs);
		
		//Return FALSE if no rows found
		if ($this->total_rows == 0) {
			if ($this->debug)
				echo "Query returned zero rows.";
			return FALSE;
		}
		
		//Max number of pages
		$this->max_pages = ceil($this->total_rows / $this->rows_per_page );
		if ($this->links_per_page > $this->max_pages) {
			$this->links_per_page = $this->max_pages;
		}
		
		//Check the page value just in case someone is trying to input an aribitrary value
		if ($this->page > $this->max_pages || $this->page <= 0) {
			$this->page = 1;
		}
		
		//Calculate Offset
		$this->offset = $this->rows_per_page * ($this->page - 1);
		
		//Fetch the required result set
		$this->sql = $this->sql . " LIMIT {$this->offset}, {$this->rows_per_page}";
		$rs = @mysqli_query($conn,$this->sql);
		if (! $rs) {
			if ($this->debug)
				echo "Pagination query failed. Check your query.<br /><br />Error Returned: " . mysqli_error();
			return false;
		}
		return $rs;
	}
	
	/**
	 * Display the link to the first page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'First'
	 * @return string
	 */
	function renderFirst($tag = 'First') {
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page == 1) {
			return '<a href="javascript:void(0);" class="btn"><img valign="bottom" src="'.APP_DIR.'assets/img/icons/first.png" border="0" title="First" /></a>';
		} else {
			return '<a href="' . $this->php_self . '?page=1'.$this->append.'" class="btn"><img valign="bottom" src="'.APP_DIR.'assets/img/icons/first.png" border="0" title="First" /></a>';
		}
	}
	
	/**
	 * Display the link to the last page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'Last'
	 * @return string
	 */
	function renderLast($tag = 'Last') {
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page == $this->max_pages) {
			return '<a href="javascript:void(0);" class="btn"><img valign="bottom" src="'.APP_DIR.'assets/img/icons/last.png" border="0" title="Last" /></a>';
		} else {
			return '<a href="' . $this->php_self . '?page=' . $this->max_pages . $this->append.'" class="btn"><img valign="bottom" src="'.APP_DIR.'assets/img/icons/last.png" border="0" title="Last" /></a>';
		}
	}
	
	/**
	 * Display the next link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '>>'
	 * @return string
	 */
	function renderNext($tag = 'Next') {
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page < $this->max_pages) {
			return '<li class="next"><a href="' . $this->php_self . '?page=' . ($this->page + 1) . $this->append.'">Next &rarr; </a></li>';
		} else {
			return '<li class="next disabled"><a href="javascript:void(0);">Next &rarr; </a></li>';
		}
	}
	
	/**
	 * Display the previous link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '<<'
	 * @return string
	 */
	function renderPrev($tag = 'Previous') {
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page > 1) {
			return '<li class="prev"><a href="' . $this->php_self . '?page=' . ($this->page - 1) . $this->append.'">&larr; '.$tag.'</a></li>';
		} else {
			return '<li class="prev disabled"><a href="javascript:void(0);">&larr; '.$tag.'</a></li>';
		}
	}
	
	/**
	 * Display the page links
	 *
	 * @access public
	 * @return string
	 */
	function renderNav($prefix = '', $suffix = '') {
		if ($this->total_rows == 0)
			return FALSE;
		
		$batch = ceil($this->page / $this->links_per_page );
		$end = $batch * $this->links_per_page;
		if ($end == $this->page) {
			//$end = $end + $this->links_per_page - 1;
		//$end = $end + ceil($this->links_per_page/2);
		}
		if ($end > $this->max_pages) {
			$end = $this->max_pages;
		}
		$start = $end - $this->links_per_page + 1;
		$links = '';
		
		for($i = $start; $i <= $end; $i ++) {
			if ($i == $this->page) {
				$links .= $prefix . '<li class="active"><a href="javascript:void(0);">'.$i.'</a></li>' . $suffix;
			} else {
				$links .= ' ' . $prefix . '<li><a href="' . $this->php_self . '?page=' . $i . $this->append.'">'.$i.'</a></li>' . $suffix;
			}
		}
		
		return $links;
	}
	
	/**
	 * Display full pagination navigation
	 *
	 * @access public
	 * @return string
	 */
	function renderFullNav() {
		return '<div class="dataTables_paginate paging_bootstrap pagination"><ul>'.$this->renderPrev().$this->renderNav().$this->renderNext().'</ul></div>';
	}
	
	/**
	 * Set debug mode
	 *
	 * @access public
	 * @param bool $debug Set to TRUE to enable debug messages
	 * @return void
	 */
	function setDebug($debug) {
		$this->debug = $debug;
	}
}
?>
