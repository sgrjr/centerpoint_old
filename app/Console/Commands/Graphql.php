<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Request;

class Graphql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'graphql:query {query} {variables?} {--token=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command line way of accessing data via graphql';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // must escape $ and " USE SINGLE QUOTES AROUND $queary and $variables

        //fragment TitleFragment on TitlePaginator {            paginatorInfo {             perPage             total             count             currentPage             firstItem             lastItem             hasMorePages           }           data{             INDEX             ISBN             TITLE             INVNATURE             FLATPRICE             LISTPRICE             isClearance             PUBDATE             coverArt             AUTHORKEY             AUTHOR             STATUS           }       }       query ($first:Int!){         cp: cpTitles (first:$first){           ...TitleFragment         }         trade: tradeTitles(first:$first){           ...TitleFragment         }         advanced: advancedTitles(first:$first) {           ...TitleFragment         }       }

        //variables
        //{"first":24}
        $query = $this->argument('query')? $this->argument('query'):'{}';
        $variables = $this->argument('variables')? $this->argument('variables'):'{}';
        $query = '{"query":"'.$query.'","variables":'.$variables.'}';

        $uri = "/graphql";
        $method = 'POST';
        $parameters = [];
        $cookies = [];
        $files = [];
        $server = [];
        $content = $query;

        $request = Request::create($uri, $method, $parameters, $cookies, $files, $server, $content);
        $request->setMethod('POST');;
        $request->headers->set('Accept','application/json');
        $request->headers->set('Content-Type','application/json');
        $request->headers->set('Authorization', 'Bearer '. $this->options('token')['token'] );
        $response = app()['Illuminate\Contracts\Http\Kernel']->handle($request);
        $responseBody = json_decode($response->getContent(), true);
        $this->info($response);

    }
}