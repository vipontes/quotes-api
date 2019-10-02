<?php

namespace App\v1\Controllers;

abstract class BaseController
{
    /**
     * @brief 
     * @param string $algo The algorithm (md5, sha1, whirlpool, etc)
     * @param string $data The data to encode
     * @param string $salt The salt (This should be the same throughout the system probably)
     * @return string The hashed/salted data
     */
    protected function hash($algo, $data, $salt): string
    {
        $context = hash_init($algo, HASH_HMAC, $salt);
        hash_update($context, $data);
        return hash_final($context);
    }

    /**
     * @brief Verifica se os parâmetros obrigatórios foram passados
     */
    protected function verifyRequiredParameters(array $required_fields, array $request_params): array
    {
        $error_fields = array();

        foreach ($required_fields as $field) {
            if (!isset($request_params[$field])) {
                $error = true;
                $error_fields[] = $field;
            }
        }

        if ($error) {
            return [
                'success' => false,
                'message' => 'O(s) campo(s) [' . implode(', ', $error_fields) . '] é(são) obrigatório(s).',
            ];
        }

        return ['success' => true, 'message' => ''];
    }
}
