<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response;

use ForumPay\PaymentGateway\PHPClient\Http\HttpResult;

class ResponsePayload
{
    private array $data;

    private string $path;

    private function __construct(array $data, string $path)
    {
        $this->data = $data;
        $this->path = $path;
    }

    public static function fromHttpResult(HttpResult $httpResult): self
    {
        $response = $httpResult->getResponse();
        if (!is_array($response)) {
            throw ResponsePayloadException::typeMismatch('$', 'JSON object or array', $response);
        }

        return new self($response, '$');
    }

    public static function fromArray(array $data, string $path = '$'): self
    {
        return new self($data, $path);
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function requiredString(string $key): string
    {
        $value = $this->present($key);
        if ($value === null) {
            throw ResponsePayloadException::nullNotAllowed($this->child($key));
        }

        return $this->asString($key, $value);
    }

    public function optionalString(string $key, ?string $default = null): ?string
    {
        if (!$this->has($key) || $this->data[$key] === null) {
            return $default;
        }

        return $this->asString($key, $this->data[$key]);
    }

    public function requiredInt(string $key): int
    {
        $value = $this->present($key);
        if ($value === null) {
            throw ResponsePayloadException::nullNotAllowed($this->child($key));
        }

        return $this->asInt($key, $value);
    }

    public function requiredBool(string $key): bool
    {
        $value = $this->present($key);
        if ($value === null) {
            throw ResponsePayloadException::nullNotAllowed($this->child($key));
        }

        return $this->asBool($key, $value);
    }

    public function optionalBool(string $key, bool $default = false): bool
    {
        if (!$this->has($key) || $this->data[$key] === null) {
            return $default;
        }

        return $this->asBool($key, $this->data[$key]);
    }

    public function requiredArray(string $key): array
    {
        $value = $this->present($key);
        if (!is_array($value)) {
            throw ResponsePayloadException::typeMismatch($this->child($key), 'array', $value);
        }

        return $value;
    }

    public function optionalArray(string $key, ?array $default = null): ?array
    {
        if (!$this->has($key) || $this->data[$key] === null) {
            return $default;
        }

        if (!is_array($this->data[$key])) {
            throw ResponsePayloadException::typeMismatch($this->child($key), 'array', $this->data[$key]);
        }

        return $this->data[$key];
    }

    public function requiredObject(string $key): self
    {
        $value = $this->present($key);
        if (!is_array($value)) {
            throw ResponsePayloadException::typeMismatch($this->child($key), 'object', $value);
        }

        return new self($value, $this->child($key));
    }

    public function optionalObject(string $key): ?self
    {
        if (!$this->has($key) || $this->data[$key] === null) {
            return null;
        }

        return $this->requiredObject($key);
    }

    /**
     * @return self[]
     */
    public function requiredList(string $key): array
    {
        return $this->wrapList($this->requiredArray($key), $this->child($key));
    }

    /**
     * @return self[]
     */
    public function optionalList(string $key): array
    {
        return $this->wrapList($this->optionalArray($key, []), $this->child($key));
    }

    /**
     * @return self[]
     */
    public function asList(): array
    {
        return $this->wrapList($this->data, $this->path);
    }

    /**
     * @return mixed
     */
    public function optional(string $key)
    {
        if (!$this->has($key)) {
            return null;
        }

        return $this->data[$key];
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * @return mixed
     */
    private function present(string $key)
    {
        if (!$this->has($key)) {
            throw ResponsePayloadException::missing($this->child($key));
        }

        return $this->data[$key];
    }

    /**
     * @param mixed $value
     */
    private function asString(string $key, $value): string
    {
        if (!is_string($value)) {
            throw ResponsePayloadException::typeMismatch($this->child($key), 'string', $value);
        }

        return $value;
    }

    /**
     * @param mixed $value
     */
    private function asInt(string $key, $value): int
    {
        if (is_int($value)) {
            return $value;
        }

        if (is_string($value) && is_numeric($value)) {
            return (int) $value;
        }

        throw ResponsePayloadException::typeMismatch($this->child($key), 'int', $value);
    }

    /**
     * @param mixed $value
     */
    private function asBool(string $key, $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if ($value === 0 || $value === 1) {
            return (bool) $value;
        }

        if ($value === '0' || $value === '1') {
            return $value === '1';
        }

        throw ResponsePayloadException::typeMismatch($this->child($key), 'bool', $value);
    }

    /**
     * @return self[]
     */
    private function wrapList(array $items, string $path): array
    {
        $payloads = [];
        foreach (array_values($items) as $index => $item) {
            if (!is_array($item)) {
                throw ResponsePayloadException::typeMismatch($path . '[' . $index . ']', 'object', $item);
            }

            $payloads[] = new self($item, $path . '[' . $index . ']');
        }

        return $payloads;
    }

    private function child(string $key): string
    {
        return $this->path . '.' . $key;
    }
}
