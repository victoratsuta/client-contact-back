<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = ['first_name', 'last_name', 'email'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {

        return $this->hasMany(ClientContacts::class);

    }

    /**
     * @param ClientContacts $newContact
     * @return bool
     */
    public function hasContact(ClientContacts $newContact)
    {

        foreach ($this->contacts as $contact) {

            if ($contact->id === $newContact->id) {
                return true;
            }

        }

        return false;

    }

    static public function updateFromScv(array $clients): void
    {

        $forCreate = [];

        foreach ($clients as $client){

            if(isset($client[0]) && !empty($client[0]) && isset($client[1]) &&  !empty($client[1])){

                $oldClientQuery = self::where('email', $client[1]);

                if($oldClientQuery->count()){

                    $oldClientQuery->update(
                        [
                            'first_name' => $client[0]
                        ]
                    );

                } else{

                    $forCreate[] = [
                        'email' => $client[1],
                        'first_name' => $client[0]
                    ];

                }

            }

        }

        self::insert($forCreate);

    }
}
