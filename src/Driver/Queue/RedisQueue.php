<?php

namespace Chazz\Driver\Queue;

use Chazz\Facades\Redis;

class RedisQueue extends BaseQueue
{

    protected function doPush($data, $priority = self::PRIORITY_NORM)
    {
        if (!$this->isPriority($priority)) {
            $priority = self::PRIORITY_NORM;
        }
        return Redis::lPush($this->channels[$priority], $data);
    }

    /**
     * {@inheritDoc}
     */
    protected function doPop($priority = null, $block = false)
    {
        if ($this->isPriority($priority)) {
            $channel = $this->channels[$priority];
            return Redis::rPop($channel);
        }
        $data = null;
        foreach ($this->channels as $channel) {
            if ($data = Redis::rPop($channel)) {
                break;
            }
        }
        return $data;
    }

    /**
     * @param int $priority
     * @return int
     */
    public function count($priority = self::PRIORITY_NORM)
    {
        $channel = $this->channels[$priority];
        return Redis::lLen($channel);
    }
}
