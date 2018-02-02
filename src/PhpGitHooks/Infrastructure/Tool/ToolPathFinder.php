<?php

namespace PhpGitHooks\Infrastructure\Tool;

class ToolPathFinder
{
    const COMPOSER_VENDOR_DIR = '/../../../../../../';
    const COMPOSER_INSTALLED_FILE = 'composer/installed.json';

    /** @var array */
    private $tools = array(
        'phpcs' => 'squizlabs/php_codesniffer',
        'php-cs-fixer' => 'friendsofphp/php-cs-fixer',
        'phpmd' => 'phpmd/phpmd',
        'phpunit' => 'phpunit/phpunit',
        'phpunit-randomizer' => 'fiunchinho/phpunit-randomizer',
        'jsonlint' => 'seld/jsonlint',
    );
    /** @var array */
    private $installedPackages = array();

    /**
     * ToolPathFinder constructor
     */
    public function __construct()
    {
        $this->setInstalledPackages();
    }

    /**
     * Set Installed Packages
     *
     * @return void
     */
    protected function setInstalledPackages() {
        $file = file_get_contents(__DIR__.self::COMPOSER_VENDOR_DIR.self::COMPOSER_INSTALLED_FILE);

        $json = json_decode($file);

        $packages = [];

        foreach ($json as $package) {
            $packages[$package->name] = $package;
        }

        $this->installedPackages = $packages;
    }

    /**
     * @param string $tool
     *
     * @return string
     */
    public function find($tool)
    {
        if (isset($this->installedPackages[$this->tools[$tool]])) {
            $package = $this->installedPackages[$this->tools[$tool]];
            foreach ($package->bin as $bin) {
                if (preg_match("#${tool}$#", $bin)) {
                    return dirname(__FILE__).self::COMPOSER_VENDOR_DIR.$package->name.DIRECTORY_SEPARATOR.$bin;
                }
            }
        }

        return 'bin'.DIRECTORY_SEPARATOR.$tool;
    }
}
