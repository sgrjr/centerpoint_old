<?php

namespace App\GraphQL\Directives;

use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Support\Contracts\ArgBuilderDirective;
use Nuwave\Lighthouse\Support\Contracts\ArgDirectiveForArray;

class MostlyLikeDirective extends BaseDirective implements ArgDirectiveForArray, ArgBuilderDirective
{

    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'GRAPHQL'
directive @mostlyLike (  
  """
  Specify the database column to compare. 
  Only required if database column has a different name than the attribute in your schema.
  """
  key: String
) on ARGUMENT_DEFINITION | INPUT_FIELD_DEFINITION
GRAPHQL;
    }

    /**
     * Add additional constraints to the builder based on the given argument value.
     *
     * @param  \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder  $builder
     * @param  mixed  $value
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function handleBuilder($builder, $value)
    {
        $value = str_replace(",","",$value);
        $value = str_replace(" ", "+", $value);
        $value = str_replace("%20","+", $value);
    	$val = explode("+",$value);

    	if(count($val) === 1){
    		return $builder->where(
	            $this->directiveArgValue('key', $this->nodeName()),
	            'like',
	            $this->pickLikePrefix($val[0]).substr($val[0],0,5).'%'
	        );
    	}else if(count($val) === 2){
    		return $builder->where(
	            $this->directiveArgValue('key', $this->nodeName()),
	            'like',
	            $this->pickLikePrefix($val[0]).substr($val[0],0,4).'%'
	        )->where(
	            $this->directiveArgValue('key', $this->nodeName()),
	            'like',
	            $this->pickLikePrefix($val[1]).substr($val[1],0,4).'%'
	        );
    	}else if(count($val) === 3){
            return $builder->where(
                $this->directiveArgValue('key', $this->nodeName()),
                'like',
                $this->pickLikePrefix($val[0]).substr($val[0],0,4).'%'
            )->orWhere(
                $this->directiveArgValue('key', $this->nodeName()),
                'like',
                $this->pickLikePrefix($val[1]).substr($val[1],0,4).'%'
            )->orWhere(
                $this->directiveArgValue('key', $this->nodeName()),
                'like',
                $this->pickLikePrefix($val[2]).substr($val[2],0,4).'%'
            );
        }else if(count($val) === 4){
            return $builder->where(
                $this->directiveArgValue('key', $this->nodeName()),
                'like',
                $this->pickLikePrefix($val[0]).substr($val[0],0,4).'%'
            )->orWhere(
                $this->directiveArgValue('key', $this->nodeName()),
                'like',
                $this->pickLikePrefix($val[1]).substr($val[1],0,4).'%'
            )->orWhere(
                $this->directiveArgValue('key', $this->nodeName()),
                'like',
                $this->pickLikePrefix($val[2]).substr($val[2],0,4).'%'
            )->orWhere(
                $this->directiveArgValue('key', $this->nodeName()),
                'like',
                $this->pickLikePrefix($val[3]).substr($val[3],0,4).'%'
            );
        }

    }

    public function pickLikePrefix($value){
    	if(strtolower(substr($value,0,3)) === "fic"){
    		$searchPrefix = '';
    	}else{
    		$searchPrefix = '%';
    	}
    	return $searchPrefix;
    }
}
