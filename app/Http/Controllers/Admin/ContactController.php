<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactAllRequest;
use App\Http\Requests\Contact\ContactDeleteRequest;
use App\Http\Requests\Contact\ContactFindRequest;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\User;
use App\Services\ContactService;
use App\Services\SettingService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{

    public function __construct(readonly private ContactService $contactService)
    {
    }

    public function index(ContactAllRequest $request)
    {
        $title = __('message.contacts');
        $validated = $request->validated();
        $contacts = $this->contactService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.contact.index', [
            'title' => $title,
            'contacts' => $contacts,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }

    public function show(ContactFindRequest $request, Contact $contact)
    {
        $title = __('message.show');

        $contact->read = true;
        $contact->save();

        return view('admin.contact.show', compact(['title', 'contact']));
    }

    public function destroy(ContactDeleteRequest $request, Contact $contact): RedirectResponse
    {
        $contact->delete();

        toast(__('message.deleted'), 'success');

        return redirect(session('previous_url')??route('contacts.index'));
    }
}
