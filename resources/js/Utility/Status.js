const STATUS = {
    '200': 'OK',
    '201': 'RESOURCE_CREATED',
    '202': 'ACTION_ACCEPTED',
    '204': 'NO_CONTENT',
    '401': 'FAILED_AUTHENTICATION',
    '422': 'FAILED_VALIDATION',
    '404': 'NOT_FOUND',
    '409': 'DUPLICATE_RESOURCE',
    '400': 'BAD_REQUEST',
    '405': 'METHOD_NOT_ALLOW',
    '413': 'PERMISSION_DENIED',
    '500': 'SERVER_ERROR',
    '199': 'WARNING'
}

export default STATUS;
