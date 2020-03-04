<?php
declare(strict_types = 1);
namespace JosefGlatz\VisualizeLockedBackend\Controller;

use JosefGlatz\VisualizeLockedBackend\Backend\DeploymentLockedException;
use JosefGlatz\VisualizeLockedBackend\Utility\CheckLocks;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Exception\BackendLockedException;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Class CheckController
 * @param ServerRequestInterface $request
 * @throws \RuntimeException for incomplete or invalid arguments
 * @return ResponseInterface
 */
class CheckController
{
    /**
     * @var array
     */
    protected $lockResponse = [];

    public function lockStatus(ServerRequestInterface $request): ResponseInterface
    {

        //
        $result = [];
        try {
            $result['status'] = false;
            CheckLocks::checkForLockedBackend();
        } catch (BackendLockedException $e) {
            $result['message'] = $e->getMessage();
            $result['code'] = $e->getCode();
            $result['status'] = true;
        }
        $this->lockResponse['checkLockedBackend'] = $result;

        $result = [];
        try {
            $result['status'] = false;
            CheckLocks::checkForLockedEditorBackend();
        } catch (BackendLockedException $e) {
            $result['message'] = $e->getMessage();
            $result['code'] = $e->getCode();
            $result['status'] = true;
        }
        $this->lockResponse['checkLockedBackendForEditors'] = $result;

        $result = [];
        try {
            $result['status'] = false;
            CheckLocks::checkForLockedBackendFile();
        } catch (BackendLockedException $e) {
            $result['message'] = $e->getMessage();
            $result['code'] = $e->getCode();
            $result['status'] = true;
        }
        $this->lockResponse['checkLockedBackendFile'] = $result;

        $result = [];
        try {
            $result['status'] = false;
            CheckLocks::checkForLockedSurfDeployment();
        } catch (DeploymentLockedException $e) {
            $result['message'] = $e->getMessage();
            $result['code'] = $e->getCode();
            $result['status'] = true;
        }
        $this->lockResponse['checkLockedSurfDeployment'] = $result;

        return (new JsonResponse())->setPayload($this->getLockResponse());
    }

    /**
     * @return array
     */
    public function getLockResponse(): array
    {
        return $this->lockResponse;
    }
}
