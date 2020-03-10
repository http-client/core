<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\MessageNotificationService;

class QueueMessage extends Client
{
    public function send($queueName, string $message, int $delaySeconds = null, int $priority = null)
    {
        return $this->request('POST', "/queues/{$queueName}/messages", [
            'body' => XML::make('Message', [
                'MessageBody' => $message,
                'DelaySeconds' => $delaySeconds,
                'Priority' => $priority,
            ]),
        ]);
    }

    public function receive($queueName)
    {
        return $this->request('GET', "/queues/{$queueName}/messages");
    }

    public function receiveQueueMessages($queueName, $numOfMessages, $waitseconds = null)
    {
        $query = array_filter([
            'numOfMessages' => $numOfMessages,
            'waitseconds' => $waitseconds,
        ]);

        return $this->request('GET', "/queues/{$queueName}/messages?".http_build_query($query));
    }

    public function delete($queueName, $receiptHandle)
    {
        return $this->request('DELETE', "/queues/{$queueName}/messages?ReceiptHandle={$receiptHandle}");
    }

    public function peek($queueName)
    {
        return $this->request('GET', "/queues/{$queueName}/messages?peekonly=true");
    }

    public function peekQueueMessages($queueName, $number)
    {
        return $this->request('GET', "/queues/{$queueName}/messages?peekonly=true&numOfMessages={$number}");
    }

    public function changeVisibility($queueName, $receiptHandle, $timeout)
    {
        return $this->request('PUT', "/queues/{$queueName}/messages?receiptHandle={$receiptHandle}&visibilityTimeout={$timeout}");
    }
}
