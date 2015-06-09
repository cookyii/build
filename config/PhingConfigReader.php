<?php
/**
 * PhingConfigReader.php
 * @author Revin Roman
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\config;

/**
 * Class PhingConfigReader
 * @package cookyii\build\config
 */
class PhingConfigReader extends AbstractConfigReader
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
            $reader = new \Sabre\Xml\Reader();
            $reader->xml(file_get_contents($this->configFile));

            $xml = $reader->parse();

            $config = [];

            return $config;
        }
    }
}