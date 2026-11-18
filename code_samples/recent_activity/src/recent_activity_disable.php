<?php declare(strict_types=1);
use Ibexa\Contracts\ActivityLog\ActivityLogServiceInterface;

/** @var ActivityLogServiceInterface $activityLogService */
$activityLogService->disable();

// Perform operations that should not be logged to the activity log
// ...

$activityLogService->enable();
