<?php

namespace Tests\Feature;

use Tests\TestCase;

class CertificateGenerationTest extends TestCase
{
    public function test_certificate_form_is_available(): void
    {
        $this->get(route('certificates.create'))
            ->assertOk()
            ->assertSee('Buat sertifikat')
            ->assertSee('Nama penerima')
            ->assertSee('Pratinjau sertifikat');
    }

    public function test_certificate_is_generated_as_a_pdf_download(): void
    {
        $response = $this->post(route('certificates.generate'), [
            'recipient_name' => 'Adrian Prasetya',
            'issued_at' => '2026-08-02',
            'signer_name' => 'Brenda Soetjipto',
        ]);

        $response->assertOk()
            ->assertHeader('Content-Type', 'application/pdf')
            ->assertHeader('Content-Disposition', 'attachment; filename="sertifikat-adrian-prasetya.pdf"');

        $this->assertStringStartsWith('%PDF-', $response->getContent());
    }

    public function test_certificate_form_validates_required_fields(): void
    {
        $this->from(route('certificates.create'))
            ->post(route('certificates.generate'), [
                'issued_at' => 'not-a-date',
            ])
            ->assertRedirect(route('certificates.create'))
            ->assertSessionHasErrors(['recipient_name', 'issued_at', 'signer_name']);
    }
}
