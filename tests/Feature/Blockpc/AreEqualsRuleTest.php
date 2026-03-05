<?php

use Blockpc\App\Rules\AreEqualsRule;
use Illuminate\Support\Facades\Validator;

uses()->group('blockpc', 'rules');

it('la regla se cumple cuando los valores son iguales', function () {
    $validator = Validator::make(
        ['name' => 'test'],
        ['name' => [new AreEqualsRule('test')]],
    );

    expect($validator->fails())->toBeFalse();
});

it('la regla falla cuando los valores son diferentes', function () {
    $validator = Validator::make(
        ['name' => 'other'],
        ['name' => [new AreEqualsRule('test')]],
    );

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first('name'))->toBe('The name is not equal to value.');
});

it('la regla falla cuando el texto de comparacion es null', function () {
    $validator = Validator::make(
        ['name' => 'test'],
        ['name' => [new AreEqualsRule(null)]],
    );

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first('name'))->toBe('The text to compare is null.');
});
