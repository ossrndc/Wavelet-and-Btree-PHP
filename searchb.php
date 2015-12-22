<?php
include 'db.php';
include 'queries.php';
include 'classes.php';

if(isset($_POST['keyword'])) {
	$keyword = $_POST['keyword'];
	$keys = explode(' ', $keyword);

	/*create dictionary starts*/
	$t_create_start = microtime(true);
	$qobj = new Queries();
	$btree = new BTree();
	$btreeop = new BOperation();

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
	$l = array();
	// create dictionary list
	foreach($collection as $doc=>$content) {
		foreach($content as $i=>$word) {
			$word = strtolower($word);
			if(array_key_exists($word, $dictionary)) {
				$l = $dictionary[$word];
				array_push($l, $doc);
				$contentlist = array($word=>$l);
				$dictionary = array_replace($dictionary, $contentlist);
			}
			else
				$dictionary[$word] = array($doc);
		}
	}
	/*create dictionary ends*/

	/*btree creation starts*/
	foreach($dictionary as $w=>$d) {
		$item = array($w, $d);
		$btree->insert($item);
	}
	$t_create_end = microtime(true);
	/*btree creation ends*/

	/*searching starts*/
	$t_search_start = microtime(true);
	$x = array();
	echo "<br>We have";
	foreach($keys as $keyword) {
		echo ", $keyword";
		$keyword = strtolower($keyword);
		$temp = $btree->currentNode();
		$d = $btreeop->search($temp, $keyword);
		foreach($d as $w) {
			array_push($x, $w);
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
<form action="searchb.php" method="POST">
	Enter keyword to search:<input type="text" name="keyword"><br>
	<input type="submit" value="Find">
</form>