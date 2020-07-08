<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Cache;
use Config;
class UpdateExchangeRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:exchange_rate';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
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
     * @return mixed
     */
    public function handle()
    {
        try {
            $rs = file_get_contents('https://min-api.cryptocompare.com/data/price?fsym=JPY&tsyms=BTC&api_key='. Config::get('settings.API_KEY'));
            $exchangeRate = json_decode($rs);
            if($exchangeRate->BTC){
                Cache::put('BTC', $exchangeRate->BTC);
            }
        } catch (Exception $e) {
        }
    }

}