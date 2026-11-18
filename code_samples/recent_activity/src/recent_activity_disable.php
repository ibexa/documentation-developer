<?php declare(strict_types=1);

/** @var \Ibexa\Contracts\ActivityLog\ActivityLogServiceInterface $activityLogService */
$activityLogService->disable();

// Perform operations that should not be logged to the activity log
// ...

$activityLogService->enable();
