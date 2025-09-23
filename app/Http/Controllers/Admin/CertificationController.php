<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CertificateStoreRequest;
use App\Http\Requests\CertificateUpdateRequest;
use App\Models\Certification;
use App\Service\CertificateService;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    private $certificateService;

    public function __construct(CertificateService $certificateService) {
        $this->certificateService = $certificateService;
    }

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

    public function store(CertificateStoreRequest $request, Certification $certification)
    {
        $data = $request->only([
            'cert_name', 'issuing_organization', 'issue_date', 'expired_date', 'image'
        ]);

        $certification = $this->certificateService->handleCertificate($data, $request);

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
        $data = $request->only([
            'cert_name', 'issuing_organization', 'issue_date', 'expired_date', 'image'
        ]);

        $certification = $this->certificateService->handleUpdateCertificate($data, $request, $certificate);

        return to_route('admin.certificate.index')->with([
            'success' => 'Certificate successfully updated.'
        ]);

    }

    public function destroy(Certification $certificate)
    {
        $certificate = $this->certificateService->handleDeleteCertificate($certificate);

        return to_route('admin.certificate.index')->with([
            'success' => 'Certificate successfully deleted.'
        ]);
    }
}
