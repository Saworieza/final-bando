<?php

use App\Models\Quote;
use App\Policies\QuotePolicy;

protected $policies = [
    News::class => NewsPolicy::class,
    Quote::class => QuotePolicy::class,
];
