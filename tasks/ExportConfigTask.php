<?php
/**
 * ExportConfigTask.php
 * @author Revin Roman
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\tasks;

/**
 * Class ExportConfigTask
 * @package cookyii\build\tasks
 */
class ExportConfigTask extends AbstractTask
{

    /** @var string|callable|null */
    public $formatter;

    /** @var string|null */
    public $exportToFile;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $exportToFile = empty($this->exportToFile)
            ? null
            : $this->exportToFile;

        $exportToFile = $this->getAbsolutePath($exportToFile);

        if (empty($exportToFile)) {
            if ($this->output->isVerbose()) {
                $this->log('<task-result> EXPORT </task-result>');
            }

            echo $this->dump($this->command->rawConfig);
        } else {
            $this->getFileSystemHelper()
                ->dumpFile($exportToFile, $this->dump($this->command->rawConfig), 0664);

            if ($this->output->isVerbose()) {
                $this->log(sprintf('<task-result> EXPORT </task-result> to %s', $exportToFile));
            }
        }

        return true;
    }

    /**
     * @param array $config
     * @return string
     */
    private function dump(array $config)
    {
        $result = null;

        if (is_callable($this->formatter)) {
            $result = call_user_func($this->formatter, $config);
        } else {
            switch ($this->formatter) {
                default:
                case 'php':
                    $result = $this->phpFormat($config);
                    break;
                case 'json':
                    $result = json_encode($config, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    break;
                case 'xml':
                    $result = $this->xmlFormat($config);
                    break;
            }
        }

        return $result;
    }

    /**
     * @param array $config
     * @param integer $indent
     * @return string
     */
    private function xmlFormat(array $config, $indent = 0)
    {
        $result = '';

        $xml = new \Sabre\Xml\Writer();

        return '';
    }

    /**
     * @param array $config
     * @param integer $indent
     * @return string
     */
    private function phpFormat(array $config, $indent = 0)
    {
        $result = '';

        if ($indent === 0) {
            $result .= '<?php' . "\n\n" . 'return ';
        }

        $result .= '[' . "\n";

        if (!empty($config)) {
            foreach ($config as $k => $v) {
                $result .= str_repeat('    ', $indent + 1);
                if ($k === '.events') {
//                    dump([
//                        $k,
//                        $config[$k],
//                    ], 2);
                }

                if (!$this->isAssocArray($config)) {
                    $result .= '\'' . str_replace('\'', '\\\'', $k) . '\' => ';
                }

                if (is_bool($v)) {
                    $result .= (bool)$v === true ? 'true' : 'false';
                    $result .= ',' . "\n";
                }

                if (is_string($v)) {
                    $result .= '\'' . str_replace('\'', '\\\'', $v) . '\'';
                    $result .= ',' . "\n";
                }

                if (is_array($v)) {
                    $result .= $this->phpFormat($v, $indent + 1);
                }
            }
        }

        if ($indent === 0) {
        } else {
            $result .= str_repeat('    ', $indent);
        }

        $result .= ']';

        if ($indent === 0) {
            $result .= ';';
        } else {
            $result .= ',';
        }

        $result .= "\n";

        return $result;
    }

    /**
     * @param array $array
     * @return bool
     */
    private function isAssocArray(array $array)
    {
        return array_keys($array) === range(0, count($array) - 1);
    }
}