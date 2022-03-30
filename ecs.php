<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Basic\PsrAutoloadingFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\ClassNotation\ProtectedToPrivateFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUselessElseFixer;
use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoUnreachableDefaultArgumentValueFixer;
use PhpCsFixer\Fixer\FunctionNotation\StaticLambdaFixer;
use PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAlignFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocToCommentFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMethodCasingFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitSetUpTearDownVisibilityFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestAnnotationFixer;
use PhpCsFixer\Fixer\ReturnNotation\NoUselessReturnFixer;
use PhpCsFixer\Fixer\StringNotation\HeredocToNowdocFixer;
use PhpCsFixer\Fixer\Whitespace\ArrayIndentationFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(SetList::PSR_12);
    $containerConfigurator->import(SetList::CLEAN_CODE);
    $containerConfigurator->import(SetList::SYMFONY);
    $containerConfigurator->import(SetList::SYMFONY_RISKY);
    $containerConfigurator->import(SetList::STRICT);

    $services = $containerConfigurator->services();
    $services->set(PsrAutoloadingFixer::class);
    $services->set(GlobalNamespaceImportFixer::class)
        ->call('configure', [['import_classes' => false, 'import_constants' => false, 'import_functions' => false]]);
    $services->set(OrderedClassElementsFixer::class);
    $services->set(ProtectedToPrivateFixer::class);
    $services->set(NoUselessElseFixer::class);
    $services->set(NativeFunctionInvocationFixer::class)
        ->call('configure', [['include' => ['@compiler_optimized']]]);
    $services->set(NoUnreachableDefaultArgumentValueFixer::class);
    $services->set(StaticLambdaFixer::class);
    $services->set(PhpdocAlignFixer::class)
        ->call('configure', [['align' => 'left']]);
    $services->set(PhpUnitMethodCasingFixer::class)
        ->call('configure', [['case' => 'snake_case']]);
    $services->set(PhpUnitSetUpTearDownVisibilityFixer::class);
    $services->set(PhpUnitTestAnnotationFixer::class)
        ->call('configure', [['style' => 'annotation']]);
    $services->set(NoUselessReturnFixer::class);
    $services->set(HeredocToNowdocFixer::class);
    $services->set(ArrayIndentationFixer::class);

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::SKIP, [PhpdocToCommentFixer::class => null]);
    $parameters->set(Option::PATHS, [__FILE__, __DIR__.'/app', __DIR__.'/tests']);
};
