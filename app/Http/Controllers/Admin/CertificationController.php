<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CertificateStoreRequest;
use App\Http\Requests\CertificateUpdateRequest;
use App\Models\Certification;
use App\Service\CertificateService;

class CertificationController
{
    public function __construct(private CertificateService $certificateService) {}

    public function index()
    {
        $certificates = Certification::with(['user', 'file'])->get();

        return view('backend.certifications.index', [
            'certificates' => $certificates
        ]);
    }

    public function create()
    {
        return view('backend.certifications.create');
    }

    public function store(CertificateStoreRequest $request)
    {
        $this->certificateService->handleCreateCertificate($request->validated(), $request->file('image'));

        return to_route('admin.certificate.index')->with([
            'success' => 'New Certification successfully created.'
        ]);
    }

    public function edit(Certification $certificate)
    {
        return view('backend.certifications.edit', [
            'certificate' => $certificate
        ]);
    }

    public function update(CertificateUpdateRequest $request, Certification $certificate)
    {
        $this->certificateService->handleUpdateCertificate($request->validated(), $request->file('image'), $certificate);

        return to_route('admin.certificate.index')->with([
            'success' => 'Certificate successfully updated.'
        ]);

    }

    public function destroy(Certification $certificate)
    {
        $this->certificateService->handleDeleteCertificate($certificate);

        return to_route('admin.certificate.index')->with([
            'success' => 'Certificate successfully deleted.'
        ]);
    }
}
