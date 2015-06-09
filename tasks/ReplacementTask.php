<?php
/**
 * ReplacementTask.php
 * @author Revin Roman
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\tasks;

/**
 * Class ReplacementTask
 * @package cookyii\build\tasks
 */
class ReplacementTask extends AbstractTask
{

    /** @var string */
    public $filename;

    /** @var array */
    public $placeholders = [];

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (empty($this->filename)) {
            throw new \InvalidArgumentException('Empty filename.');
        }

        if (empty($this->placeholders)) {
            throw new \InvalidArgumentException('Empty placeholders.');
        }

        $filename = $this->getAbsolutePath($this->filename);

        if (!$this->getFileSystemHelper()->exists($filename)) {
            throw new \RuntimeException(sprintf('File "%s" not exists', $filename));
        }

        $content = file_get_contents($filename);
        $result = file_put_contents($filename, str_replace(array_keys($this->placeholders), array_values($this->placeholders), $content));

        if ($this->output->isVerbose()) {
            $this->log('<task-result> REPLACE </task-result> Placeholders replaced.');
        }

        return $result !== false;
    }
}