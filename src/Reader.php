<?php

namespace Bondacom\LaravelFileManager;

use Bondacom\Antenna\Exceptions\ReaderNotExistsException;
use Bondacom\LaravelFileManager\Utilities\Utility;

class Reader extends Utility
{
    /**
     * @param string $filepath
     * @return \Bondacom\LaravelFileManager\Readers\Reader
     */
    public function open($filepath)
    {
        return $this->getStrategy()->open($filepath);
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        $this->config(['handler' => $name]);

        return $this;
    }

    /**
     * @return \Illuminate\Foundation\Application|mixed
     * @throws \Exception
     */
    protected function getStrategy()
    {
        $type = $this->config('handler');

        switch ($type) {
            case 'txt':
                return app(\Bondacom\LaravelFileManager\Readers\Txt::class);
            case 'csv':
                return app(\Bondacom\LaravelFileManager\Readers\Csv::class);
            default:
                throw new ReaderNotExistsException($type);
        }
    }
}