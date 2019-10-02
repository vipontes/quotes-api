<?php

namespace App\v1\Controllers;

abstract class BaseController
{

    /**
     * @brief Verifica se os parâmetros obrigatórios foram passados
     */
    protected function verifyRequiredParameters(array $required_fields, array $request_params): array
    {
        $error_fields = array();

        foreach ($required_fields as $field) {
            if (!isset($request_params[$field]) /* || strlen(trim($request_params[$field])) <= 0 */) {
                $error = true;
                $error_fields[] = $field;
            }
        }
        if ($error) {
            // Required field(s) are missing or empty
            return [
                'success' => false,
                'message' => 'O(s) campo(s) [' . implode(', ', $error_fields) . '] é(são) obrigatório(s).',
            ];
        }

        // return appropriate response when successful?
        return ['success' => true, 'message' => ''];
    }
}
