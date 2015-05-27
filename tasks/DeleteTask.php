<?php
/**
 * DeleteTask.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\tasks;

/**
 * Class DeleteTask
 * @package cookyii\build\tasks
 */
class DeleteTask extends AbstractTask
{

    /** @var array */
    public $fileSets = [];

    /** @var bool */
    public $deleteDir = false;

    /**
     * @return bool
     */
    public function run()
    {
        if (!empty($this->fileSets)) {
            foreach ($this->fileSets as $fileSet) {
                $fileSet = is_string($fileSet)
                    ? ['dir' => $fileSet]
                    : $fileSet;

                if (mb_substr($fileSet['dir'], 0, 1, 'utf-8') !== '/') {
                    $fileSet['dir'] = $this->command->configReader->basePath . DIRECTORY_SEPARATOR . $fileSet['dir'];
                }

                $FileSet = new \cookyii\build\components\FileSet();
                $FileSet->configure($fileSet);

                $dirs = [];
                foreach ($FileSet->getListIterator() as $File) {
                    if ($File->isDir()) {
                        $dirs[] = $File->getPathname();
                    }

                    if ($File->isFile() || $File->isLink()) {
                        if (!unlink($File->getPathname())) {
                            $this->log(sprintf('<task-error> ERR </task-error> <error>Unable to unlink file "%s"</error>.', $File->getPathname()));
                        } else {
                            if ($this->output->isVerbose()) {
                                $this->log(sprintf('<task-result> DEL </task-result> %s', $File->getPathname()));
                            }
                        }
                    }
                }

                if (!empty($dirs)) {
                    $dirs = array_reverse($dirs);
                    foreach ($dirs as $dir) {
                        if (!rmdir($dir)) {
                            $this->log(sprintf('<task-error> ERR </task-error> <error>Unable to remove directory "%s"</error>.', $dir));
                        } else {
                            if ($this->output->isVerbose()) {
                                $this->log(sprintf('<task-result> DEL </task-result> %s', $dir));
                            }
                        }
                    }
                }

                if ($this->deleteDir) {
                    $dir = $fileSet['dir'];

                    if (!rmdir($dir)) {
                        $this->log(sprintf('<task-error> ERR </task-error> <error>Unable to remove directory "%s"</error>.', $dir));
                    } else {
                        if ($this->output->isVerbose()) {
                            $this->log(sprintf('<task-result> DEL </task-result> %s', $dir));
                        }
                    }
                }
            }
        }

        return true;
    }
}