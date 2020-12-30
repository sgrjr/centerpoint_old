<?php namespace App\Repository;

use App\WebDetail;
use \App\Helpers\UserTitleData;
use \App\Core\DbfTableTrait;
use App\Helpers\Misc;

use Nuwave\Lighthouse\Schema\Context as GraphQLContext;
use GraphQL\Type\Definition\ResolveInfo;

class InventoryRepository {

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

      //file_put_contents('test', json_encode(\App\Inventory::ask()->setPerPage($args['first'])->get()));
        return \App\Inventory::ask()->setPerPage($args['first'])->get();
    }

}