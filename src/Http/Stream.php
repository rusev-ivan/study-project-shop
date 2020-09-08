<?php

namespace Shop\Http;

use Psr\Http\Message\StreamInterface;

final class Stream implements StreamInterface
{
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function __toString()
    {
        return $this->getContents();
    }

    public function getContents(): string
    {
        return $this->content;
    }

    public function write($string)
    {
        $this->content .= $string;
    }

    public function getSize()
    {
        return mb_strlen($this->content);
    }

    public function close()
    {
        // TODO: Implement close() method.
    }

    public function detach()
    {
        // TODO: Implement detach() method.
    }

    public function tell()
    {
        // TODO: Implement tell() method.
    }

    public function eof()
    {
        // TODO: Implement eof() method.
    }

    public function isSeekable()
    {
        // TODO: Implement isSeekable() method.
    }

    public function seek($offset, $whence = SEEK_SET)
    {
        // TODO: Implement seek() method.
    }

    public function rewind()
    {
        // TODO: Implement rewind() method.
    }

    public function isWritable()
    {
        // TODO: Implement isWritable() method.
    }

    public function isReadable()
    {
        // TODO: Implement isReadable() method.
    }

    public function read($length)
    {
        // TODO: Implement read() method.
    }

    public function getMetadata($key = null)
    {
        // TODO: Implement getMetadata() method.
    }
}