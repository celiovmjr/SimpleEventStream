<?php declare(strict_types=1);

namespace SimpleEventStream\Application\Models;

use SimpleEventStream\Application\Enums\EventType;

class StreamMessage
{
    

    public function __construct(
        private EventType $type,
        private array $data = [],
        private null|int|string $id = null
    ) {}

    public function type(): string
    {
        return $this->type->value;
    }

    public function data(): string
    {
        return $this->format($this->data);
    }

    public function id(): null|int|string
    {
        return $this->id;
    }

    /**
     * Formata os dados para a saída do EventStream.
     *
     * @param array $data Dados que serão enviados como 'data' no evento
     * @return string A string formatada para o envio ao cliente
     */
    private function format(array $data): string
    {
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $message = [];
        
        if ($this->id()) {
            $message[] = "id: {$this->id()}";
        }

        $message[] = "event: {$this->type()}";
        $message[] = "data: {$data}";

        return implode(PHP_EOL, $message) . PHP_EOL . PHP_EOL;
    }

}
