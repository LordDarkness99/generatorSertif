<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RuntimeException;
use setasign\Fpdi\Fpdi;
use Symfony\Component\HttpFoundation\Response;

class CertificateController extends Controller
{
    public function create()
    {
        return view('certificates.create');
    }

    public function generate(Request $request): Response
    {
        $data = $request->validate([
            'recipient_name' => ['required', 'string', 'max:100'],
            'issued_at' => ['required', 'date'],
            'signer_name' => ['required', 'string', 'max:100'],
        ]);

        $templatePath = storage_path('app/certificates/template.pdf');
        $signaturePath = storage_path('app/certificates/ttd-print.png');

        if (! is_file($templatePath) || ! is_readable($templatePath)) {
            throw new RuntimeException('Template sertifikat tidak ditemukan atau tidak dapat dibaca.');
        }

        if (! is_file($signaturePath) || ! is_readable($signaturePath)) {
            throw new RuntimeException('File tanda tangan tidak ditemukan atau tidak dapat dibaca.');
        }

        $data['recipient_name'] = Str::squish($data['recipient_name']);
        $data['signer_name'] = Str::squish($data['signer_name']);

        $pdf = new Fpdi;
        $pageCount = $pdf->setSourceFile($templatePath);

        if ($pageCount < 1) {
            throw new RuntimeException('Template sertifikat tidak memiliki halaman.');
        }

        $templateId = $pdf->importPage(1);
        $pageSize = $pdf->getTemplateSize($templateId);

        $pdf->AddPage($pageSize['orientation'], [$pageSize['width'], $pageSize['height']]);
        $pdf->useTemplate($templateId);
        $pdf->SetTextColor(39, 96, 77);
        $pdf->AddFont('Great Vibes', '', 'GreatVibes-Regular.json', resource_path('fonts/pdf'));

        $pdf->SetFillColor(246, 255, 251);
        $dateMaskWidth = 125;
        $pdf->Rect(($pageSize['width'] - $dateMaskWidth) / 2, 132.2, $dateMaskWidth, 6.5, 'F');
        $signerMaskWidth = 68;
        $pdf->Rect(($pageSize['width'] - $signerMaskWidth) / 2, 174, $signerMaskWidth, 11, 'F');

        $recipientName = $this->toPdfEncoding($data['recipient_name']);
        $this->addCenteredText($pdf, $recipientName, 94.5, '', 74, 235, 'Great Vibes');

        $issuedAt = Carbon::parse($data['issued_at'])
            ->locale('id')
            ->translatedFormat('d F Y');
        $dateText = $this->toPdfEncoding("Diberikan pada {$issuedAt}.");
        $this->addCenteredText($pdf, $dateText, 130, 'B', 10, 235);

        $signatureWidth = 40;
        $signatureHeight = $signatureWidth * (275 / 450);
        $pdf->Image(
            $signaturePath,
            ($pageSize['width'] - $signatureWidth) / 2,
            149.3,
            $signatureWidth,
            $signatureHeight,
            'PNG',
        );

        $signerName = $this->toPdfEncoding($data['signer_name']);
        $this->addCenteredText($pdf, $signerName, 174.9, 'B', 11, 235, 'Arial');

        return response($pdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="sertifikat-'.Str::slug($data['recipient_name']).'.pdf"',
        ]);
    }

    private function addCenteredText(
        Fpdi $pdf,
        string $text,
        float $top,
        string $style,
        int $fontSize,
        float $maxWidth,
        string $fontFamily = 'Times',
    ): void {
        $pdf->SetFont($fontFamily, $style, $fontSize);

        while ($fontSize > 12 && $pdf->GetStringWidth($text) > $maxWidth) {
            $fontSize--;
            $pdf->SetFont($fontFamily, $style, $fontSize);
        }

        $pdf->SetXY(0, $top);

        if ($pdf->GetStringWidth($text) > $maxWidth) {
            $pdf->SetX(($pdf->GetPageWidth() - $maxWidth) / 2);
            $pdf->MultiCell($maxWidth, 7, $text, 0, 'C');

            return;
        }

        $pdf->Cell($pdf->GetPageWidth(), 8, $text, 0, 0, 'C');
    }

    private function toPdfEncoding(string $text): string
    {
        $encoded = iconv('UTF-8', 'windows-1252//TRANSLIT', $text);

        if ($encoded === false) {
            throw new RuntimeException('Teks sertifikat tidak dapat dikonversi ke encoding PDF.');
        }

        return $encoded;
    }
}
