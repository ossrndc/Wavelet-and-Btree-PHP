<?php
class WaveletNode {
	public $parent;
	public $value;
	public $left;
	public $right;
	public $bmap;

	public function __construct($a, $b) {
		$this->parent = null;
		$this->value = $a;
		$this->bmap = $b;
		$this->left = null;
		$this->right = null;
	}

	public function dump() {
		if ($this->left !== null) {
            echo "left";
            $this->left->dump();
            
        }
        echo "{Value=";
        var_dump($this->value);
        echo "}  {bmap=";
        var_dump($this->bmap);
        echo "}";
        if ($this->right !== null) {
            echo "right";
            $this->right->dump();
        	
        }
	}

}

class WaveletTree {
	protected $root;

	public function __construct() {
		$this->root = null;
	}

	public function isEmpty() {
		return $this->root === null;
	}

	public function insert($a, $b) {
		$node = new WaveletNode($a, $b);
		$this->root = $node;
		$this->root = $this->insertNode($this->root);
	}

	public function insertNode(&$subTree) {
		$lval = array(); $lbit = array();
		$rval = array(); $rbit = array();

		$lenroot = count($subTree->value);
		$z = 1;$y=1;
		for($i = 0; $i < $lenroot; $i ++) {
			if($subTree->bmap[$i] == 0) {
				$z++;
				array_push($lval, $subTree->value[$i]);
			}
			else{
				$y++;
				array_push($rval, $subTree->value[$i]);	
			}
		}
		if($z <= $lenroot && $y <= $lenroot) {
			$lbit = $this->calculatebmap($lval);
			$rbit = $this->calculatebmap($rval);

			$l = new WaveletNode($lval, $lbit);
			$r = new WaveletNode($rval, $rbit);
			$subTree = $this->assignleft($subTree, $l);
			$subTree = $this->assignright($subTree, $r);
			$l = $this->assignparent($subTree, $l);
			$r = $this->assignparent($subTree, $r);
			$l = $this->insertNode($l);
			$r = $this->insertNode($r);
		}
		else if($subTree->value != null) {
			$subTree->value = $subTree->value[0];
			$subTree->bmap = 0;
		}
		return $subTree;
	}

	public function calculatebmap($a) {
		$b = array();
		$min = min(array_unique($a));
		$max = max(array_unique($a));
		for($i = 0; $i< count($a); $i++) {
			$val = $a[$i];
			if($val-$min <($max-$min + 1)/2)
				$b[$i] = 0;
			else $b[$i] = 1;
		}
		return $b;
	}

	public function assignleft($node, $l) {
		$node->left = $l;
		return $node;
	}

	public function assignright($node, $r) {
		$node->right = $r;
		return $node;
	}

	public function assignparent($node, $sub) {
		$sub->parent = $node;
		return $sub;
	}

	public function traverse() {
		$this->root->dump();
	}

	public function currentNode() {
		return $this->root;
	}

	public function storeInDb() {
		
	}
}

class WaveletOperation {
	public function rank($bmap, $symbol, $pos) {
		//x = rank(bmap,symbol,pos) = in series bmap, symbol appears x times from 1 to pos
		//if we know pos of our symbol and want to find out the doc_id related to it
		$count = 0;
		for($k = 1; $k < $pos; $k++) {
			if($bmap[$k] == $symbol) {
				$count ++;
			}
		}
		return $count;
	}

	public function select($bmap, $symbol, $pos) {
		//y = select(B,b,i) = in series bmap, posth occurence of symbol appears at position y
		$i = 0;$c = 0;
		while($c!=$pos && $i<count($bmap) ) {
			if($bmap[$i] == $symbol) {
				$c ++;
			}
			$i++;
		}
		return $c;
	}

	public function display($temp, $pos) {
		$symbol = $temp->bmap[$pos];
		$x = $this->rank($temp->bmap, $symbol, $pos);
		while($x <= count($temp->bmap) && ($temp->left)) {
			$symbol;
			if($symbol == 0) {
				$temp = $temp->left;
			}
			else if($symbol == 1){
				$temp = $temp->right;}
			$tpos = $x;
			$symbol = $temp->bmap[$tpos];
			$x = $this->rank($temp->bmap, $symbol, $tpos);
		}
		// var_dump($temp->parent->value);
		$actualValue = $temp->value;
		return $actualValue;	
	}

	public function count($bmap, $symbol) {
		$x = $this->rank($bmap, $symbol, count($bmap));
		return $x;
	}
}

