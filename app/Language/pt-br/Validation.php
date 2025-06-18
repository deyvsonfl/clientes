<?php

return [
    // Regras padrão
    'required'      => 'O campo {field} é obrigatório.',
    'matches'       => 'O campo {field} não corresponde ao campo {param}.',
    'min_length'    => 'O campo {field} deve ter no mínimo {param} caracteres.',
    'max_length'    => 'O campo {field} deve ter no máximo {param} caracteres.',
    'exact_length'  => 'O campo {field} deve ter exatamente {param} caracteres.',
    'in_list'       => 'O campo {field} deve ser um dos seguintes: {param}.',
    'alpha'         => 'O campo {field} deve conter apenas letras.',
    'alpha_numeric' => 'O campo {field} deve conter apenas letras e números.',
    'alpha_dash'    => 'O campo {field} deve conter apenas letras, números, sublinhados e traços.',
    'numeric'       => 'O campo {field} deve conter apenas números.',
    'integer'       => 'O campo {field} deve conter um número inteiro.',
    'decimal'       => 'O campo {field} deve conter um número decimal.',
    'is_natural'    => 'O campo {field} deve conter apenas números positivos.',
    'is_natural_no_zero' => 'O campo {field} deve conter um número maior que zero.',
    'valid_email'   => 'O campo {field} deve conter um e-mail válido.',
    'valid_url'     => 'O campo {field} deve conter uma URL válida.',
    'valid_ip'      => 'O campo {field} deve conter um IP válido.',
    'regex_match'   => 'O campo {field} não está no formato correto.',

    // Personalizados
    'valid_cep'   => 'O campo {field} deve estar no formato 99999-999.',
    'valid_phone' => 'O campo {field} deve estar no formato (99) 99999-9999.',
];
