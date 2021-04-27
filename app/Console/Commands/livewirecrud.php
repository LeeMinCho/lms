<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class livewirecrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'livewirecrud:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate CRUD Livewire';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $livewireName = $this->ask('Type Livewire Name:');
        $this->info($livewireName);
        $modelName = $this->ask('Type Model Name:');
        $this->info($modelName);
    }
}
