<?php
/**
 * Created by PhpStorm.
 * User: sunlazor
 * Date: 01.08.18
 * Time: 15:20
 */

namespace App;


use PDO;
use PDOException;
use PDOStatement;

class DB
{
    private $db;

    /**
     * Создание файла БД и запись первоначальных данных
     */
    public function prepare()
    {
        try {
            $this->db = new PDO('sqlite:./db.sqlite');
            $this->db->exec(
                'CREATE TABLE IF NOT EXISTS tree (
                node_id INTEGER PRIMARY KEY, 
                parent_id INTEGER, 
                title TEXT)'
            );

            // Данные для записи
            $initData = [
                [
                    'node_id' => 1,
                    'parent_id' => null,
                    'title' => 'Node 1'],
                [
                    'node_id' => 2,
                    'parent_id' => 1,
                    'title' => 'Node 2'],
                [
                    'node_id' => 3,
                    'parent_id' => 2,
                    'title' => 'Node 3'],
                [
                    'node_id' => 4,
                    'parent_id' => 2,
                    'title' => 'Node 4'],
                [
                    'node_id' => 5,
                    'parent_id' => null,
                    'title' => 'Node 5'],
                [
                    'node_id' => 6,
                    'parent_id' => 5,
                    'title' => 'Node 6'],
                [
                    'node_id' => 7,
                    'parent_id' => 5,
                    'title' => 'Node 7'],
            ];

            $insert = 'INSERT INTO tree (node_id, parent_id, title) 
                VALUES (:node_id, :parent_id, :title)';
            $stmt = $this->db->prepare($insert);
            $stmt->bindParam(':node_id', $node_id);
            $stmt->bindParam(':parent_id', $parent_id);
            $stmt->bindParam(':title', $title);
            foreach ($initData as $row) {
                $node_id = $row['node_id'];
                $parent_id = $row['parent_id'];
                $title = $row['title'];

                $stmt->execute();
            }
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Удаление таблички
     */
    public function clear()
    {
        try {
            $this->db->exec("DROP TABLE tree");
            $this->db = null;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Печать содержимого БД
     */
    public function show()
    {
        $query = $this->getNodesData();

        foreach($query as $row) {
            echo "Id: " . $row['node_id'] . "\n";
            echo "Parent: " . $row['parent_id'] . "\n";
            echo "Title: " . $row['title'] . "\n";
            echo "\n";
        }
    }

    /**
     * Чтения из БД строк с данными по точкам
     *
     * @return false|array
     */
    public function getNodes()
    {
        $query = $this->getNodesData();

        if ($query !== false) {
            $result = [];
            foreach ($query as $obj) {
                $result[] = new Node($obj['node_id'], $obj['parent_id'], $obj['title']);
            }
            return $result;
        }

        return false;
    }

    private function getNodesData()
    {
        try {
            $query = $this->db->query('SELECT * FROM tree', PDO::FETCH_ASSOC)->fetchAll();
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }

        return $query;
    }
}