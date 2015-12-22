<?php

class Queries {

	public function retrieve_documents($conn) {
		$sql = "SELECT * FROM pages";
		$run = $conn->prepare($sql);
		$run->execute();
		return $run;
	}

	public function word_exist($conn, $word) {
		$sql = "SELECT frequency FROM dictionary WHERE word=:word";
		$run = $conn->prepare($sql);

		$run->bindParam(':word', $word);
		$run->execute();

		if($run->rowCount() > 0)
			return true;
		return false;
	}
	
	public function dict_insert($conn, $word) {
		$sql = "INSERT INTO dictionary(frequency, word) VALUES (:frequency, :word) ON DUPLICATE KEY UPDATE frequency=VALUES(frequency + 1), word=VALUES(word)";
		$run = $conn->prepare($sql);
		$frequency = 1;

		$run->bindParam(':word', $word);
		$run->bindParam(':frequency', $frequency);
		$run->execute();		
	}

	public function doc_insert($conn, $docid, $word) {
		$sql = "INSERT INTO documents(doc_id, word) VALUES (:docid, :word) ON DUPLICATE KEY UPDATE doc_id=VALUES(doc_id), word=VALUES(word)";
		$run = $conn->prepare($sql);

		$run->bindParam(':word', $word);
		$run->bindParam(':docid', $docid);
		$run->execute();
	}

	public function inv_insert($conn, $word, $docid, $pos) {
		$sql = "INSERT INTO inverted_index(word, doc_id, position) VALUES (:word, :docid, :pos) ON DUPLICATE KEY UPDATE doc_id=VALUES(doc_id), word=VALUES(word), position=VALUES(position) ";
		$run = $conn->prepare($sql);

		$run->bindParam(':word', $word);
		$run->bindParam(':docid', $docid);
		$run->bindParam(':pos', $pos);
		$run->execute();		
	}

	public function get_total_doc($conn) {
		$sql = "SELECT COUNT(DISTINCT doc_id) FROM inverted_index";
		$run = $conn->prepare($sql);

		$run->execute();
		return $run;
	}
}

?>