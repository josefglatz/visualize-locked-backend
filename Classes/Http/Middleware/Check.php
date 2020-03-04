<?php
declare(strict_types = 1);

namespace JosefGlatz\VisualizeLockedBackend\Http\Middleware;

use JosefGlatz\VisualizeLockedBackend\Controller\CheckController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Check implements MiddlewareInterface
{

    /**
     * Process an incoming server request if route params are applicable.
     *
     * Processes an specific incoming server request in order to produce a response
     * for the locked states.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $pathToRoute = $request->getQueryParams()['route'] ?? $request->getParsedBody()['route'];
        if ($pathToRoute === '/ajax/josefglatz/visualizelockedbackend/check') {
            if ($GLOBALS['BE_USER'] === null) {
                Bootstrap::initializeBackendUser();
                Bootstrap::initializeBackendAuthentication(true);
            }
            if ($this->getBackendUserAuthentication()->user['uid'] === null) {
                // directly return JsonResponse (without valid backend user session)
                return GeneralUtility::makeInstance(CheckController::class)->lockStatus($request);
            }

            // BackendRoute is used if backend user session is active
            $request = $request->withAttribute('routePath', $pathToRoute);
        }
        return $handler->handle($request);
    }

    /**
     * Returns the current BE user.
     *
     * @return BackendUserAuthentication
     */
    protected function getBackendUserAuthentication(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
}
