<?php
/**
 * ChowTask.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\tasks;

/**
 * Class ChowTask
 * @package cookyii\build\tasks
 */
class ChmodTask extends AbstractTask
{

    /** @var string|null */
    public $filename;

    /** @var array */
    public $fileSets = [];

    /** @var string */
    public $dirMode = 0775;

    /** @var string */
    public $fileMode = 0664;

    /** @var bool */
    public $skipOnError = true;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (empty($this->dirMode)) {
            throw new \InvalidArgumentException('Empty directory mode.');
        }

        if (empty($this->fileMode)) {
            throw new \InvalidArgumentException('Empty file mode.');
        }

        if (!empty($this->filename)) {
            $this->filename = $this->getAbsolutePath($this->filename);

            $this->chmod($this->filename, $this->dirMode, $this->fileMode);
        }

        if (!empty($this->fileSets)) {
            foreach ($this->fileSets as $fileSet) {
                $fileSet = is_string($fileSet)
                    ? ['dir' => $fileSet]
                    : $fileSet;

                if (mb_substr($fileSet['dir'], 0, 1, 'utf-8') !== '/') {
                    $fileSet['dir'] = $this->command->configReader->basePath . DIRECTORY_SEPARATOR . $fileSet['dir'];
                }

                if (!file_exists($fileSet['dir']) || !is_dir($fileSet['dir'])) {
                    continue;
                }

                $FileSet = new \cookyii\build\components\FileSet();
                $FileSet->configure($fileSet);

                foreach ($FileSet->getListIterator() as $File) {
                    $this->chmod($File->getPathname(), $this->dirMode, $this->fileMode);
                }

                $this->chmod($fileSet['dir'], $this->dirMode, $this->fileMode);
            }
        }

        return true;
    }

    /**
     * @param string $filename
     * @param integer $dirMode
     * @param integer $fileMode
     * @throws \Exception
     */
    private function chmod($filename, $dirMode, $fileMode)
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline, array $errcontext) {
            // error was suppressed with the @-operator
            if (0 === error_reporting()) {
                return false;
            }

            throw new \Exception($errstr, $errno);
        });

        $mode = is_dir($filename) ? $dirMode : $fileMode;

        if ($this->output->isVerbose()) {
            $this->log(sprintf('<task-result> MOD </task-result> 0%s => %s', decoct((int)$mode), $filename));
        }

        try {
            chmod($filename, $mode);
        } catch (\Exception$e) {
            if ($e->getMessage() === 'chmod(): Operation not permitted') {
                if ($this->output->getVerbosity() === \Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL) {
                    $this->log(sprintf('<task-error> ERR </task-error> 0%s => %s', decoct((int)$mode), $filename));
                }

                if (true === $this->skipOnError) {
                    $this->log('<task-error> ERR </task-error> Operation not permitted');
                } else {
                    throw new \Exception($e->getMessage());
                }
            }
        }

        restore_error_handler();
    }
}