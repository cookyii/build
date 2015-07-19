<?php
/**
 * ChownTask.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\tasks;

/**
 * Class ChownTask
 * @package cookyii\build\tasks
 */
class ChownTask extends AbstractTask
{

    /** @var string|null */
    public $filename;

    /** @var array */
    public $fileSets = [];

    /** @var string */
    public $user;

    /** @var string */
    public $group;

    /** @var bool */
    public $skipOnError = true;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (empty($this->user)) {
            throw new \InvalidArgumentException('Empty user name.');
        }

        $this->group = empty($this->group)
            ? $this->user
            : $this->group;

        if (!empty($this->filename)) {
            $this->filename = $this->getAbsolutePath($this->filename);

            $this->chown($this->filename, $this->user, $this->group);
        }

        if (!empty($this->fileSets)) {
            foreach ($this->fileSets as $fileSet) {
                $fileSet = is_string($fileSet)
                    ? ['dir' => $fileSet]
                    : $fileSet;

                if (mb_substr($fileSet['dir'], 0, 1) !== '/') {
                    $fileSet['dir'] = $this->command->configReader->basePath . DIRECTORY_SEPARATOR . $fileSet['dir'];
                }

                if (!file_exists($fileSet['dir']) || !is_dir($fileSet['dir'])) {
                    continue;
                }

                $FileSet = new \cookyii\build\components\FileSet();
                $FileSet->configure($fileSet);

                foreach ($FileSet->getListIterator() as $File) {
                    $this->chown($File->getPathname(), $this->user, $this->group);
                }

                $this->chown($fileSet['dir'], $this->user, $this->group);
            }
        }

        return true;
    }

    /**
     * @param string $filename
     * @param string $user
     * @param string $group
     * @throws \Exception
     */
    private function chown($filename, $user, $group)
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline, array $errcontext) {
            // error was suppressed with the @-operator
            if (0 === error_reporting()) {
                return false;
            }

            throw new \Exception($errstr, $errno);
        });

        if ($this->output->isVerbose()) {
            $this->log(sprintf('<task-result> OWN </task-result> %s:%s => %s', $user, $group, $filename));
        }

        try {
            chown($filename, $user);
            chgrp($filename, $group);
        } catch (\Exception$e) {
            if ($e->getMessage() === 'chown(): Operation not permitted') {
                if ($this->output->getVerbosity() === \Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL) {
                    $this->log(sprintf('<task-error> ERR </task-error> %s:%s => %s', $user, $group, $filename));
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