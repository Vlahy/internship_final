<?php

namespace App\Models\Enums;

interface ReviewData
{

    const MARK_BAD = 'bad';
    const MARK_GOOD = 'good';
    const MARK_EXCELLENT = 'excellent';
    const MARKS = [self::MARK_BAD, self::MARK_GOOD, self::MARK_EXCELLENT];
}