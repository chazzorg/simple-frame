<?php

namespace Chazz\Queue;

use Chazz\Driver\Queue\RedisQueue;

final class Queue
{
    /**
     * 驱动实例
     */
    private $instance;

    private $driverMap = [
        'redis' => RedisQueue::class,
    ];

    public function __construct($name = '', $config = [])
    {
        $name = $name ?: config('queue.default');
        $config = $config ?: config('queue.'.$name);
        if ($config && ($class = $this->getDriverClass($config['driver']))) {
            $this->instance = new $class($config);
        }
    }

    /**
     * @param $driver
     * @return mixed|null
     */
    public function getDriverClass($driver)
    {
        return $this->driverMap[$driver] ?? null;
    }

    /**
     * @return array
     */
    public function getDriverMap(): array
    {
        return $this->driverMap;
    }

    public function __call($method, $args)
    {
        if (!$this->instance) {
            throw new \Exception('no driver!');
        }
        return $this->instance->$method(...$args);
    }
}
