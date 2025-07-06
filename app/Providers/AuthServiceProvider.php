use App\Models\Quote;
use App\Policies\QuotePolicy;

protected $policies = [
    Quote::class => QuotePolicy::class,
];
