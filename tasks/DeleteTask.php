<?php
/**
 * DeleteTask.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\tasks;

/**
 * Class DeleteTask
 * @package cookyii\build\tasks
 */
class DeleteTask extends AbstractTask
{

    /**
     * @var array
     */
    public $fileSets = [];

    /**
     * @var bool
     */
    public $deleteDir = false;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!empty($this->fileSets)) {
            foreach ($this->fileSets as $fileSet) {
                $fileSet = is_string($fileSet)
                    ? ['dir' => $fileSet]
                    : $fileSet;

                if (mb_substr($fileSet['dir'], 0, 1) !== '/') {
                    $fileSet['dir'] = $this->getAbsolutePath($fileSet['dir']);
                }

                $FileSet = new \cookyii\build\components\FileSet();
                $FileSet->configure($fileSet);

                $dirs = [];
                foreach ($FileSet->getListIterator() as $File) {
                    if ($File->isDir()) {
                        $dirs[] = $File->getPathname();
                    }

                    if ($File->isFile() || $File->isLink()) {
                        try {
                            $this->getFileSystemHelper()
                                ->remove($File->getPathname());

                            if ($this->output->isVerbose()) {
                                $this->log(sprintf('<task-result> DEL </task-result> %s', $File->getPathname()));
                            }
                        } catch (\Exception $e) {
                            $this->log(sprintf('<task-error> ERR </task-error> <error>Unable to unlink file "%s"</error>.', $File->getPathname()));
                        }
                    }
                }

                if (!empty($dirs)) {
                    $dirs = array_reverse($dirs);
                    foreach ($dirs as $dir) {
                        try {
                            $this->getFileSystemHelper()
                                ->remove($dir);

                            if ($this->output->isVerbose()) {
                                $this->log(sprintf('<task-result> DEL </task-result> %s', $dir));
                            }
                        } catch (\Exception $e) {
                            $this->log(sprintf('<task-error> ERR </task-error> <error>Unable to remove directory "%s"</error>.', $dir));
                        }
                    }
                }

                if ($this->deleteDir) {
                    $dir = $fileSet['dir'];

                    try {
                        $this->getFileSystemHelper()
                            ->remove($dir);

                        if ($this->output->isVerbose()) {
                            $this->log(sprintf('<task-result> DEL </task-result> %s', $dir));
                        }
                    } catch (\Exception $e) {
                        $this->log(sprintf('<task-error> ERR </task-error> <error>Unable to remove directory "%s"</error>.', $dir));
                    }
                }
            }
        }

        return true;
    }
}
