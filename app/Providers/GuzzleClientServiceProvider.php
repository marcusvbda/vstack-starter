<?php

namespace App\Providers;

use App\Http\Models\RequestLog;
use App\Logging\CustomLog;
use App\Logging\GuzzleLog;
use App\Logging\GuzzleLogger;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class GuzzleClientServiceProvider extends ServiceProvider
{
    private $logger;
    private $model;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('GuzzleClient', function ($app, $context = []) {
            $this->context = @$context;
            return function ($type = 'general', $config = []) {
                $this->type = $type;
                $stack = $this->setLoggingHandler();
                return new Client(array_merge($config, ['handler' => $stack]));
            };
        });
    }
    /**
     * Setup Logger
     */
    private function get_logger()
    {
        $logger = \Log::channel("guzzle");

        $logger->pushProcessor(function (&$record) {
            $record["context"] = (array)$record["message"];
            $record["extra"]["folder"] = $this->type;
            return $record;
        });
        $this->logger = with($logger);

        return $this->logger;
    }
    /**
     * Setup Middleware
     */
    private function setGuzzleMiddleware(string $messageFormat)
    {
        $log = Middleware::log(
            $this->get_logger(),
            new MessageFormatter($messageFormat)
        );

        return $log;
    }
    /**
     * Setup Logging Handler Stack
     */
    private function setLoggingHandler()
    {
        $stack = HandlerStack::create();
        $type = $this->type;
        $messageFormat =
            "GuzzleLOG:" . $type . "[%%%]{request}[%%%]{res_body}";
        $stack->unshift(
            $this->setGuzzleMiddleware($messageFormat)
        );
        $stack->push(Middleware::mapResponse(function ($response) {
            rescue(
                function () use ($response) {
                    if (@$this->context["model"]) {
                        $model = $this->context["model"];
                        $type = $this->type . ":" . @$this->context["type"];
                        RequestLog::create([
                            "subjectable_type" => get_class($model),
                            "subjectable_id" => $model->id,
                            "type" => $type,
                            "direction" => "outside",
                            "response_code" => $response->getStatusCode(),
                            "data" => ["payload" => @$this->context["payload"]]
                        ]);
                    }
                }
            );
            return $response;
        }));

        return $stack;
    }
}
