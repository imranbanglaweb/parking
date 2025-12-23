<?php

namespace App\Services\Sms;

use App\Models\SmsConfig;
use Illuminate\Support\Facades\Log;

class SmsSenderService
{
    /** @var string $contactNumbers */
    private $contactNumbers;
    /** @var string $msg */
    private $msg;
    /** @var array $messages */
    private $messages;
    /** @var string $sendingMethod */
    private $sendingMethod;

    /**
     * @param string $contactNumbers (ie 01790876543+01934567890)
     * @param string $message
     * @return $this
     */
    public function oneToMany(string $contactNumbers, string $message): self
    {
        $this->contactNumbers = $contactNumbers;
        $this->msg = $message;
        $this->sendingMethod = __FUNCTION__;

        return $this;
    }

    public function manyToMany(array $messages): self
    {
        $this->messages = $messages;
        $this->sendingMethod = __FUNCTION__;

        return $this;
    }

    /**
     * @param SmsConfig $smsConfig
     * @param string $contentType
     * @return array
     * @throws \Exception
     */
    public function send(SmsConfig $smsConfig, string $contentType = 'text'): array
    {
        if (!isset($smsConfig->parameters['api_key']) || empty($smsConfig->parameters['api_key'])) {
            throw new \Exception("API Key missing");
        }
        if (!isset($smsConfig->parameters['sender_id']) || empty($smsConfig->parameters['sender_id'])) {
            throw new \Exception("Sender Id missing");
        }

        $dataToSend = [];
        $dataToSend['api_key'] = $smsConfig->parameters['api_key'];
        $dataToSend['senderid'] = $smsConfig->parameters['sender_id'];
        $dataToSend['type'] = $contentType;
        $dataToSend['scheduledDateTime'] = now('Asia/Dhaka')
            ->modify('+15 seconds')
            ->format('Y-m-d H:i:s');

        if ($this->sendingMethod == 'oneToMany') {
            $dataToSend['msg'] = $this->msg;
            $dataToSend['contacts'] = $this->contactNumbers;
        } elseif ($this->sendingMethod == 'manyToMany') {
            $dataToSend['messages'] = $this->messages;
        } else {
            throw new \Exception("Please Follow Chain of Command");
        }

        $postData = http_build_query($dataToSend);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $smsConfig->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $log = ['result' => $result, 'statusCode' => $statusCode];
        Log::debug($log);

        return $log;
    }
}
