<?php

namespace MolliePrefix;

class ProjectWithXsdExtension extends \MolliePrefix\ProjectExtension
{
    public function getXsdValidationBasePath()
    {
        return __DIR__ . '/schema';
    }
    public function getNamespace()
    {
        return 'http://www.example.com/schema/projectwithxsd';
    }
    public function getAlias()
    {
        return 'projectwithxsd';
    }
}
\class_alias('MolliePrefix\\ProjectWithXsdExtension', 'MolliePrefix\\ProjectWithXsdExtension', \false);
