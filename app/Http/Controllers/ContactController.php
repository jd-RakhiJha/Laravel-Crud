<?php

namespace App\Http\Controllers;

use App\Repositories\Contact\ContactRepository;
use Illuminate\Http\Request;
use App\Data\ContactData;
use App\Managers\ContactManager;
use App\Models\Contact;


class ContactController extends Controller
{
    public function __construct(
        private ContactRepository $contacts,
        private ContactManager $contactManager
    ) {}

    public function index()
    {
        return ContactData::collect($this->contactManager->getAllContacts());
    }

    public function store(ContactData $contactData)
    {
        return $this->contactManager->storeContact($contactData);
    }

    public function update(ContactData $contactData, Contact $contact)
    {
        return $this->contactManager->updateContact($contact->id, $contactData);
    }

    public function destroy(Contact $contact)
    {
        return $this->contactManager->deleteContact($contact->id);
    }
}
