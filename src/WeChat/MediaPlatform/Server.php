<?php

declare(strict_types=1);

namespace WeForge\WeChat\MediaPlatform;

use League\Pipeline\PipelineBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WeForge\Concerns\Observable;
use WeForge\WeChat\Decorators\FinallyResult;
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

        $this->pushWhen($this->request->query->has('echostr'), function () {
            return new FinallyResult($this->request->query->get('echostr'));
        });
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
                $this->config['app_id'], $this->config['aes_key'] ?? null
            ))
            ->add(new Pipes\DispatchEvents)
            ->add(new WeChatPipes\ObservesHandlers($this->handlers()))
            ->add(new WeChatPipes\MakeResponse(
                $this->config['app_id'], $this->config['aes_key'] ?? null, $this->request->query->has('encrypt_type')
            ))
            ->build()
            ->process($this->request);
    }
}
