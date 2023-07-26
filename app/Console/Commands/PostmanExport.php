<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class PostmanExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postman:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export API Routes to Postman Collection';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // get all api routes
        $routes = Route::getRoutes();
        
        // filter routes with middleware api
        $routes = collect($routes)->filter(function ($route) {
            return in_array('api', $route->middleware());
        });

        // create postman collection
        $collection = [
            'info' => [
                'name' => config('app.name'),
                '_postman_id' => config('postman.postman_id', uniqid()),
                'description' => config('app.name') . ' API Documentation',
                'schema' => 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json'
            ],
            'item' => [],
        ];

        // default variables for postman collection
        $collection['variable'] = [
            [
                'key'           => 'base_url',
                'value'         => config('app.url'),
                'description'   => 'Base URL for API',
            ],
            [
                'key'           => 'bearer_token',
                'value'         => '',
                'description'   => 'Bearer Token for Authentication',
            ]
        ];
        // add variables base_url and bearer_token to postman collection
        foreach (config('postman.variables', []) as $variable) {
            // skip if variable is base_url or bearer_token
            if (in_array($variable['key'], ['base_url', 'bearer_token'])) {
                continue;
            }

            $collection['variable'][] = [
                'key' => $variable['key'],
                'value' => $variable['value'],
                'description' => $variable['description'],
            ];
        }

        // add routes to postman collection
        foreach ($routes as $route) {
            // if route has mobile middleware
            $headers = [
                [
                    'key' => 'Accept',
                    'value' => 'application/json',
                ],
                [
                    'key' => 'Content-Type',
                    'value' => 'application/json',
                ],
            ];

            if (in_array('mobile', $route->middleware())) {
                // add bearer token to headers
                $headers[] = [
                    'key'   => 'Authorization',
                    'value' => 'Bearer {{bearer_token}}',
                ];
            }
            $collection['item'][] = [
                'name' => $route->uri,
                'request' => [
                    'url' => '{{base_url}}' . '/' . $route->uri,
                    'method' => $route->methods[0],
                    'header' => $headers,
                ],
            ];
        }

        // save postman collection to file
        file_put_contents(base_path('postman_collection.json'), json_encode($collection, JSON_PRETTY_PRINT));

        // return success message
        $this->info('Postman collection exported successfully.');

        return self::SUCCESS;
    }
}
