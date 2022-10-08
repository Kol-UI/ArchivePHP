<?php


abstract class AbstractPdoManager
{
	/**
	 * @var \PDO
	 */
	protected $pdo;

	public function __construct()
	{
		try {
			$this->pdo = new PDO("mysql:dbname=blog;host=mysql:3306", "root", "root");
		} catch (\PDOException $e) {
			echo "Connection impossible à la BDD";
			die;
		}
	}
}