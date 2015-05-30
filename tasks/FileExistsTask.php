<?php
/**
 * FileExistsTask.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\tasks;

/**
 * Class FileExistsTask
 * @package cookyii\build\tasks
 */
class FileExistsTask extends AbstractTask
{

    /** @var string */
    public $filename;

    /** @var string */
    public $message;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (empty($this->filename)) {
            throw new \InvalidArgumentException('Empty filename.');
        } else {
            $fs = new \Symfony\Component\Filesystem\Filesystem();

            $filename = $this->filename;
            if (!$fs->isAbsolutePath($filename)) {
                $filename = $this->command->configReader->basePath . DIRECTORY_SEPARATOR . $filename;
            }

            if (!$fs->exists($filename)) {
                $message = empty($this->message)
                    ? 'File "%s" not exists'
                    : $this->message;

                $this->log('<error>' . sprintf($message, $filename) . '</error>');

                return false;
            } else {
                if ($this->output->isVerbose()) {
                    $this->log(sprintf('File %s exist.', $filename));
                }
            }
        }

        return true;
    }
}