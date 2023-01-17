<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSemicolonToColonFixer;

return static function (ContainerConfigurator $containerConfigurator): void {
    // A. full sets
    $containerConfigurator->import(SetList::PSR_12);
    $containerConfigurator->import(SetList::CLEAN_CODE);
    $containerConfigurator->import(SetList::SYMFONY);

    // B. standalone rule
    $services = $containerConfigurator->services();
    $services->set(PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer::class);

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/apps/Backend/src',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    /** Skip rules for enum classes (incorrect case change)
     * case TARGET = 'target';
     * case TARGET = 'target':
     */
    $parameters->set(Option::SKIP, [
        __DIR__ . '/src/Application/Enum/*',
        SwitchCaseSemicolonToColonFixer::class,
    ]);
};
