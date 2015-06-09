<?php
/**
 * JsonConfigReader.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\config;

/**
 * Class JsonConfigReader
 * @package cookyii\build\config
 */
class JsonConfigReader extends AbstractConfigReader
{

    /**
     * @return array
     * @throws \Exception
     */
    public function read()
    {
        if (!file_exists($this->configFile)) {
            $this->log('<error>Config file not exists.</error>');

            return false;
        } else {
            $config = json_decode(file_get_contents($this->configFile), true);

            return $config;
        }
    }
}