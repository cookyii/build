<?php
/**
 * CopyTask.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\tasks;

/**
 * Class CopyTask
 * @package cookyii\build\tasks
 */
class CopyTask extends AbstractTask
{

    /** @var array */
    public $files = [];

    /** @var bool */
    public $override = true;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!empty($this->files)) {
            foreach ($this->files as $from => $to) {
                if (mb_substr($from, 0, 1) !== '/') {
                    $from = $this->getAbsolutePath($from);
                }

                if (mb_substr($to, 0, 1) !== '/') {
                    $to = $this->getAbsolutePath($to);
                }

                if (!file_exists($from)) {
                    $this->log(sprintf('<task-error> ERR </task-error> <error>Source file "%s" not found.</error>.', $from));
                    continue;
                }

                if (!is_file($from)) {
                    $this->log(sprintf('<task-error> ERR </task-error> <error>Source file "%s" is not file.</error>.', $from));
                    continue;
                }

                try {
                    $this->getFileSystemHelper()
                        ->copy($from, $to, $this->override);

                    if ($this->output->isVerbose()) {
                        $this->log(sprintf('<task-result> COPY </task-result> from "%s" to "%s"', $from, $to));
                    }
                } catch (\Exception $e) {
                    $this->log(sprintf('<task-error> ERR </task-error> <error>Unable to copy file "%s"</error>.', $from));
                }
            }
        }

        return true;
    }
}