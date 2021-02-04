<?php

namespace App\GraphQL\Mutations;

use Nuwave\Lighthouse\Schema\Context;
use GraphQL\Type\Definition\ResolveInfo;

class UpdateCartTitle
{
    
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */

    public function __invoke($rootValue, array $args, Context $context, ResolveInfo $resolveInfo)
    {
    	$user = request()->user();

    	  $d = \App\Webdetail::
    	  	where("REMOTEADDR",$args["input"]["REMOTEADDR"])
            ->where("PROD_NO", $args["input"]['ISBN'])
            ->where("KEY",$user->KEY)
            ->first();
        
        $d->REQUESTED = $args["input"]['REQUESTED'];
        $d->dbfSave();
        $d->save();

        return $user;
    }
}
