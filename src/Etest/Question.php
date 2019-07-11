<?php

namespace DynEd\Neo\Etest;

class Question
{
    /** @var int */
    public $id;
    /** @var int */
    public $answerModeId;
    /** @var string */
    public $answerMode;
    /** @var string */
    public $instruction;
    /** @var string */
    public $comments;
    /** @var string */
    public $modifiedBy;
    /** @var int */
    public $typeId;
    /** @var string */
    public $createdAt;
    /** @var string */
    public $updatedAt;

    /**
     * Question constructor
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}