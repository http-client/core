<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\MessageNotificationService;

trait ManagesQueueMessages
{
    public function sendQueueMessage($queueName, string $message, int $delaySeconds = null, int $priority = null)
    {
        return $this->encapsulatesRequest('POST', "/queues/{$queueName}/messages", [
            'body' => XML::make('Message', [
                'MessageBody' => $message,
                'DelaySeconds' => $delaySeconds,
                'Priority' => $priority,
            ]),
        ]);
    }

    public function sendQueueMessages($queueName)
    {
        //todo
    }

    public function receiveQueueMessage($queueName)
    {
        return $this->encapsulatesRequest('GET', "/queues/{$queueName}/messages");
    }

    public function receiveQueueMessages($queueName, $numOfMessages, $waitseconds = null)
    {
        $query = array_filter([
            'numOfMessages' => $numOfMessages,
            'waitseconds' => $waitseconds,
        ]);

        return $this->encapsulatesRequest('GET', "/queues/{$queueName}/messages?".http_build_query($query));
    }

    public function deleteQueueMessage($queueName, $receiptHandle)
    {
        return $this->encapsulatesRequest('DELETE', "/queues/{$queueName}/messages?ReceiptHandle={$receiptHandle}");
    }

    public function peekQueueMessage($queueName)
    {
        return $this->encapsulatesRequest('GET', "/queues/{$queueName}/messages?peekonly=true");
    }

    public function peekQueueMessages($queueName, $number)
    {
        return $this->encapsulatesRequest('GET', "/queues/{$queueName}/messages?peekonly=true&numOfMessages={$number}");
    }

    public function changeQueueMessageVisibility($queueName, $receiptHandle, $timeout)
    {
        return $this->encapsulatesRequest('PUT', "/queues/{$queueName}/messages", [
            'query' => [
                'receiptHandle' => $receiptHandle,
                'visibilityTimeout' => $timeout,
            ],
        ]);
    }
}
