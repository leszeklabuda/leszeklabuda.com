<?php

// override core en language system validation or define your own en language validation message
return [
    // My Rules - comparison is case insensitive
    'ci_not_equals'         => 'The {field} field cannot be: {param}; case insensitive.',
    'ci_in_list'            => 'The {field} field must be one of: {param}; case insensitive.',
    'ci_not_in_list'        => 'The {field} field must not be one of: {param}; case insensitive.',
    'recaptcha'             => 'The {field} field is not valid.'
];
