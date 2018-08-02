<?php

namespace App;

class Tree
{
    private $trees;

    public function __construct()
    {
        $this->trees = [];
    }

    /**
     * Создание многомерного массива представляющего дерево из информации об узлах
     *
     * @param array $nodes Массив объектов класса Node
     */
    public function growAll(array $nodes)
    {
        // Находим корневые элементы
        foreach ($nodes as $node)
        {
            if ($node->getParentNodeId() === null) {
                $this->trees[$node->getNodeId()] = $node;
            }
        }
        if (empty($this->trees)) {
            die('Отсутствуют корневвые точки');
        }
        // -------------------------
        foreach ($this->trees as $tree) {
            $this->growOne($tree, $nodes);
        }
    }

    /**
     * Наращивание "веток и листьев" на корневой элемент
     *
     * @param \App\Node $tree Корневой элемент (с parent_id = null
     * @param array $nodes Массив объектов класса Node
     */
    private function growOne(Node $tree, array $nodes)
    {
        // В стеке хранятся последние привязанные узлы,
        // у которых будут искаться потомки
        $stack[] = $tree;
        do {
            $pop = array_pop($stack);
            foreach ($nodes as $node)
            {
                if ($node->getParentNodeId() == $pop->getNodeId()) {
                    $pop->addChild($node);
                    // Записываем в стек для избежания рекурсии
                    $stack[] = $node;
                }
            }
        } while (!empty($stack));
    }

    public function show()
    {
        print_r($this->trees);
    }
}