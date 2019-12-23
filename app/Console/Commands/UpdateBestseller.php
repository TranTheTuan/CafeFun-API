<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Food;
use Carbon\Carbon;
use App\Services\BestsellerService;

class UpdateBestseller extends Command
{
    protected $bestsellerService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:bestseller';

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
    public function __construct(BestsellerService $bestsellerService)
    {
        parent::__construct();
        $this->bestsellerService = $bestsellerService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $bestseller = $this->bestsellerService->get();
        $bestseller[0]->tag = 'best seller';
        $formerBestseller = Food::where('best_seller', 1)->first();
        if($formerBestseller->id != $bestseller[0]->food_id) {
            $formerBestseller->best_seller = 0;
            $formerBestseller->save();
        }
        Food::find($bestseller[0]->food_id)->update(['best_seller' => 1]);
        $this->info('bestseller: ' . $bestseller[0]->name);
    }
}
