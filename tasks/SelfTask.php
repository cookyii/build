<?php
/**
 * SelfTask.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\tasks;

/**
 * Class SelfTask
 * @package cookyii\build\tasks
 */
class SelfTask extends AbstractCompositeTask
{

    /**
     * @var string
     */
    public $cwd;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->cwd)) {
            $this->cwd = $this->command->configReader->basePath;
        }
    }

    /**
     * @inheritdoc
     */
    public function tasks()
    {
        return [
            'default' => [
                '.description' => 'Show map of subtasks',
                '.task' => [
                    'class' => 'cookyii\build\tasks\MapTask',
                    'task' => $this,
                ],
            ],

            'update' => [
                '.description' => 'Self update `cookyii/build` package',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CallableTask',
                    'handler' => function () {
                        $source_url = 'http://cookyii.com/b/build.phar';
                        $checksum_url = 'http://cookyii.com/b/checksum';
                        $build_phar = $this->cwd . '/build.phar';

                        try {
                            $checksum = file_get_contents($checksum_url);
                            if ($checksum !== sha1_file($build_phar)) {
                                $result = copy($source_url, $build_phar);

                                if ($result) {
                                    $this->log('<task-result> COPY </task-result> `build.phar` updated to actual version.');
                                } else {
                                    $this->log('<task-error> ERR </task-error> Error updating `build.phar`');
                                }
                            } else {
                                $result = true;

                                if ($this->output->isVerbose()) {
                                    $this->log('<task-result>  OK  </task-result> `build.phar` already updated.');
                                }
                            }
                        } catch (\Exception $e) {
                            if ($this->output->isVerbose()) {
                                $this->log('<task-error> ERR </task-error> Error updating `build.phar`');
                            }

                            throw $e;
                        }

                        return $result;
                    },
                ],
            ],
        ];
    }
}
