<?php
require('jsonhttpinterface/JsonHttpInterface.php');

define('DB_DSN', 'mysql:dbname=twocents;host=127.0.0.1');
define('DB_USER', 'twocents');
define('DB_PASS', 'password');

class TwoCentsService {
    private $db;

    protected function get_db() {
        if (empty($this->db)) {
            $this->db = new PDO(DB_DSN, DB_USER, DB_PASS);
        }
        return $this->db;
    }

    function get($path) {
        if (!is_string($path))
            throw new Exception('Path must be a string.');

        $db = $this->get_db();
        
        // Get the five most recent entries for the specified path.
        $qry = $db->prepare(
            'SELECT id, UNIX_TIMESTAMP(added) AS added, name, message ' .
            'FROM twocents ' .
            'WHERE path = ? ' .
            'ORDER BY added DESC LIMIT 5');
        $qry->execute(array($path));

        return $qry->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function put($path, $name, $message) {
        if (!is_string($path))
            throw new Exception('Path must be a string.');
        if (!is_string($name))
            throw new Exception('Name must be a string.');
        if (!is_string($message))
            throw new Exception('Message must be a string.');

        $db = $this->get_db();

        // TODO: Prevent duplicate postings.
        
        $qry = $db->prepare(
            'INSERT INTO twocents (path, name, message) VALUES (?, ?, ?)');
        $qry->execute(array($path, $name, $message));
        
        return $this->get($path);
    }
}

$svc = new TwoCentsService();
$jhi = new JsonHttpInterface($svc);
$jhi->exec();
?>
