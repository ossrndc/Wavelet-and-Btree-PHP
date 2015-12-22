<?php
include 'db.php';
include 'queries.php';
include 'classes.php';

if(isset($_POST['keyword'])) {
	$keyword = $_POST['keyword'];
	$keys = explode(' ', $keyword);

	/* create dictionary starts*/
	$t_create_start = microtime(true);
	$qobj = new Queries();
	$wtree = new WaveletTree();
	$wtreeop = new WaveletOperation();
	
	$content = array();
	$contentlist = array();
	$docidlist = array();
	$doclist = $qobj->retrieve_documents($conn);

	while($row = $doclist->fetch()) {
		echo $row['doc_id']." => ";
		echo $row['content'];
		$content = explode(' ', $row['content']);
		array_push($docidlist, $row['doc_id']);
		array_push($contentlist, $content);
		echo "<br>";
	}
	$collection = array_combine($docidlist, $contentlist);
	$dictionary = array();
	// create dictionary list
	foreach($collection as $doc=>$content) {
		foreach($content as $i=>$word) {
			$word = strtolower($word);
			array_push($dictionary, array($word, $doc));
		}
	}
	/* create dictionary ends*/

	/*wavelet creation starts*/
	$A = array();
	$B = array();
	$n = count($dictionary);
	$docn = count($docidlist);
	for($i = 0; $i<$n; $i++) {
		$val = $dictionary[$i][1];
		$A[$i] = $val;
		if($val <=$docn/2)
			$B[$i] = 0;
		else $B[$i] = 1;
	}
	$wtree->insert($A, $B);
	$t_create_end = microtime(true);
	/*wavelet creation ends*/

	/*searching starts*/
	$t_search_start = microtime(true);
	$x = array();
	echo "<br>We have";
	foreach($keys as $keyword) {
		echo ", $keyword";
		$keyword = strtolower($keyword);
		foreach($dictionary as $k=>$kd) {
			if($keyword == $kd[0]) {
				$temp = $wtree->currentNode();
				$tpos = $k;
				array_push($x, $wtreeop->display($temp, $tpos));
			}
		}
	}
	$x = array_unique($x);
	asort($x);
	var_dump($x);
	$t_search_end = microtime(true);
	/*searching ends*/
	echo "For indexing=> ".($ct = $t_create_end - $t_create_start)."<br>";
	echo "For searching=> ".($st = $t_search_end - $t_search_start)."<br>";
	echo "For total=> ".($st + $ct);
}

?>
<form action="searchwavelet.php" method="POST">
	Enter keyword to search:<input type="text" name="keyword"><br>
	<input type="submit" value="Find">
</form>