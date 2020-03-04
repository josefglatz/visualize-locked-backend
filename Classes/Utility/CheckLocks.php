<?php
declare(strict_types = 1);

namespace JosefGlatz\VisualizeLockedBackend\Utility;

use JosefGlatz\VisualizeLockedBackend\Backend\DeploymentLockedException;
use TYPO3\CMS\Backend\Exception\BackendLockedException;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class CheckLocks
{
    public static function checkForLockedBackend()
    {
        if ($GLOBALS['TYPO3_CONF_VARS']['BE']['adminOnly'] < 0) {
            throw new BackendLockedException('TYPO3 Backend locked: Browser backend is locked for maintenance. [BE][adminOnly] is set to "' . (int)$GLOBALS['TYPO3_CONF_VARS']['BE']['adminOnly'] . '".',
                1583244811);
        }
    }

    public static function checkForLockedEditorBackend()
    {
        if ($GLOBALS['TYPO3_CONF_VARS']['BE']['adminOnly'] > 0) {
            throw new BackendLockedException('TYPO3 Backend locked for editors: Browser backend is locked for maintenance. [BE][adminOnly] is set to "' . (int)$GLOBALS['TYPO3_CONF_VARS']['BE']['adminOnly'] . '".',
                1583299131);
        }
    }

    public static function checkForLockedBackendFile()
    {
        if (@is_file(Environment::getLegacyConfigPath() . '/LOCK_BACKEND')) {
            $fileContent = fgets(fopen(Environment::getLegacyConfigPath() . '/LOCK_BACKEND', 'r'));
            $redirectUriDescription = '';
            if ($fileContent) {
                $redirectUriDescription = ' The redirect uri is set to "' .
                    str_replace(PHP_EOL, '', $fileContent) .
                    '".';
            }
            throw new BackendLockedException('TYPO3 Backend locked: Browser backend is locked for maintenance.' . $redirectUriDescription . ' Remove lock by removing the file typo3conf/LOCK_BACKEND or use CLI-scripts.',
                1583244989);
        }
    }

    public static function checkForLockedSurfDeployment()
    {
        if (@is_file(Environment::getProjectPath() . '/../../.surf/deploy.lock')) {
            throw new DeploymentLockedException('A Deployment is currently in progress or ended unexpectedly if this message doesn\'t go away in a couple of minutes',
                1583257127);
        }
    }
}
