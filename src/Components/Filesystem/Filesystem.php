<?php

namespace Shop\Components\Filesystem;

final class Filesystem
{


    public function has(string $path): bool
    {
        return file_exists($path);
    }

    public function create(string $name, string $content = '')
    {
        return file_put_contents($name, $content);
    }

    public function rename(string $oldName, string $newName)
    {
        return rename($oldName, $newName);
    }

    public function newDir(string $name, int $mode = 0777)
    {
        return mkdir($name, $mode);
    }

    public function rmDir(string $name)
    {
        if ($objs = glob($name . '/*')) {
            foreach ($objs as $obj) {
                is_dir($obj) ? $this->rmDir($obj) : unlink($obj);
            }
        }
        return rmdir($name);
    }

    public function scanDir($name)
    {
        $content = [];
        $files = scandir($name);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            if (is_dir($name . '/' . $file)) {
                $filesInDir = $this->scanDir($name . '/' . $file);
                $content[$file] = $filesInDir;
            } else {
                $content[$file] = $file;
            }
        }
        return $content;
    }

    public function read($path)
    {
        return file_get_contents($path);
    }

    public function copy($path, $newPath): bool
    {
        return copy($path, $newPath);
    }
}