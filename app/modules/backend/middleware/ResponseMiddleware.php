<?php
namespace Zejicrm\Modules\Backend\Middleware;

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;


/**
 * ResponseMiddleware
 *
 * Manipulates the response
 */
class ResponseMiddleware implements MiddlewareInterface
{
    /**
     * Before anything happens
     *
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        $returnArr=$application->getReturnedValue();
        //TODO SIGN

        $payload = [
            'code'    => intval($returnArr[0]),
            'message' => $returnArr[1],
            'data' => $returnArr[2],
        ];

        $application->response->setJsonContent($payload);
        $application->response->send();

        return true;
    }
}