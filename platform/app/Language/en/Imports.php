<?php

// File import: upload, mapping, preview and confirmation (RF-21/RF-22)
return [
    'upload.title'    => 'Import file',
    'upload.hint'     => 'UTF-8 CSV or XLSX without macros. Max 10 MiB and 10,000 rows.',
    'upload.sheet'    => 'Sheet',
    'mapping.title'   => 'Map columns',
    'mapping.idField' => 'Stable ID column (external_id)',
    'mapping.idHint'  => 'Required for deduplication; the row number is never used.',

    'preview.title'     => 'Preview',
    'preview.valid'     => 'Valid',
    'preview.rejected'  => 'Rejected',
    'preview.duplicates'=> 'Duplicates',
    'preview.noActions' => 'Confirming only incorporates data; it does not trigger contacts.',

    'confirm.success' => 'Import confirmed: {0} records incorporated.',
    'confirm.stale'   => 'The preview changed. Review the new revision before confirming.',
    'confirm.expired' => 'The file expired. Upload it again; your template and mapping are preserved.',

    'error.invalidFile' => 'Invalid file or unsupported format.',
    'error.tooLarge'    => 'The file exceeds the maximum allowed size.',
    'error.formulas'    => 'Formulas detected; they are treated as cell errors. Fix the file.',
    'error.duplicateIds'=> 'Duplicate IDs within the file. Fix the conflicts to include those rows.',
    'error.missingId'   => 'The stable ID column mapping is missing.',

    'status.uploaded'      => 'Uploaded',
    'status.validating'    => 'Validating',
    'status.preview_ready' => 'Preview ready',
    'status.confirming'    => 'Confirming',
    'status.completed'     => 'Completed',
    'status.partial'       => 'Partial',
    'status.rejected'      => 'Rejected',
    'status.cancelled'     => 'Cancelled',
    'status.expired'       => 'Expired',
];
