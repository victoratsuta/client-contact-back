<?php

use App\Models\Client;
use App\Models\ClientContacts;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 100; $i++){

            $client = factory(Client::class)->create();

            for ($j = 0; $j <= rand(1,4); $j++){

                factory(ClientContacts::class)->create(
                    [
                        'client_id' => $client->id
                    ]
                );

            }

        }
    }
}
