<?php
declare(strict_types=1);

use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\Expression\ForClasses\Extend;
use Arkitect\Expression\ForClasses\HaveNameMatching;
use Arkitect\Expression\ForClasses\NotDependsOnTheseNamespaces;
use Arkitect\Expression\ForClasses\NotHaveDependencyOutsideNamespace;
use Arkitect\Expression\ForClasses\NotHaveNameMatching;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Rules\Rule;

return static function (Config $config): void {
    $mvcClassSet = ClassSet::fromDir(__DIR__.'/../src');

    $rules = [];

    // Dependency rules
    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('domain'))
        ->should(new NotHaveDependencyOutsideNamespace('domain'))
        ->because("The domain layer can't depend on anything");

    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('application'))
        ->should(new NotDependsOnTheseNamespaces('infrastructure'))
        ->because("The application layer cannot depend on the infrastructure layer");

    // Classes in correct layers
    $rules[] = Rule::allClasses()
        ->that(new HaveNameMatching("*Handler*"))
        ->should(new ResideInOneOfTheseNamespaces('application'))
        ->because("Our command handler should live in application layer");
    $rules[] = Rule::allClasses()
        ->that(new HaveNameMatching("*Command*"))
        ->should(new ResideInOneOfTheseNamespaces('application'))
        ->because("Our commands should live in application layer");
    $rules[] = Rule::allClasses()
        ->that(new HaveNameMatching("*Controller*"))
        ->should(new ResideInOneOfTheseNamespaces('infrastructure'))
        ->because("Our controller should live in infrastructure layer");

    // Inheritance rules
    $rules[] = Rule::allClasses()
        ->that(new HaveNameMatching("*Controller*"))
        ->andThat(new NotHaveNameMatching("baseController"))
        ->should(new Extend("infrastructure\baseController"))
        ->because("All controllers should extend base controller");

    $config
        ->add($mvcClassSet, ...$rules);
};