<?php

namespace App\Http\Requests\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

trait HandleErrorMessage
{
    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $message = $this->getMessage($this);
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(response()->json([
            'errors'  => $this->handleErrors($errors),
            'message' => $message,
            'code'    => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }

    /**
     * @param $thisHandle
     * @return string
     */
    private function getMessage($thisHandle)
    {
        return (method_exists($thisHandle, 'message'))
            ? $thisHandle->container->call([$thisHandle, 'message'])
            : 'Error.';
    }

    /**
     * @param $errors
     * @return array
     */
    private function handleErrors($errors)
    {
        $array = [];
        foreach ($errors as $error) {
            $array[] = $error[0];
        }

        return $array;
    }
}