<?php

namespace App\Console\Commands;

use App\Models\Message;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\info;

class Auto_Delete_Message_Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto-delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $get_message = Message::where('created_at', '<=', Carbon::now()->subMinutes(30))
            ->get();
        if (isset($get_message)) {
            foreach ($get_message as $item) {
                $item->delete();
            }
        }
        Log::info('auto-delete');
    }
}
