<?php

require_once __DIR__ . '/../../api/fpdf/fpdf.php';

class InvoiceTemplatePDF extends FPDF
{
    public string $brandName = '';
    public string $brandRUT = '';
    public string $brandAddress = '';
    public string $brandContact = '';
    public string $docTitle = '';
    public string $docSubTitle = '';
    public string $footerLeft = '';
    public float $mx = 14.0;

    public function Header(): void
    {
        $this->SetFillColor(37, 99, 235);
        $this->Rect(0, 0, $this->GetPageWidth(), 22, 'F');

        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 12);
        $this->SetXY($this->mx, 6);
        $this->Cell(0, 6, $this->brandName, 0, 1, 'L');

        $this->SetFont('Arial', '', 9);
        $this->SetXY($this->mx, 12);
        $brandLine = trim($this->brandRUT . ' • ' . $this->brandAddress);
        $this->Cell(0, 5, $brandLine, 0, 1, 'L');

        $this->SetXY($this->mx, 16);
        $this->Cell(0, 5, $this->brandContact, 0, 1, 'L');

        $this->SetTextColor(31, 41, 55);
        $this->SetFont('Arial', 'B', 14);
        $this->SetXY($this->mx, 28);
        $this->Cell(0, 6, $this->docTitle, 0, 1, 'L');

        if ($this->docSubTitle !== '') {
            $this->SetFont('Arial', '', 10);
            $this->SetTextColor(107, 114, 128);
            $this->SetXY($this->mx, 34);
            $this->Cell(0, 5, $this->docSubTitle, 0, 1, 'L');
        }

        $this->Ln(6);
    }

    public function Footer(): void
    {
        $this->SetY(-18);
        $this->SetDrawColor(229, 231, 235);
        $this->Line($this->mx, $this->GetY(), $this->GetPageWidth() - $this->mx, $this->GetY());

        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(107, 114, 128);
        $this->SetXY($this->mx, -14);
        $this->Cell(0, 4, $this->footerLeft, 0, 0, 'L');

        $this->SetXY(-$this->mx - 30, -14);
        $this->Cell(30, 4, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }

    public function Section(string $title, string $subtitle = ''): void
    {
        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(31, 41, 55);
        $this->Cell(0, 7, $title, 0, 1, 'L');

        if ($subtitle !== '') {
            $this->SetFont('Arial', '', 9);
            $this->SetTextColor(107, 114, 128);
            $this->MultiCell(0, 5, $subtitle);
        }

        $this->Ln(2);
    }

    public function FieldGrid(array $fields, int $cols = 3): void
    {
        $cols = max(1, $cols);
        $usableWidth = $this->GetPageWidth() - ($this->mx * 2);
        $columnWidth = $usableWidth / $cols;
        $rowHeight = 12;
        $currentCol = 0;

        foreach ($fields as $field) {
            $label = (string)($field['label'] ?? '');
            $value = (string)($field['value'] ?? '');

            $x = $this->mx + ($columnWidth * $currentCol);
            $y = $this->GetY();
            $this->SetXY($x, $y);
            $this->SetDrawColor(229, 231, 235);
            $this->SetFillColor(249, 250, 251);
            $this->Rect($x, $y, $columnWidth, $rowHeight, 'D');

            $this->SetFont('Arial', 'B', 8);
            $this->SetTextColor(107, 114, 128);
            $this->SetXY($x + 2, $y + 2);
            $this->Cell($columnWidth - 4, 4, $label, 0, 2, 'L');

            $this->SetFont('Arial', '', 9);
            $this->SetTextColor(31, 41, 55);
            $this->SetXY($x + 2, $y + 6);
            $this->Cell($columnWidth - 4, 5, $value, 0, 0, 'L');

            $currentCol++;
            if ($currentCol >= $cols) {
                $currentCol = 0;
                $this->Ln($rowHeight + 2);
            }
        }

        if ($currentCol !== 0) {
            $this->Ln($rowHeight + 2);
        }
    }

    public function StatusChip(string $label, array $bg, array $fg, float $x, float $y): void
    {
        $this->SetFillColor($bg[0], $bg[1], $bg[2]);
        $this->SetTextColor($fg[0], $fg[1], $fg[2]);
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY($x, $y);
        $this->Cell(36, 6, $label, 0, 0, 'C', true);
        $this->SetTextColor(31, 41, 55);
    }

    public function DataTable(array $headers, array $rows, array $widths, array $aligns = []): void
    {
        $this->SetFillColor(243, 244, 246);
        $this->SetDrawColor(229, 231, 235);
        $this->SetFont('Arial', 'B', 9);

        foreach ($headers as $index => $header) {
            $this->Cell($widths[$index] ?? 20, 7, $header, 1, 0, 'L', true);
        }
        $this->Ln();

        $this->SetFont('Arial', '', 9);
        foreach ($rows as $row) {
            foreach ($headers as $index => $_header) {
                $align = $aligns[$index] ?? 'L';
                $value = $row[$index] ?? '';
                $this->Cell($widths[$index] ?? 20, 7, $value, 1, 0, $align);
            }
            $this->Ln();
        }
        $this->Ln(2);
    }

    public function TotalsBlock(array $rows): void
    {
        $this->SetFont('Arial', '', 10);
        $blockWidth = 70;
        $x = $this->GetPageWidth() - $this->mx - $blockWidth;
        foreach ($rows as $row) {
            $label = (string)($row['label'] ?? '');
            $value = (string)($row['value'] ?? '');
            $bold = !empty($row['bold']);
            $big = !empty($row['big']);
            $this->SetXY($x, $this->GetY());
            $this->SetFont('Arial', $bold ? 'B' : '', $big ? 12 : 10);
            $this->Cell($blockWidth - 20, 6, $label, 0, 0, 'L');
            $this->Cell(20, 6, $value, 0, 1, 'R');
        }
        $this->Ln(2);
    }

    public function NotesBlock(string $title, string $text): void
    {
        $this->Section($title);
        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(75, 85, 99);
        $this->MultiCell(0, 5, $text);
        $this->Ln(2);
    }

    public function BarChart(string $title, array $items): void
    {
        $this->Section($title);
        $chartHeight = 30;
        $chartWidth = $this->GetPageWidth() - ($this->mx * 2);
        $maxValue = max(array_map(static fn($item) => (int)($item['value'] ?? 0), $items)) ?: 1;
        $barWidth = $chartWidth / max(count($items), 1);

        $startX = $this->mx;
        $startY = $this->GetY() + $chartHeight;
        foreach ($items as $index => $item) {
            $value = (int)($item['value'] ?? 0);
            $barHeight = ($value / $maxValue) * $chartHeight;
            $x = $startX + ($index * $barWidth) + 2;
            $y = $startY - $barHeight;
            $this->SetFillColor(99, 102, 241);
            $this->Rect($x, $y, $barWidth - 4, $barHeight, 'F');
            $this->SetFont('Arial', '', 8);
            $this->SetTextColor(107, 114, 128);
            $this->SetXY($x, $startY + 2);
            $this->Cell($barWidth - 4, 4, (string)($item['label'] ?? ''), 0, 0, 'C');
        }
        $this->Ln($chartHeight + 10);
    }
}
