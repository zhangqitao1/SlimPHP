<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/9/1
 * Time: 15:00
 */

namespace Slim\Utils;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;

class Log extends StreamHandler
{

    public function __construct($path = null, $namePattern = "%date%/%script%.log", $level = Logger::DEBUG)
    {

        if (!$path) {
            $path = sys_get_temp_dir();
        }

        $translation_table = [
            "%date%"   => date('Ymd'),
            "%hour%"   => date('H'),
            "%script%" => basename($_SERVER['SCRIPT_FILENAME'], ".php"),
            "%pid%"    => getmypid(),
        ];

        $log_file = strtr($namePattern, $translation_table);

        $path = $path . "/" . $log_file;

        parent::__construct($path, $level);

        $datetime_format = "Ymd-His P";
        $output_format   =
            "[%channel%] %datetime% | %level_name% | %message%  %context% %extra%\n"; // %context% %extra%
        $line_formatter  = new LineFormatter(
            $output_format,
            $datetime_format,
            true,
            true
        );
        $line_formatter->includeStacktraces();

        $this->setFormatter($line_formatter);
    }
    public function install()
    {

        if ($this instanceof HandlerInterface) {
            
            MLogging::addHandler($this, static::class);

            return $this;
        }
        else {
            throw new \LogicException("Installed logging handler is not of correct type! class = " . static::class);
        }
    }
}
