<?php

class Comparator
{
    public $old_items = [];
    public $new_items = [];
    public $file1;
    public $file2;

    public function __construct($file1, $file2)
    {
        $this->old_items = $this->defineItems($file1);
        $this->new_items = $this->defineItems($file2);
        $this->file1 = $this->fileInfo($file1);
        $this->file2 = $this->fileInfo($file2);
    }

    protected function defineItems($name)
    {
        $lines = [];
        $items = [];
    
        $file_handle = fopen($name, 'r');
        while (!feof($file_handle)) {
            $lines[] = fgetcsv($file_handle, 0, ',');
        }
        fclose($file_handle);
    
        foreach ($lines as $line) {
            if ($line) {
                $items[$line[0]] = [$line[1], $line[2]];
            }
        }
    
        return $items;
    }

    protected function fileInfo($name)
    {
        return date("d-m-Y H:i:s.", filemtime($name));
    }

    public function getNewProducts()
    {
        $items = [];

        foreach ($this->new_items as $key => $new_item) {
            if (!array_key_exists($key, $this->old_items)) {
                $items[] = $key;
            }
        }

        return $items;
    }

    public function getMissedProducts()
    {
        $items = [];

        foreach ($this->old_items as $key => $old_item) {
            if (!array_key_exists($key, $this->new_items)) {
                $items[] = $key;
            }
        }

        return $items;
    }

    public function getDifferences()
    {
        $items = [];

        foreach ($this->old_items as $key => $old_item) {
            if (array_key_exists($key, $this->new_items) && ($old_item[0] != $this->new_items[$key][0] || $old_item[1] != $this->new_items[$key][1])) {
                $items[] = $key;
            }
        }

        return $items;
    }
}
