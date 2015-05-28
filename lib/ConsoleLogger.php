<?php

namespace Aerys;

use League\CLImate\CLImate;
use Psr\Log\{
    LogLevel,
    LoggerInterface as Logger
};

class ConsoleLogger implements Logger {
    private $climate;
    public function __construct(CLImate $climate) {
        $this->climate = $climate;
    }
    public function emergency($message, array $context = []) {
        $this->log(LogLevel::EMERGENCY, $message);
    }
    public function alert($message, array $context = []) {
        $this->log(LogLevel::ALERT, $message);
    }
    public function critical($message, array $context = []) {
        $this->log(LogLevel::CRITICAL, $message);
    }
    public function error($message, array $context = []) {
        $this->log(LogLevel::ERROR, $message);
    }
    public function warning($message, array $context = []) {
        $this->log(LogLevel::WARNING, $message);
    }
    public function notice($message, array $context = []) {
        $this->log(LogLevel::NOTICE, $message);
    }
    public function info($message, array $context = []) {
        $this->log(LogLevel::INFO, $message);
    }
    public function debug($message, array $context = []) {
        $this->climate->out(LogLevel::DEBUG, $message);
    }
    public function log($level, $message, array $context = []) {
        $time = @date("H:i:s", $context["time"] ?? time());
        $level = $this->generateColoredLevel($level);
        $message = "[{$time}] <bold>{$level}</bold> {$message}";
        $this->climate->out($message);
    }
    private function generateColoredLevel($level) {
        switch ($level) {
            case LogLevel::EMERGENCY:
            case LogLevel::ALERT:
            case LogLevel::CRITICAL:
            case LogLevel::ERROR:
                return "<red>{$level}</red>";
            case LogLevel::WARNING:
                return "<yellow>{$level}</yellow>";
            case LogLevel::NOTICE:
                return "<green>{$level}</green>";
            case LogLevel::INFO:
                return "<magenta>{$level}</magenta>";
            case LogLevel::DEBUG:
                return "<cyan>{$level}</cyan>";
            default:
                $this->climate->error("Unexpected log level ({$level})");
                return "unknown";
        }
    }
}