<?php
namespace system;
class pagination extends \REST{
	var $php_self;
	var $rows_per_page = 10; //Number of records to display per page
	var $total_rows = 0; //Total number of rows returned by the query
	var $links_per_page = 5; //Number of links to display per page
	var $append = ""; //Paremeters to append to pagination links
	var $sql = "";
    var $odb;
	var $debug = false;
	var $conn = false;
	var $page = 1;
	var $max_pages = 1;
	var $offset = 0;
        var $params;

	/**
	 * Constructor
	 *
	 * @param resource $connection adodb connection link
	 * @param string $sql SQL query to paginate. Example : SELECT * FROM users
	 * @param integer $rows_per_page Number of records to display per page. Defaults to 10
	 * @param integer $links_per_page Number of links to display per page. Defaults to 5
	 * @param string $append Parameters to be appended to pagination links
	 */
    //  function Init(){
    //      $this->response( call_user_func([$this,$this->func],$this->params),200);
    //  }
	function OS_Pagination($sql,$sqlquery, $rows_per_page = 10, $links_per_page = 5,$page=1, $append = "",$input_array="") {

		        $this->sql = $sqlquery;
                $this->odb = $sql;
                $this->params=$input_array;
		$this->rows_per_page = (empty($rows_per_page))? 10 : (int)$rows_per_page;
		if (intval($links_per_page ) > 0) {
			$this->links_per_page = (int)$links_per_page;
		} else {
			$this->links_per_page = 5;
		}
		$this->append = $append;
		$this->php_self = htmlspecialchars($_SERVER['PHP_SELF'] );
		if (isset($page )) {
			$this->page = intval($page );
		}
	}

	/**
	 * Executes the SQL query and initializes internal variables
	 *
	 * @access public
	 * @return resource
	 */
	function paginate() {
		//Find total number of rows
                $stmt = $this->odb->Prepare($this->sql);

                if(is_array($this->params) && !empty($this->params)){
                $all_rs =$this->odb->Execute($stmt,$this->params);
                    }else{
		$all_rs =$this->odb->Execute($stmt);
                }


		if (! $all_rs) {

			if ($this->debug)
				echo "SQL query failed. Check your query.<br /><br />Error Returned: " .$this->odb->ErrorMsg();;
			return false;
		}
		$this->total_rows = $all_rs->RecordCount();
		//@mysql_close($all_rs );

		//Return FALSE if no rows found
		if ($this->total_rows == 0) {
			if ($this->debug)
				echo "Query returned zero rows.";
			return FALSE;
		}

		if($this->rows_per_page !='all'){
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
		//$rs = $this->odb->Prepare($this->sql . " LIMIT {$this->offset}, {$this->rows_per_page}" );
		$rs = $this->odb->Prepare($this->sql);
		//select all


		if(is_array($this->params) && !empty($this->params)){

			$rs = $this->odb->SelectLimit($rs,$this->rows_per_page,$this->offset,$this->params);
			//$rs = $this->odb->Execute($rs,$this->params);
		}else{

			$rs = $this->odb->SelectLimit($rs,$this->rows_per_page,$this->offset);
		}//end of if

	}else{
			$rs = $this->odb->Prepare($this->sql);
			//select all
			if(is_array($this->params) && !empty($this->params)){
				$rs = $this->odb->Execute($rs,$this->params);
			}else{
				$rs = $this->odb->Execute($rs);
			}//end of if
		}



                if (! $rs) {
			if ($this->debug)
				echo "Pagination query failed. Check your query.<br /><br />Error Returned: " . $this->odb->ErrorMsg();
			return false;
		}
                print $this->odb->ErrorMsg();
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
			return "$tag ";
		} else {
			return '<a href="' . $this->php_self . '?page=1&' . $this->append . '">' . $tag . '</a> ';
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
			return $tag;
		} else {
			return ' <a href="' . $this->php_self . '?page=' . $this->max_pages . '&' . $this->append . '">' . $tag . '</a>';
		}
	}

	/**
	 * Display the next link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '>>'
	 * @return string
	 */
	function renderNext($tag = '&gt;&gt;',$tagon = '&lt;&lt;') {
		if ($this->total_rows == 0)
			return $tag;

		if ($this->page < $this->max_pages) {
			return (($this->page < ($this->max_pages - $this->links_per_page))?'':'').'<a href="' . $this->php_self . '?page=' . ($this->page + 1) . '&' . $this->append . '">' . $tagon . '</a>';
		} else {
			return $tag;
		}
	}

	/**
	 * Display the previous link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '<<'
	 * @return string
	 */
	function renderPrev($tag = '&lt;&lt;',$tagon = '&lt;&lt;') {
		if ($this->total_rows == 0)
			return $tag;

		if ($this->page > 1) {
			return '<a href="' . $this->php_self . '?page=' . ($this->page - 1) . '&' . $this->append . '">' . $tagon . '</a>'.(($this->page > $this->links_per_page)?'...':'');
		} else {
			return " $tag";
		}
	}

	/**
	 * Display the page links
	 *
	 * @access public
	 * @return string
	 */
	function renderNav($prefix = '<span class="page_link">', $suffix = '</span>') {
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
				$links .= $prefix . " $i " . $suffix;
			} else {
				$links .= ' ' . $prefix . '<a href="' . $this->php_self . '?page=' . $i . '&' . $this->append . '">' . $i . '</a>' . $suffix . ' ';
			}
		}

		return $links;
	}

        /**
	 * Display the page number
	 *
	 * @access public
	 * @return string
	 */
        function renderNavNum(){
            if ($this->total_rows == 0)
			return FALSE;

		$batch = ceil($this->page / $this->links_per_page );
		$end = $batch * $this->links_per_page;
                if ($end > $this->max_pages) {
			$end = $this->max_pages;
		}
		$start = $end - $this->links_per_page + 1;
		$links = '';

		/**for($i = $start; $i <= $end; $i ++) {
			if ($i == $this->page) {
				$links .= $prefix . " $i " . $suffix;
			} else {
				$links .= ' ' . $prefix . '<a href="' . $this->php_self . '?page=' . $i . '&' . $this->append . '">' . $i . '</a>' . $suffix . ' ';
			}
		}**/

		return $this->page;
        }
	/**
	 * Display full pagination navigation
	 *
	 * @access public
	 * @return string
	 */
	function renderFullNav() {
		return $this->renderFirst() . '&nbsp;' . $this->renderPrev() . '&nbsp;' . $this->renderNav() . '&nbsp;' . $this->renderNext() . '&nbsp;' . $this->renderLast();
	}

        function limitList($limit,$formname){
            echo '<select name="limit" class="shortes" onchange="document.'.$formname.'.submit()">
				<option '.(($limit =='10')?'selected="selected"':'').' value="10">10</option>
                <option '.(($limit =='20')?'selected="selected"':'').' value="20">20</option>
                <option '.(($limit =='30')?'selected="selected"':'').' value="30">30</option>
                <option '.(($limit =='50')?'selected="selected"':'').' value="50">50</option>
                <option '.(($limit =='100')?'selected="selected"':'').' value="100">100</option>
                <option '.(($limit =='200')?'selected="selected"':'').' value="200">200</option>
                <option '.(($limit =='all')?'selected="selected"':'').' value="all">ALL</option>
            </select>';
        }
	/**
	 * Set debug mode
		 * @access public
	 * @param bool $debug Set to TRUE to enable debug messages
	 * @return void
	 */
	function setDebug($debug) {
		$this->debug = $debug;
	}
}
?>
