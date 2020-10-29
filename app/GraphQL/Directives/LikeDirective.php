<?php

namespace App\GraphQL\Directives;

use Nuwave\Lighthouse\Schema\Directives\BaseDirective;

use Nuwave\Lighthouse\Support\Contracts\ArgBuilderDirective;
use Nuwave\Lighthouse\Support\Contracts\DefinedDirective;

class LikeDirective extends BaseDirective implements ArgBuilderDirective, DefinedDirective
{
    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'SDL'
directive @like(  
  """
  Specify the database column to compare. 
  Only required if database column has a different name than the attribute in your schema.
  """
  key: String
) on ARGUMENT_DEFINITION | INPUT_FIELD_DEFINITION
SDL;
    }

    /**
     * Apply a "WHERE = $value" clause.
     *
     * @param  \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder  $builder
     * @param  mixed  $value
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function handleBuilder($builder, $value)
    {
        return $builder->where(
            $this->directiveArgValue('key', $this->nodeName()),
            'like',
            '%'.$value.'%'
        );
    }

}
