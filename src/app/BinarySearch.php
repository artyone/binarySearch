<?php

namespace app;

use SplFileObject;

class BinarySearch
{
    CONST NOT_FOUND = 'undef';
    CONST FOUND_IN_FIRST = 'first';
    CONST NEED_FIND = 'find';
    private $key;
    private $file;
    private $size;

    public function __construct($path, $key)
    {
        $this->key = $key;
        $this->file = new SplFileObject($path, 'r');
        $this->size = filesize($path);
    }

    private function getArray(string $string): array
    {
        $array = explode("\n", $string);
        $array = explode("\t", $array[0]);
        return $array;
    }

    private function getFirsLine(): string
    {
        $this->file->fseek(0);
        return $this->file->current();
    }

    private function getLastLine(): string
    {
        $this->file->fseek($this->size - 4001);
        while ($this->file->current()) {
            $string = $this->file->current();
            $this->file->next();
        }
        return $string;
    }

    private function compareFirst(): string
    {
        switch (strnatcmp($this->key, $this->getArray($this->getFirsLine())[0])) {
            case -1:
                return self::NOT_FOUND;
                break;
            case 0:
                return self::FOUND_IN_FIRST;
                break;
            case 1:
                return self::NEED_FIND;
                break;
        }
        return self::NOT_FOUND;
    }

    private function getLine(int $position): string
    {
        $this->file->fseek($position);
        $this->file->current();
        $this->file->next();
        return $this->file->current();
    }

    private function binarySearch(int $min, int $max): string
    {
        if ($max - $min < 1) {
            return self::NOT_FOUND;
        }

        $result = $this->getArray($this->getLine(($max + $min) / 2));

        if ($result[0] == "") {
            return self::NOT_FOUND;
        }

        switch (strnatcmp($this->key, $result[0])) {
            case -1:
                return $this->binarySearch($min, ($max + $min) / 2);
                break;
            case 1:
                return $this->binarySearch(($max + $min) / 2, $max);
                break;
        }
        return $result[1];
    }

    public function search(): string
    {
        switch ($this->compareFirst()) {
            case self::NOT_FOUND:
                return self::NOT_FOUND;
                break;
            case self::FOUND_IN_FIRST:
                return $this->getArray($this->getFirsLine())[1];
                break;
            case self::NEED_FIND:
                return $this->binarySearch(0, $this->size);
                break;
        }
        return self::NOT_FOUND;
    }
}