<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response;

use UnexpectedValueException;

class ResponsePayloadException extends UnexpectedValueException
{
    private string $fieldPath;

    public function __construct(string $message, string $fieldPath)
    {
        $this->fieldPath = $fieldPath;
        parent::__construct($message);
    }

    public function getFieldPath(): string
    {
        return $this->fieldPath;
    }

    public static function missing(string $fieldPath): self
    {
        return new self(sprintf('Required field "%s" is missing from response', $fieldPath), $fieldPath);
    }

    public static function nullNotAllowed(string $fieldPath): self
    {
        return new self(sprintf('Required field "%s" cannot be null', $fieldPath), $fieldPath);
    }

    /**
     * @param mixed $actual
     */
    public static function typeMismatch(string $fieldPath, string $expected, $actual): self
    {
        return new self(
            sprintf('Field "%s" expected %s, got %s', $fieldPath, $expected, self::describeType($actual)),
            $fieldPath
        );
    }

    /**
     * @param mixed $value
     */
    private static function describeType($value): string
    {
        if ($value === null) {
            return 'null';
        }

        if (is_object($value)) {
            return get_class($value);
        }

        return gettype($value);
    }
}
