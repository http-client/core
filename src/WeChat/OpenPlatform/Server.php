<?php

declare(strict_types=1);

namespace HttpClient\WeChat\OpenPlatform;

use HttpClient\Concerns\Observable;
use HttpClient\WeChat\MediaPlatform\Server as MediaPlatformServer;
use HttpClient\WeChat\OpenPlatform\Server\Handlers\StoreVerifyTicket;
use HttpClient\WeChat\Pipes as WeChatPipes;
use League\Pipeline\PipelineBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Server
{
    use Observable;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    public function __construct(array $config = [], Request $request = null)
    {
        $this->config = $config;
        $this->request = $request ?: Request::createFromGlobals();

        $this->push(new StoreVerifyTicket);
    }

    public function resolve(): Response
    {
        return (new PipelineBuilder)
            ->add(new WeChatPipes\ConvertRequestToString)
            ->add(new WeChatPipes\ContentInterpretation)
            ->add(new WeChatPipes\ValidateSignature(
                $this->config['token'], $this->request->query->all()
            ))
            ->add(new WeChatPipes\DecryptDataIfNecessary(
                $this->config['app_id'], $this->config['aes_key']
            ))
            ->add(new Pipes\DispatchEvents)
            ->add(new WeChatPipes\ObservesHandlers($this->handlers()))
            ->add(new WeChatPipes\MakeResponse(
                $this->config['app_id'], $this->config['aes_key']
            ))
            ->build()
            ->process($this->request);
    }

    public function mediaPlatform()
    {
        return new MediaPlatformServer($this->config, $this->request);
    }
}
