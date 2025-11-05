<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Facades\Kafka;

class KafkaConsume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume messages from Kafka (multi-broker)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Kafka::consumer(['parrep3'])
            ->withHandler(function (ConsumerMessage $message) {

                $data=$message->getBody();

                $key=$message->getKey();

                $timestamp = $message->getTimestamp();
                $time = \Carbon\Carbon::createFromTimestampMs($timestamp)->format('H:i:s');

                $this->info('New message received:');
                $this->line(' Name: '. $data['name']);
                $this->line(' Email: '. $data['email']);
                $this->line(' Key: '. $key);
                $this->line(' Time: '. $time);
                $this->line("----------------------");
            })
            ->build()
            ->consume();
    }    
}