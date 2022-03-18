<?php

namespace Chazz\Driver\Queue;

use Chazz\Interfaces\QueueInterface;

/**
 * Class BaseQueue
 * @package Inhere\Queue\Driver
 */
abstract class BaseQueue implements QueueInterface
{
    /**
     * @var string
     */
    protected $driver;

    /**
     * The queue name
     * @var string|int
     */
    protected $name;

    /**
     * @var int
     */
    protected $errCode = 0;

    /**
     * @var string
     */
    protected $errMsg;

    /**
     * whether serialize data
     * @var bool
     */
    protected $serialize = true;

    /**
     * data serializer like 'serialize' 'json_encode'
     * @var callable
     */
    protected $serializer = 'serialize';

    /**
     * data deserializer like 'unserialize' 'json_decode'
     * @var callable
     */
    protected $deserializer = 'unserialize';

    /**
     * @var array
     */
    protected $channels = [];

    public function __construct($config = [])
    {
        $this->name = $config['name'] ?? $this->name;
        $this->serialize = $config['serialize'] ?? $this->serialize;
        $this->serializer = $config['serializer'] ?? $this->serializer;
        $this->driver = $config['driver'] ?? $this->driver;
        $this->deserializer = $config['deserializer'] ?? $this->deserializer;
        $this->getChannels();
    }

    public function push($data, $priority = self::PRIORITY_NORM): bool
    {
        $status = false;
        try {
            $status = $this->doPush($this->encode($data), $priority);
        } catch (\Exception $e) {
            $this->errCode = $e->getCode() !== 0 ? $e->getCode() : __LINE__;
            $this->errMsg = $e->getMessage();
        }
        return $status;
    }

    /**
     * @param string $data Encoded data string
     * @param int $priority
     * @return bool
     */
    abstract protected function doPush($data, $priority = self::PRIORITY_NORM);

    public function pop($priority = null, $block = false)
    {
        $data = null;
        try {
            if ($data = $this->doPop($priority, $block)) {
                $data = $this->decode($data);
            }
        } catch (\Exception $e) {
            $this->errCode = $e->getCode() !== 0 ? $e->getCode() : __LINE__;
            $this->errMsg = $e->getMessage();
        }
        return $data;
    }

    /**
     * @param null $priority
     * @param bool $block
     * @return string Raw data string
     */
    abstract protected function doPop($priority = null, $block = false);

    /**
     * get Priorities
     * @return array
     */
    public function getPriorities(): array
    {
        return [
            self::PRIORITY_HIGH,
            self::PRIORITY_NORM,
            self::PRIORITY_LOW,
        ];
    }

    /**
     * @param int $priority
     * @return bool
     */
    public function isPriority($priority)
    {
        if (null === $priority) {
            return false;
        }

        return in_array((int)$priority, $this->getPriorities(), true);
    }

    /**
     * @return array
     */
    public function getChannels()
    {
        if (!$this->channels) {
            $this->channels = [
                self::PRIORITY_HIGH => $this->name . self::PRIORITY_HIGH_SUFFIX,
                self::PRIORITY_NORM => $this->name,
                self::PRIORITY_LOW => $this->name . self::PRIORITY_LOW_SUFFIX,
            ];
        }
        return $this->channels;
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    protected function encode($data)
    {
        if (!$this->serialize || !($cb = $this->serializer)) {
            return $data;
        }

        return $cb($data);
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    protected function decode($data)
    {
        if (!$this->serialize || !($cb = $this->deserializer)) {
            return $data;
        }

        return $cb($data);
    }

    /**
     * @return int|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int|string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSerialize(): bool
    {
        return $this->serialize;
    }

    /**
     * @param bool $serialize
     */
    public function setSerialize($serialize = true)
    {
        $this->serialize = (bool)$serialize;
    }

    /**
     * @return callable
     */
    public function getSerializer(): callable
    {
        return $this->serializer;
    }

    /**
     * @param callable $serializer
     */
    public function setSerializer(callable $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @return callable
     */
    public function getDeserializer(): callable
    {
        return $this->deserializer;
    }

    /**
     * @param callable $deserializer
     */
    public function setDeserializer(callable $deserializer)
    {
        $this->deserializer = $deserializer;
    }

    /**
     * @return int
     */
    public function getErrCode(): int
    {
        return $this->errCode;
    }

    /**
     * @return string
     */
    public function getErrMsg(): string
    {
        return $this->errMsg;
    }

    /**
     * @return string
     */
    public function getDriver(): string
    {
        return $this->driver;
    }
}
