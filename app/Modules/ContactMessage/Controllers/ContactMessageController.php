<?php

namespace App\Modules\ContactMessage\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ContactMessage\Services\ContactMessageService;
use App\Modules\ContactMessage\Requests\StoreContactMessageRequest;
use App\Modules\ContactMessage\Requests\UpdateContactMessageRequest;
use App\Modules\ContactMessage\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function __construct(protected ContactMessageService $service) {}

    public function index()
    {
        return $this->service->list();
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function store(StoreContactMessageRequest $request)
    {
        $data = $request->validated();
        $data['tenant_id'] = tenant('id');
        return $this->service->store($data);
    }

    public function update(UpdateContactMessageRequest $request, ContactMessage $message)
    {
        return $this->service->update($message, $request->validated());
    }

    public function destroy(ContactMessage $message)
    {
        return $this->service->destroy($message);
    }
}
