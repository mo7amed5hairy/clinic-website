<?php

namespace App\Core\Helpers;

use GraphQL\Error\UserError;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class GraphQLValidator
{
    public static function validate(string $formRequestClass, array $args): array
    {
        /** @var FormRequest $request */
        $request = app($formRequestClass);

        // authorize()
        if (method_exists($request, 'authorize') && !$request->authorize()) {
            throw new UserError(__('validation.unauthorized'));
        }

        $validator = Validator::make(
            $args,
            $request->rules(),
            method_exists($request, 'messages') ? $request->messages() : [],
            method_exists($request, 'attributes') ? $request->attributes() : []
        );

        if ($validator->fails()) {
            throw new UserError(
                collect($validator->errors()->all())->join("\n")
            );
        }

        return $validator->validated();
    }
}
