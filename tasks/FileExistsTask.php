<?php
/**
 * FileExistsTask.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\tasks;

/**
 * Class FileExistsTask
 * @package cookyii\build\tasks
 */
class FileExistsTask extends AbstractTask
{

    /**
     * @var string
     */
    public $filename;

    /**
     * @var string
     */
    public $message;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (empty($this->filename)) {
            throw new \InvalidArgumentException('Empty filename.');
        } else {
            $filename = $this->getAbsolutePath($this->filename);

            if (!$this->getFileSystemHelper()->exists($filename)) {
                $message = empty($this->message)
                    ? 'File "%s" not exists'
                    : $this->message;

                $this->log('<error>' . sprintf($message, $filename) . '</error>');

                return false;
            } else {
                if ($this->output->isVerbose()) {
                    $this->log(sprintf('<task-result> EXISTS </task-result> %s.', $filename));
                }
            }
        }

        return true;
    }
}
