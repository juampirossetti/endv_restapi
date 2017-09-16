<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Optimus\Heimdal\Formatters\BaseFormatter;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NotFoundHttpExceptionFormatter extends BaseFormatter
{
    public function format(JsonResponse $response, Exception $e, array $reporterResponses)
    {
        $response->setStatusCode(404);
        $data = $response->getData(true);

        if ($this->debug) {
            $data = array_merge($data, [
                'code'   => $e->getCode(),
                'message'   => $e->getMessage(),
                'exception' => (string) $e,
                'line'   => $e->getLine(),
                'file'   => $e->getFile()
            ]);
        } else {
            if( $e instanceof ModelNotFoundException){
                $data['message'] = [
                    'message' => 'The model was not found.'
                ];
            } else {
                $data['message'] = [
                    'message' => 'The resource was not found.'
                ];
            }
        }

        $response->setData($data);
    }
}