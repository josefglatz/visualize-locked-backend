<?php

return [
    'visualize_locked_backend_check' => [
        'path' => '/josefglatz/visualizelockedbackend/check',
        'target' => \JosefGlatz\VisualizeLockedBackend\Controller\CheckController::class . '::lockStatus',
        'parameters' => [
        ]
    ],
];
