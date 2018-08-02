<?php

namespace App;

class Node
{
    private $nodeId;
    private $parentNodeId;
    private $title;
    private $children;

    public function __construct(int $nodeId, $parentNodeId, string $title)
    {
        $this->nodeId = $nodeId;
        $this->parentNodeId = $parentNodeId;
        $this->title = $title;
        $this->children = [];
    }

    /**
     * @return int
     */
    public function getNodeId()
    {
        return $this->nodeId;
    }

    /**
     * @return int|null
     */
    public function getParentNodeId()
    {
        return $this->parentNodeId;
    }

    public function addChild(Node $child)
    {
        $this->children[$child->getNodeId()] = $child;
    }
}