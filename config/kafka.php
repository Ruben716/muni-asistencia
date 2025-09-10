<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Kafka Brokers
    |--------------------------------------------------------------------------
    */
    'brokers' => env('KAFKA_BROKERS', 'localhost:9092'),

    /*
    |--------------------------------------------------------------------------
    | Kafka Consumers Config
    |--------------------------------------------------------------------------
    */
    'consumer_group_id' => env('KAFKA_CONSUMER_GROUP_ID', 'default-consumer-group'),

    'sleep_on_error' => 5,

    'auto_commit' => false,

    'auto_commit_interval_ms' => 100,

    'consumer_timeout_ms' => 1000,

    /*
    |--------------------------------------------------------------------------
    | Security
    |--------------------------------------------------------------------------
    */
    'security_protocol' => env('KAFKA_SECURITY_PROTOCOL', 'PLAINTEXT'),
    'sasl_mechanisms' => env('KAFKA_SASL_MECHANISMS'),
    'sasl_username' => env('KAFKA_SASL_USERNAME'),
    'sasl_password' => env('KAFKA_SASL_PASSWORD'),

];
