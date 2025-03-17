<?php

return [
    'env' => getenv('ENV'),
    'errors' => [
        'log_error_details' => (bool) getenv('LOG_ERROR_DETAILS'),
        'log_errors' => (bool) getenv('LOG_ERRORS'),
        'display_error_details' => (bool) getenv('DISPLAY_ERROR_DETAILS'),
    ],
];
