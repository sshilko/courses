<?php

namespace App\ApiPlatform;

use ApiPlatform\Core\Serializer\Filter\FilterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DailyStatsDataFilter implements FilterInterface
{
    public const FROM_FILTER_CONTEXT = 'daily_stats_from';
    private bool $throwmyErrorOnInvalid;

    public function __construct(bool $throwmyErrorOnInvalid = false)
    {
        $this->throwmyErrorOnInvalid = $throwmyErrorOnInvalid;
    }

    public function apply(Request $request, bool $normalization, array $attributes, array &$context)
    {
        $from = $request->query->get('from');
        if (!$from) {
            return;
        }

        $fromDate = \DateTimeImmutable::createFromFormat('Y-m-d', $from);
        if ($fromDate) {
            $fromDate = $fromDate->setTime(0, 0, 0);

            $context[self::FROM_FILTER_CONTEXT] = $fromDate;
        } else {
            if ($this->throwmyErrorOnInvalid) {
                throw new BadRequestHttpException('Invalid date from format');
            }

            //bad date
        }
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'myfrom' => [
                'property' => null,
                'type' => 'string',
                'required' => false,
                'openapi' => [
                    'description' => 'Search from date e.g. 2020-09-01'
                ]
            ],
        ];
    }
}