<?php

namespace Database\Seeders;

use App\Helpers\WalletHelper;
use App\Models\Terminal;
use App\Models\Transaction;
use App\Models\WalletTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ter = Terminal::all();

        $ter->each(
            fn(Terminal $terminal) => Transaction::factory(rand(2, 5))->create([
                'user_id'       => $terminal->user_id,
                'terminal_id'   => $terminal->id,
            ])
        );

        $t = Transaction::successful()->get();

//        Seed Wallet Transactions
        /*$t->each(function (Transaction $transaction) {
            WalletHelper::creditTransaction($transaction);
        });*/

        $t->each(
            fn (Transaction $transaction) => WalletTransaction::factory()->create([
                'product_id'    => $transaction->type_id,
                'wallet_id'     => $transaction->agent->wallet->id,
                'reference'     => $transaction->reference,
                'created_at'     => $transaction->created_at,
            ])
        );
    }
}
