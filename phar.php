#!/usr/bin/env php
<?php
/**
 * phar.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

$pharFile = 'build.phar';
$pharPath = __DIR__ . '/dist/' . $pharFile;

if (file_exists($pharFile)) {
    unlink($pharFile);
}

$directories = [
    'applications',
    'commands',
    'components',
    'config',
    'docs',
    'events',
    'examples',
    'exceptions',
    'tasks',
    'vendor',
];

$phar = new Phar($pharPath, 0, $pharFile);
$phar->setSignatureAlgorithm(\Phar::SHA1);
//$phar->setDefaultStub('build', false);
$phar->setStub(getStub($pharFile));
$phar->addFile('build');
$phar->addFile('composer.json');
$phar->addFile('README.md');
$phar->buildFromDirectory('.', '#(' . implode('|', $directories) . ')#');

if (Phar::canCompress(Phar::GZ)) {
    $phar->compressFiles(Phar::GZ);
} elseif (Phar::canCompress(Phar::BZ2)) {
    $phar->compressFiles(Phar::BZ2);
}

file_put_contents(dirname($pharPath) . '/checksum', sha1_file($pharPath));

echo 'dist/build.phar created.' . PHP_EOL;

/**
 * @param string $pharFile
 * @return string
 */
function getStub($pharFile)
{
    $template = <<<'EOF'
#!/usr/bin/env php
<?php
/*
 * This file is part of Composer.
 *
 * (c) Nils Adermann <naderman@naderman.de>
 *     Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view
 * the license that is located at the bottom of this file.
 */
// Avoid APC causing random fatal errors per https://github.com/composer/composer/issues/264
if (extension_loaded('apc') && ini_get('apc.enable_cli') && ini_get('apc.cache_by_default')) {
    if (version_compare(phpversion('apc'), '3.0.12', '>=')) {
        ini_set('apc.cache_by_default', 0);
    } else {
        fwrite(STDERR, 'Warning: APC <= 3.0.12 may cause fatal errors when running composer commands.'.PHP_EOL);
        fwrite(STDERR, 'Update APC, or set apc.enable_cli or apc.cache_by_default to 0 in your php.ini.'.PHP_EOL);
    }
}
Phar::mapPhar('%1$s');

require 'phar://%1$s/build';
__HALT_COMPILER();
EOF;

    return sprintf($template, $pharFile);
}