<?php

declare(strict_types=1);

namespace WeForge\WeChat\MediaPlatform;

use League\Pipeline\PipelineBuilder;
use Symfony\Component\HttpFoundation\Request;
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

        $this->pushWhen($this->request->isMethod('GET') && $this->request->get('echostr'), function () {
            return new FinallyResult($this->request->get('echostr'));
        });
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resolve()
    {
        return (new PipelineBuilder)
            ->add(new WeChatPipes\ConvertRequestToString)
            ->add(new WeChatPipes\ValidateSignature(
                $this->config['token'], $this->request->get('signature'), $this->request->get('timestamp'), $this->request->get('nonce')
            ))
            ->add(new WeChatPipes\ContentInterpretation)
            ->add(new WeChatPipes\DecryptDataIfNecessary(
                $this->config['app_id'], $this->config['aes_key'] ?? null
            ))
            ->add(new Pipes\DispatchEvents)
            ->add(new WeChatPipes\MakesResponse($this->handlers()))
            ->build()
            ->process($this->request);
    }
}
