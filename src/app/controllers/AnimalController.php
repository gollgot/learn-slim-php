<?php
namespace App\controllers;



use Elasticsearch\ClientBuilder;
use Slim\Http\Request;
use Slim\Http\Response;

use Symfony\Component\Yaml\Parser;

class AnimalController extends Controller {

    private $elasticsearch_config;

    function __construct($container){
        parent::__construct($container);

        // This is a one pager, we will use a lot of credentials, so we load them from a config yaml file this way we can access them easily in all our function
        $yaml = new Parser();
        $parameters = $yaml->parse(file_get_contents("../app/config/parameters.yml"));
        $this->elasticsearch_config = $parameters["parameters"]["elasticsearch"];
    }

    /**
     * Display the animal page
     * @param Request $request
     * @param Response $response
     */
    public function ActionIndex(Request $request, Response $response){
        // Get the elastic config and connect to it
        $hosts = [$this->elasticsearch_config["host"].":".$this->elasticsearch_config["port"]];
        $client = ClientBuilder::create()
            ->setHosts($hosts)      // Set the hosts
            ->build();              // Build the client object

        // Search parameters
        $params = [
            'index' => 'zoo',
            'type' => 'animals',
            'body' => [
                'query' => [
                    'match_all' => new \stdClass()
                ],
            ],
        ];
        $elasticResponse = $client->search($params);

        // Render the view
        $this->render($response, "animals/index.twig", [
            "hits" => $elasticResponse["hits"],
        ]);
    }

}