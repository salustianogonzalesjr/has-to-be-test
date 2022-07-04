<?php

namespace App\Exceptions;

class InvalidDataException extends \Exception
{
    protected $message;

    /**
     * @param string $message
     * @return $this
     */
    public function setInvalidVasRequestDataMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInvalidVasRequestDataMessage()
    {
        return $this->message;
    }
}
