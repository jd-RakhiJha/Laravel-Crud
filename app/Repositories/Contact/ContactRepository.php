<?php

namespace App\Repositories\Contact;

use App\Models\Contact;
use App\Data\ContactData;
use Illuminate\Support\Collection;


class ContactRepository
{

    public function all(): Collection
    {
        return Contact::all();
    }

    public function findById(int $id): ?Contact
    {
        return Contact::find($id);
    }

    public function create(ContactData $contactData): Contact
    {
        return Contact::create($contactData->toArray());
    }

    public function updateById(int $contactId, ContactData $contactData): Contact
    {
        $contact = Contact::findOrFail($contactId);
        $contact->update($contactData->toArray());
        return $contact;
    }


    public function delete(int $id): bool
    {
        return Contact::destroy($id);
    }

    public function getByUserId(int $userId): ?Contact
    {
        return Contact::where('user_id', $userId)->first();
    }
}
