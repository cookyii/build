<?php
/**
 * FileSet.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\components;

/**
 * Class FileSet
 * @package cookyii\build\components
 */
class FileSet extends Component
{

    /**
     * @var string
     */
    public $dir;

    /**
     * @var array
     */
    public $exclude = [];

    /**
     * @var bool
     */
    public $followLinks = false;

    /**
     * @var bool
     */
    public $ignoreDotFiles = false;

    /**
     * @var bool
     */
    public $skipIfNotExists = true;

    /**
     * @return \Symfony\Component\Finder\SplFileInfo[]
     */
    public function getListIterator()
    {
        if (!file_exists($this->dir) || !is_dir($this->dir)) {
            if (false === $this->skipIfNotExists) {
                throw new \InvalidArgumentException(sprintf('The "%s" directory does not exist.', $this->dir));
            } else {
                return [];
            }
        }

        $Finder = (new \Symfony\Component\Finder\Finder())
            ->ignoreDotFiles($this->ignoreDotFiles)
            ->in($this->dir)
            ->exclude($this->exclude)
            ->sortByName();

        if ($this->followLinks) {
            $Finder->followLinks();
        }

        if (!empty($this->exclude)) {
            $Finder->filter(function (\SplFileInfo $File) {
                foreach ($this->exclude as $mask) {
                    $pattern = '^' . str_replace(['.', '*'], ['\.', '.*'], $mask) . '^is';
                    if (preg_match($pattern, $File->getPathname())) {
                        return false;
                    }
                }

                return true;
            });
        }

        return $Finder;
    }
}
