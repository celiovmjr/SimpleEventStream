<?php declare(strict_types=1);

namespace SimpleEventStream\Application;

use Exception;
use SimpleEventStream\Application\Enums\EventType;
use SimpleEventStream\Application\Models\StreamMessage;

class EventStream
{
    private bool $isStreaming = false;

    public function __construct(
        private null|int|string $id = null
    ) {
        $this->headers();
        ob_implicit_flush();
        
        // Somente finaliza buffer se houver um
        if (ob_get_level() > 0) {
            ob_end_flush();
        }
    }

    /**
     * Inicia o fluxo de eventos.
     */
    public function start(): void
    {
        $this->isStreaming = true;
        $this->emit(new StreamMessage(EventType::CONNECT, ['message' => 'Conexão aberta.'], $this->id));
    }

    /**
     * Define os cabeçalhos necessários para o Server-Sent Events.
     */
    private function headers(): void
    {
        header("Content-Type: text/event-stream");
        header("Cache-Control: no-cache");
        header("Connection: keep-alive");
        header("X-Accel-Buffering: no");
    }

    /**
     * Emite uma mensagem no stream.
     * 
     * @param StreamMessage $message A mensagem a ser emitida.
     * @throws Exception Se o stream não foi iniciado.
     */
    public function emit(StreamMessage $message): void
    {
        if (!$this->isStreaming) {
            throw new Exception("O stream não foi iniciado.");
        }

        echo $message->data();
        flush();
    }

    /**
     * Fecha o stream, emitindo um evento de fechamento.
     * 
     * @throws Exception Se o stream não foi iniciado.
     */
    public function close(): void
    {
        if (!$this->isStreaming) {
            $this->sendError('O stream não foi iniciado.');
            return;
        }

        $this->emit(new StreamMessage(EventType::CLOSE, ['message' => 'Conexão encerrada.'], $this->id));
        $this->isStreaming = false;
    }

    /**
     * Envia uma mensagem de erro para o cliente.
     * 
     * @param string $error A mensagem de erro.
     */
    public function sendError(string $error): void
    {
        $this->emit(new StreamMessage(EventType::ERROR, ['message' => $error], $this->id));
    }

    /**
     * Envia uma notificação personalizada para o cliente.
     * 
     * @param string $notification A notificação a ser enviada.
     */
    public function sendNotification(string $notification): void
    {
        $this->emit(new StreamMessage(EventType::NOTIFY, ['message' => $notification], $this->id));
    }

    /**
     * Simula a entrada de um usuário.
     */
    public function userJoin(string $username): void
    {
        $this->emit(new StreamMessage(EventType::USER_JOIN, ['username' => $username], $this->id));
    }

    /**
     * Simula a saída de um usuário.
     */
    public function userLeave(string $username): void
    {
        $this->emit(new StreamMessage(EventType::USER_LEAVE, ['username' => $username], $this->id));
    }

    /**
     * Simula o evento de digitação de um usuário.
     */
    public function typing(string $username): void
    {
        $this->emit(new StreamMessage(EventType::TYPING, ['username' => $username], $this->id));
    }

    /**
     * Simula o evento de parar de digitar de um usuário.
     */
    public function stopTyping(string $username): void
    {
        $this->emit(new StreamMessage(EventType::STOP_TYPING, ['username' => $username], $this->id));
    }

    /**
     * Envia um evento de atualização.
     */
    public function sendUpdate(array $data): void
    {
        $this->emit(new StreamMessage(EventType::UPDATE, ['data' => $data], $this->id));
    }

    /**
     * Envia um evento de progresso.
     */
    public function sendProgress(float $percentage): void
    {
        $this->emit(new StreamMessage(EventType::PROGRESS, ['percentage' => $percentage], $this->id));
    }

    /**
     * Envia uma confirmação de recebimento.
     */
    public function acknowledge(string $message): void
    {
        $this->emit(new StreamMessage(EventType::ACKNOWLEDGE, ['message' => $message], $this->id));
    }

    /**
     * Envia um evento customizado.
     */
    public function customEvent(array $data): void
    {
        $this->emit(new StreamMessage(EventType::CUSTOM, $data, $this->id));
    }
}
