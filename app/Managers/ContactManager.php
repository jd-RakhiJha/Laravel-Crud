<?php

namespace App\Managers;

use App\Models\Contact;
use App\Data\ContactData;
use App\Repositories\Contact\ContactRepository;
use Illuminate\Support\Collection;


class ContactManager
{
    //protected ContactRepository $contacts;

    public function __construct(protected ContactRepository $contacts)
    {
        $this->contacts = $contacts;
    }

    public function getAllContacts()
    {
        return $this->contacts->all();
    }

    public function storeContact(ContactData $contactData)
    {
        return $this->contacts->create($contactData);
    }

    public function updateContact(int $contactId, ContactData $contactData)
    {
        return $this->contacts->updateById($contactId, $contactData);
    }

    public function deleteContact(int $contactId)
    {
        return $this->contacts->delete($contactId);
    }
}