class BNode {
	public $leaf;
	public $n;
	public $c;
	public $key;
	public $doc;
	public function __construct() {
		$this->c = null;
		$this->n = 0;
		$this->leaf = true;
		$this->key = null;
		$this->doc = null;
	}

	public function dump() {
		var_dump($this->key);
		var_dump($this->doc);
		if($this->c !== null) {
			echo "Child {";
			foreach($this->c as $v)
				$v->dump();
			echo " }";
		}
	}
}

class BTree {
	protected $root;
	public $degree = 3;

	public function __construct() {
		$this->root = null;
		$this->degree = 3;
	}

	public function currentNode() {
		return $this->root;
	}

	public function create() {
		$node = new BNode();
		$node->leaf = true;
		$node->n = 0;
		// diskwrite [x]
		$this->root = $node;
	}

	public function splitChild($x, $i) {
		$t = $this->degree;
		$z = new BNode();
		$y = $x->c[$i];
		$z->leaf = $y->leaf;
		$z->n = $t - 1;
		for($j = 1; $j <= $t -1; $j++) {
			$z->key[$j] = $y->key[$j + $t];
			$z->doc[$j] = $y->doc[$j + $t];
		}
		for($j = 1; $j <= $t -1; $j++) {
			array_pop($y->doc);
			array_pop($y->key);
		}
		if($y->leaf == false) {
			for($j = 1; $j <= $t; $j ++) {
				$z->c[$j] = $y->c[$j + $t];
			}
			for($j = 1; $j <= $t; $j ++) {
				array_pop($y->c);
			}
		}
		$y->n = $t - 1;
		for($j = $x->n +1 ; $j >= $i+1; $j --) {
			$x->c[$j + 1] = $x->c[$j];
		}
		$x->c[$i + 1] = $z;
		for($j = $x->n ; $j >= $i; $j --) {
			$x->key[$j + 1] = $x->key[$j];
			$x->doc[$j + 1] = $x->doc[$j];
		}
		$x->key[$i] = $y->key[$t];
		array_pop($y->key);
		$x->doc[$i] = $y->doc[$t];
		array_pop($y->doc);
		$x->n = $x->n + 1;
		// $arr = array($x, $y, $z);
		return $x;
		// disk write y , z, x
	}
	public function isEmpty() {
		return $this->root === null;
	}

	public function insert($k) {
		$t = $this->degree;

		if($this->isEmpty()) {
			$this->create();
		}
		$r = $this->root;
		if($r->n == ($t*2 - 1)) {
			$s = new BNode();
			$this->root = $s;
			$s->leaf = false;
			$s->n = 0;
			$s->c[1] = $r;
			$s = $this->splitChild($s, 1);
			$this->insertNonFull($s, $k);
		}
		else $this->insertNonFull($r, $k);
	}

	public function insertNonFull($x, $k) {
		$i = $x->n;
		$t = $this->degree;
		if($x->leaf) {
			while($i >= 1 && strcmp($k[0] , $x->key[$i]) < 0) {
				$x->key[$i + 1] = $x->key[$i];
				$x->doc[$i + 1] = $x->doc[$i];
				$i = $i - 1;
			}
			$x->key[$i + 1] = $k[0];
			$x->doc[$i + 1] = $k[1];
			$x->n = $x->n + 1;
			// diskwrite x
		}
		else {
			while($i >= 1 && strcmp($k[0] , $x->key[$i]) < 0) {
				$i = $i - 1;
			}
			$i = $i + 1;
			// disk read x.c[i]
			if($x->c[$i]->n == ($t*2 - 1)) {
				$x = $this->splitChild($x, $i);
				if(strcmp($k[0] , $x->key[$i]) > 0) {
					$i = $i +1;
				}
			}

			$this->insertNonFull($x->c[$i], $k);
		}
	}

	public function traverse() {
		$this->root->dump();
	}
}

class BOperation {
	public function search($x, $k) {
		$i = 1;
		while($i <= $x->n && strcmp($k, $x->key[$i]) > 0) {
			// echo "$i = $k vs ".$x->key[$i]."<br>";
			$i = $i + 1;
		}
		if($i <= $x->n && strcmp($k, $x->key[$i]) == 0) {
			// echo "found";
			return $x->doc[$i];
		}
		if($x->leaf) {
			// echo "leaf";
			return NIL;
		}
		return $this->search($x->c[$i], $k);
	}
}
?>