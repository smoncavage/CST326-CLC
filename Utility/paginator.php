<!--
Stephan Moncavage
CST-236
eCommerce Site Milestone Project
Milestone 2
06 March 2021
Created based on example from 
https://code.tutsplus.com/tutorials/how-to-paginate-data-with-php--net-2928 
-->
<?php

class Paginator{
    private $_conn;
    private $_limit;
    private $_page;
    private $_query;
    private $_total;
  
    public function _contruct($conn, $query){
        $this->_conn = $conn;
        $this->_query = $query;
        $returnstate=$this->_conn->query($this->_query);
        $this->total = $returnstate->num_rows;
    }
    
    public function getData($limit, $page){
        $this->_limit=$limit;
        $this->_page=$page;
        if($this->_limit=='all'){
            $query=$this->_query;
        }
        else{
            $query = $this->_query. " LIMIT " . (($this->_page-1)*$this->_limit).", $this->_limit";
        }
        $returnstate=$this->_conn->query($query);
        while($row = $returnstate->fetch_assoc()){
            $results[]=$row;
        }
        
        $result = new stdClass();
        $result->page = $this->_page;
        $result->limit = $this->_limit;
        $result->total = $this->_limit;
        $result->data = $results;
        
        return $result;
    }
    
    public function createLinks( $links, $list_class ) {
        if ( $this->_limit == 'all' ) {
            return '';
        }
        
        $last       = ceil( $this->_total / $this->_limit );
        
        $start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
        $end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;
        
        $html1       = '<ul class="' . $list_class . '">';
       
        $html2       .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . ( $this->_page - 1 ) . '">&laquo;</a></li>';
        
        if ( $start > 1 ) {
            $html3   .= '<li><a href="?limit=' . $this->_limit . '&page=1">1</a></li>';
            $html4   .= '<li class="disabled"><span>...</span></li>';
        }
        
        for ( $i = $start ; $i <= $end; $i++ ) {
            $class  = ( $this->_page == $i ) ? "active" : "";
            $html5   .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . $i . '">' . $i . '</a></li>';
        }
        
        if ( $end < $last ) {
            $html6   .= '<li class="disabled"><span>...</span></li>';
            $html7   .= '<li><a href="?limit=' . $this->_limit . '&page=' . $last . '">' . $last . '</a></li>';
        }
        
        $class      = ( $this->_page == $last ) ? "disabled" : "";
        $html8       .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';
        
        $html9       .= '</ul>';
		
		$htmlString = $html1 + /n + $html2 + /n + $html3 + /n + $html4 + /n + $html5 + /n $html6 + /n + $html7 + /n + $html8 + /n + $html9
        
        return $htmlString;
    }
}