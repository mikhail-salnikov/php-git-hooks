<?php

namespace PhpGitHooks\Infrastructure\Tool;

class ToolPathFinder
{
    /**
     * @param string $tool
     *
     * @return string
     */
    public function find($tool)
    {
        $binToolPath = 'bin' . DIRECTORY_SEPARATOR . $tool;
        if (is_dir('bin')) {
            return $binToolPath;
        }
        return 'vendor' . DIRECTORY_SEPARATOR . $binToolPath;
    }
}
