<?php

namespace App\Console\Commands;

use Chazz\Console\Commands;

class test extends Commands {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name=false;

    /**
     * The console command opts.
     *
     * @var array
     */
    protected $opts=[];

    public function handle()
    {
        echo 'test';
    }

}
