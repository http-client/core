<?php

declare(strict_types=1);

namespace WeForge\WeChat\OpenPlatform;

use League\Pipeline\PipelineBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WeForge\Concerns\Observable;
use WeForge\WeChat\OpenPlatform\Server\Handlers\StoreVerifyTicket;
use WeForge\WeChat\Pipes as WeChatPipes;

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

    /**
     * @param array                                          $config
     * @param \Symfony\Component\HttpFoundation\Request|null $request
     */
    public function __construct(array $config = [], Request $request = null)
    {
        $this->config = $config;
        $this->request = $request ?: Request::createFromGlobals();

        $this->push(new StoreVerifyTicket);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
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
}
