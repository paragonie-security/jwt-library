<?php

declare(strict_types=1);

namespace Jose\Component\Checker;

use Override;
use function in_array;
use function is_string;

/**
 * This class is a header parameter checker. When the "alg" header parameter is present, it will check if the value is
 * within the allowed ones.
 */
final readonly class AlgorithmChecker implements HeaderChecker
{
    private const string HEADER_NAME = 'alg';

    /**
     * @param string[] $supportedAlgorithms
     */
    public function __construct(
        private array $supportedAlgorithms,
        private bool $protectedHeader = false
    ) {
    }

    #[Override]
    public function checkHeader(mixed $value): void
    {
        if (! is_string($value)) {
            throw new InvalidHeaderException('"alg" must be a string.', self::HEADER_NAME, $value);
        }
        if (! in_array($value, $this->supportedAlgorithms, true)) {
            throw new InvalidHeaderException('Unsupported algorithm.', self::HEADER_NAME, $value);
        }
    }

    #[Override]
    public function supportedHeader(): string
    {
        return self::HEADER_NAME;
    }

    #[Override]
    public function protectedHeaderOnly(): bool
    {
        return $this->protectedHeader;
    }
}
