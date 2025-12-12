<?php declare(strict_types=1);

namespace App\Discounts\ExpressionProvider;

use DateTimeImmutable;
use DateTimeInterface;

final class IsAnniversaryResolver
{
    private const YEAR_MONTH_DAY_FORMAT = 'Y-m-d';

    private const MONTH_DAY_FORMAT = 'm-d';

    private const REFERENCE_YEAR = 2000;

    public function __invoke(DateTimeInterface $date, int $tolerance = 0): bool
    {
        $d1 = $this->unifyYear(new DateTimeImmutable());
        $d2 = $this->unifyYear($date);

        $diff = $d1->diff($d2, true)->days;

        // Check if the difference between dates is within the tolerance
        return $diff <= $tolerance;
    }

    private function unifyYear(DateTimeInterface $date): DateTimeImmutable
    {
        // Create a new date using the reference year but with the same month and day
        $newDate = DateTimeImmutable::createFromFormat(
            self::YEAR_MONTH_DAY_FORMAT,
            self::REFERENCE_YEAR . '-' . $date->format(self::MONTH_DAY_FORMAT)
        );

        if ($newDate === false) {
            throw new \RuntimeException('Failed to unify year for date.');
        }

        return $newDate;
    }
}
