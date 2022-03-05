<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateConfigForJs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dist:Jsconfig';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'JavaScriptで使うマスタ情報を作成する';

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
        $configFilePath = sprintf('%s/config/custom.php', base_path());
        require_once $configFilePath;
        $customConfig = loadCustomConfig();
        $this->makeJsFile($customConfig);
    }

    public function makeJsFile(array $customConfig)
    {
        $jsonData = json_encode($customConfig, JSON_UNESCAPED_UNICODE);
        $configFilePath = sprintf('%s/resources/js/config/master.json', base_path());
        file_put_contents($configFilePath, $jsonData);
    }
}
