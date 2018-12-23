<?php

namespace App\Http\Controllers;


use App\Http\Requests\ContactRequest;
use App\Models\Client;
use App\Models\ClientContacts;

class ClientContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(ClientContacts::with('client')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ContactRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        $contact = ClientContacts::create($request->all());

        return response()->json($contact->client->load('contacts'));
    }

    /**
     * Display the specified resource.
     *
     * @param ClientContacts $contact
     * @return \Illuminate\Http\Response
     */
    public function show(ClientContacts $contact)
    {
        return response()->json($contact->load('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ContactRequest $request
     * @param ClientContacts $contact
     * @return void
     */
    public function update(ContactRequest $request, ClientContacts $contact)
    {
        $client = Client::find($request->get('client_id'));

        if (!$client->hasContact($contact)) {

            return response()->json([
                'response' => 'error',
                'message' => "Client with id {$client->id} dosen`t have this contact",
            ], 422);

        }

        $contact->update($request->all());

        return response()->json($contact->load('client'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ClientContacts $contact
     * @return void
     * @throws \Exception
     */
    public function destroy(ClientContacts $contact)
    {
        $contact->delete();

        return response()->json($contact->client->load('contacts'));
    }
}
