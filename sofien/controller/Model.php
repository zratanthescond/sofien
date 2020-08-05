<?php
class Model
{

	static $connections = array();

	public $conf = 'default';
	public $table = false;
	public $db;
	public $primaryKey = 'id';
	public $id;
	public $errors = array();
	public $form;
	public $ret;



	/**
	 * Permet d'initialiser les variable du Model
	 **/
	public function __construct()
	{
		// Nom de la table
		if ($this->table === false) {
			$this->table = strtolower(get_class($this)) . 's';
		}

		// Connection à la base ou récupération de la précédente connection
		$conf = Conf::$databases[$this->conf];
		if (isset(Model::$connections[$this->conf])) {
			$this->db = Model::$connections[$this->conf];
			return true;
		}
		try {
			$pdo = new PDO(
				'mysql:host=' . $conf['host'] . ';dbname=' . $conf['database'] . ';',
				$conf['login'],
				$conf['password'],
				array(1002 => 'SET NAMES utf8')
			);
			$pdo->exec('SET NAMES utf8');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

			Model::$connections[$this->conf] = $pdo;
			$pdo->exec('SET NAMES utf8');
			$this->db = $pdo;
		} catch (PDOException $e) {
			if (Conf::$debug >= 1) {
				die($e->getMessage());
			} else {
				die('Error BD');
			}
		}
	}



	/**
	 * Permet de récupérer plusieurs enregistrements
	 * la requête sql
	 **/
	public function find($req = null)
	{

		$sql = 'SELECT ';

		if (isset($req['distinct'])) {
			$sql .= $req['distinct'] . ' ';
		}
		if (isset($req['fields'])) {
			if (isset($req['comparer'])) {
				$sql .= 'MIN(bid_price)';
				//debug($req['fields']);
			} else {
				if (is_array($req['fields'])) {
					$sql .= implode(', ', $req['fields']);
				} else {
					$sql .= $req['fields'];
				}
			}
		} else {
			if (isset($req['sum'])) {
				$sql .= 'SUM(' . $req['sum'] . ')';
			} else {
				$sql .= '*';
			}
		}
		if (isset($req['findsearch'])) {
			$sql .= ' FROM ' . $req['findsearch'] . ' ';
		} else {
			$sql .= ' FROM ' . $this->table . ' as ' . get_class($this) . ' ';
		}
		// Liaison
		if (isset($req['join'])) {
			foreach ($req['join'] as $k => $v) {
				$sql .= 'LEFT JOIN ' . $k . ' ON ' . $v . ' ';
			}
		}

		// Construction de la condition

		if (isset($req['conditions'])) {
			$sql .= 'WHERE ';
			if (!is_array($req['conditions'])) {
				$sql .= $req['conditions'];
			} else {
				$cond = array();
				foreach ($req['conditions'] as $k => $v) {
					if (is_array($v)) {
						//echo '<br>';
						//print_r($v);
						//echo '<br>';
						//echo $k;
						//echo '<br>';
						$operator = $v['operator'];
						if ($operator == 'BETWEEN') {
							$from = '"' . $v['FROM'] . '"';
							$to = '"' . $v['TO'] . '"';
							$cond[] = "$k $operator $from AND $to";
						} else {
							$value = '"' . $v['value'] . '"';
							$cond[] = "$k $operator $value";
						}

						//echo '<br>';
						//print_r($cond);
						//echo '<br>';

					} else {
						if (!is_numeric($v)) {
							//scape string

							$pos = strpos($v, '>');
							if ($pos === false) {
								$v = '"' . $v . '"';
								$cond[] = "$k=$v";
							} else {

								$cond[] = "$k $v";
							}
						} else {
							$v = '"' . $v . '"';
							$cond[] = "$k=$v";
						}
					}
				}
				$sql .= implode(' AND ', $cond);
			}
		}
		if (isset($req['search'])) {
			foreach ($req['search'] as $k => $v) {
				if (!is_numeric($v)) {
					//scape string
					$v = $v;
					$ser = explode('-', $v);
					$ser1 = str_replace('-', ' ', $v);
					foreach ($ser as $keys => $values) {
						$s = " $keys LIKE '$values%' ";

						if ($keys != count($ser) - 1) {
							$s .= ' OR ';
						}
					}
					$sql .= 'WHERE ' . "$k LIKE '%$ser1%' OR " . $s;

					//debug($sql);
				}
			}
		}

		if (isset($req['order'])) {
			$sql .= ' ORDER BY ' . $req['order'];
		}


		if (isset($req['limit'])) {
			$sql .= ' LIMIT ' . $req['limit'];
		}
		//debug($sql);
		//echo $sql;
		$pre = $this->db->prepare($sql);
		//debug($pre);

		$pre->execute();
		return $pre->fetchAll(PDO::FETCH_OBJ);
	}

	public function findFirst($req)
	{
		return current($this->find($req));
	}

	public function findcount($condition = null)
	{
		$res = $this->findFirst(array(
			'fields' => 'COUNT(' . $this->primaryKey . ')as count',
			'conditions' => $condition
		));

		return $res->count;
	}
	public function delete($id)
	{
		$sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey}= $id";
		$pre = $this->db->prepare($sql);
		$pre->execute();
	}
	public function Save($data)
	{
		$key = $this->primaryKey;
		$action = '';
		$sql = '';
		$filds = array();
		$d = array();



		foreach ($data as $k => $v) {
			$filds[] = "$k=:$k";
			$d[":$k"] = $v;
		}

		if (isset($data->$key) && !empty($data->$key)) {
			$sql = 'UPDATE ' . $this->table . ' SET ' . implode(',', $filds) . ' WHERE ' . $key . '=:' . $key;
			$this->id = $data->$key;
			$action = 'update';
		} else {

			$sql = 'INSERT INTO ' . $this->table . ' SET ' . implode(',', $filds);
			$action = 'insert';
		}


		$pre = $this->db->prepare($sql);
		//echo $sql;
		//debug($pre);
		$pre->execute($d);
		if ($action == 'insert') {
			return $this->id = $this->db->lastInsertId();
		}
	}
}
