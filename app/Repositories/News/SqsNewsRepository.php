<?php

namespace App\Repositories\News;

use Aws\Exception\AwsException;
use Aws\Sqs\SqsClient;
use InvalidArgumentException;

class SqsNewsRepository implements NewsRepositoryInterface
{
    /** @var SqsClient */
    private $client;

    private $errorMessage = null;

    public function __construct()
    {
        $this->client = new SqsClient([
            'profile' => 'default',
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => '2012-11-05'
        ]);
    }

    /**
     * Queue to SQS
     *
     * @param string $messageBody
     * @param array $attributesMap
     * @return bool
     */
    public function queue(string $messageBody, array $attributesMap = []): bool
    {
        $params = [
            'DelaySeconds' => 10,
            'MessageBody' => $messageBody,
            'QueueUrl' => env('AWS_NEWS_SQS_URL')
        ];

        if (!empty($attributesMap)) {
            $params['MessageAttributes'] = $this->formatAttributes($attributesMap);
        }

        try {
            $result = $this->client->sendMessage($params);
            var_dump($result);
        } catch (AwsException $e) {
            $this->errorMessage = $e->getMessage();
        }

        return true;

    }

    /**
     * Format AWS compatible attributes
     *  Reference: https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/sqs-examples-send-receive-messages.html
     * @param array $attributes
     * @return array
     */
    protected function formatAttributes(array $attributes): array
    {

        $formatted = [];

        foreach ($attributes as $attributeKey => $attributeValue) {

            if (!is_string($attributeKey)) {
                throw new InvalidArgumentException("Attribute key must be a string");
            }

            if (!is_string($attributeValue)) {
                throw new InvalidArgumentException("Attribute value must be a string");
            }

            // only as strings for now
            $formatted[$attributeKey] = [
                'DataType' => "String",
                'StringValue' => $attributeValue
            ];
        }

        return $formatted;
    }

    /**
     * @return null|string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
