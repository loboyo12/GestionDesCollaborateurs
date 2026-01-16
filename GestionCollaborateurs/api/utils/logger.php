<?php
class Logger {
    public static function log($message) {
        file_put_contents(
            __DIR__ . '/../log/app.log',
            date('Y-m-d H:i:s') . ' ' . $message . PHP_EOL,
            FILE_APPEND
        );
    }
}