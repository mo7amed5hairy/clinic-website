<?php

namespace App\GraphQL\Scalars;

use GraphQL\Type\Definition\ScalarType;
use GraphQL\Language\AST\Node;

class Json extends ScalarType
{
    public string $name = 'JSON';

    public function serialize($value)
    {
        return $value;
    }

    public function parseValue($value)
    {
        return $value;
    }

    public function parseLiteral(Node $valueNode, ?array $variables = null)
    {
        return $valueNode->value ?? null;
    }
}
