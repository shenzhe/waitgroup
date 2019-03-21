<?php


namespace WG;

class WaitGroup
{
    private $count = 0;
    private $chan;

    /**
     * waitgroup constructor.
     * @desc 初始化一个channel
     */
    public function __construct()
    {
        $this->chan = new chan;
    }

    /**
     * @desc 计数+1
     * @调用时机：在开启协程前
     */
    public function add()
    {
        $this->count++;
    }

    /**
     * @param $data
     * @desc 协程处理完成时调用，可把协程处理结果数据存入
     */
    public function done($data)
    {

        $this->chan->push($data);
    }


    /**
     * @return array
     * @desc 堵塞的等待所有的协程处理完成, 返回done存入的数据
     */
    public function wait()
    {
        $ret = [];
        for ($i = 0; $i < $this->count; $i++) {
            //调用pop方法时，如果没有数据，此协程会挂起
            //当往chan中push数据后，协程会被恢复
            $ret[] = $this->chan->pop();
        }
        return $ret;
    }
}