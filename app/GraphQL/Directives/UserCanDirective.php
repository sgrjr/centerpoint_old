<?php

namespace App\GraphQL\Directives;

use Closure;
use GraphQL\Language\AST\TypeDefinitionNode;
use GraphQL\Language\AST\TypeExtensionNode;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Nuwave\Lighthouse\Exceptions\AuthenticationException;
use Nuwave\Lighthouse\Schema\AST\ASTHelper;
use Nuwave\Lighthouse\Schema\AST\DocumentAST;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Support\Contracts\TypeExtensionManipulator;
use Nuwave\Lighthouse\Support\Contracts\TypeManipulator;
use Nuwave\Lighthouse\Auth\AuthServiceProvider;

/**
 * @see \Illuminate\Auth\Middleware\Authenticate
 */
class UserCanDirective extends BaseDirective implements FieldMiddleware, TypeManipulator, TypeExtensionManipulator
{
    /**
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }

    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'GRAPHQL'
"""
Run authentication through one or more guards.

This is run per field and may allow unauthenticated
users to still receive partial results.

Used upon an object, it applies to all fields within.
"""
directive @userCan(
  """
  Specify which guards to use, e.g. ["api"].
  When not defined, the default from `lighthouse.php` is used.
  """
  ability: String!
) repeatable on FIELD_DEFINITION | OBJECT
GRAPHQL;
    }

    public function handleField(FieldValue $fieldValue, Closure $next): FieldValue
    {
        $previousResolver = $fieldValue->getResolver();
        $with = [AuthServiceProvider::guard()];

        $fieldValue->setResolver(
            function ($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) use ($with, $previousResolver) {
                $this->authenticate($with);

                return $previousResolver($root, $args, $context, $resolveInfo);
            }
        );

        return $next($fieldValue);
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  array<string|null>  $guards
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate(array $guards): void
    {
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check() && $this->auth->guard($guard)->user()->can($this->directiveArgValue('ability'))) {
                // @phpstan-ignore-next-line passing null works fine here
                $this->auth->shouldUse($guard);

                return;
            }
        }

        $this->unauthenticated($guards);
    }

    /**
     * Handle an unauthenticated user.
     *
     * @param  array<string|null>  $guards
     */
    protected function unauthenticated(array $guards): void
    {
        throw new AuthenticationException(
            AuthenticationException::MESSAGE,
            $guards
        );
    }

    public function manipulateTypeDefinition(DocumentAST &$documentAST, TypeDefinitionNode &$typeDefinition): void
    {
        ASTHelper::addDirectiveToFields($this->directiveNode, $typeDefinition);
    }

    public function manipulateTypeExtension(DocumentAST &$documentAST, TypeExtensionNode &$typeExtension): void
    {
        ASTHelper::addDirectiveToFields($this->directiveNode, $typeExtension);
    }
}
