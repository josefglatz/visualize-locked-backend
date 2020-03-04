<?php
declare(strict_types = 1);

use JosefGlatz\VisualizeLockedBackend\Http\Middleware\Check;

return call_user_func(static function() {
    $middlewares = [];

    $middlewares['backend']['josefglatz/visualize-locked-backend/check'] = [
        'target' => Check::class,
        'before' => [
            'typo3/cms-backend/locked-backend',
        ],
        'after' => [
            'typo3/cms-core/normalized-params-attribute',
        ],
    ];

    return $middlewares;
});
