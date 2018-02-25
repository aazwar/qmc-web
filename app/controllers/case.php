<?php

class Book {
	function execute($f3, $action) {
		$access = \Access::instance();
    if(method_exists($this, $action)) {
  		if($access->authorize($f3['SESSION.group'])) {
  			$this->$action();
  		} else {
  			$f3->error(403);
  		}
    } else {
      die("Method doesn't exist: " . __CLASS__ . "\\$action");
    }
	}
  
  function upload() {
    $f3 = \Base::instance();
    $overwrite = true; // set to true, to overwrite an existing file; Default: false
    $slug = false; // rename file to filesystem-friendly version
    $web = \Web::instance();
    $files = $web->receive(function($file,$formFieldName){
          return true; // allows the file to be moved from php tmp dir to your defined upload dir
        },
        $overwrite,
        $slug
    );
    $id = FSQL1('SELECT MAX(id) FROM book')+1;
    foreach($files as $file => $stat) {
      if($stat) {
        $filename = "images/books/" . basename($file);
        rename($file, $f3['ROOT'].$f3['BASE']."/$filename");
      }
    }
    $sql = "INSERT INTO book VALUES(?, ?, ?, ?, ?, ?, ?)";
    SQL($sql, $id, $f3['REQUEST.name'], $f3['REQUEST.summary'], $f3['FILES.cover.name'], $f3['FILES.file.name'], date('c'), $f3['REQUEST.category']);
    $f3['content'] = "books/receive.htm";
    echo \Template::instance()->render('template.htm');		
  }
  
  function meta() {
    $f3 = \Base::instance();
    $cats = FSQLC('SELECT DISTINCT category FROM book');
    $books = SQL('SELECT * FROM book');
    //print_r($books);
    $result = array_map(function($cat) use($books) { 
      return ['category' => $cat, 'books' => array_filter($books, function($e) use($cat) { 
        return $e['category'] == $cat; 
      })];
    }, $cats);
    print(json_encode($result));
  }
}
?>