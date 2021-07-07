<?php

namespace DynEd\Neo\Etest;

class Question
{
    /**
     * Question ID
     *
     * @var int
     */
    public $id;

    /**
     * Answer mode ID
     *
     * @var int
     */
    public $answerModeId;

    /**
     * Answer mode
     *
     * @var string
     */
    public $answerMode;

    /**
     * Instructions
     *
     * @var string
     */
    public $instructions;

    /**
     * Comments
     *
     * @var string
     */
    public $comments;

    /**
     * Modified by
     *
     * @var string
     */
    public $modifiedBy;

    /**
     * Question type ID
     *
     * @var int
     */
    public $typeId;

    /**
     * Created at
     *
     * @var string
     */
    public $createdAt;

    /**
     * Updated at
     *
     * @var string
     */
    public $updatedAt;

    /**
     * Question constructor
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{camelize($key)} = $value;
        }
    }
}