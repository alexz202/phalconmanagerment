<?php
namespace Zejicrm\Modules\Backend\Middleware;

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;


class NotFoundMiddleware implements MiddlewareInterface
{
    /**
     * The route has not been found
     *
     * @returns bool
     */
    public function beforeNotFound(Event $event,Micro $application)
    {
        $application->response->setStatusCode(404, "Not Found")->sendHeaders();
        $application->response->setContent("Not Found");
        $application->response->send();
        return false;
    }

    /**
     * Calls the middleware
     *
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        return true;
    }
}