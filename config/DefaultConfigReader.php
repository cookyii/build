<?php
/**
 * DefaultConfigReader.php
 * @author Revin Roman
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\config;

/**
 * Class DefaultConfigReader
 * @package cookyii\build\config
 */
class DefaultConfigReader extends AbstractConfigReader
{

    /**
     * @return array
     */
    public function read()
    {
        if (!file_exists($this->configFile)) {
            $this->log('<error>Config file not exists.</error>');

            return false;
        } else {
            $config = include($this->configFile);

            return $config;
        }
    }
}