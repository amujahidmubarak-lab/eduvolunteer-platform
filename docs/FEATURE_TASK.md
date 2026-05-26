# Current Feature Task: Data Export (LPJ)

## Goal
Implement a lightweight CSV data export feature to allow admins to download teaching reports for their academic requirements.

## Sub-tasks
- [x] Add `exportCsv()` method in `Admin\ReportController.php`.
- [x] Implement native PHP `fputcsv` logic for stream downloading.
- [x] Log the export action in `ActivityLog`.
- [x] Register `GET /admin/reports/export` route in `web.php`.
- [x] Update `admin.reports` view to include "Ekspor CSV" button.
