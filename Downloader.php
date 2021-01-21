<?php

class Downloader
{
    protected $path;
    protected $file1;
    protected $file2;
    protected $file_temp = "file_temp.csv";

    public function __construct($path, $file1, $file2)
    {
        $this->path = $path;
        $this->file1 = $file1;
        $this->file2 = $file2;

        if ($this->getNewFile()) {
            $this->changeFiles();
        }
    }

    protected function getNewFile()
    {
        $curl = curl_init();
        $file = fopen($this->file_temp, 'w');
        curl_setopt($curl, CURLOPT_URL, $this->path);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FILE, $file);
        curl_exec($curl);
        curl_close($curl);
        fclose($file);

        return true;
    }

    protected function changeFiles()
    {
        unlink(__DIR__ . '/'.$this->file1);
        rename(__DIR__ . '/'.$this->file2, __DIR__ . '/'.$this->file1);
        rename(__DIR__ . '/'.$this->file_temp, __DIR__ . '/'.$this->file2);

        return true;
    }
}
