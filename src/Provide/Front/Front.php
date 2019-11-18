<?php
declare(strict_types=1);

namespace Nora\App\Provide\Front;

use Nora\DI\InjectorInterface;
use Psr\Http\Message\{
    ServerRequestInterface,
    ResponseInterface
};
use Nora\Http\Provide\ServerRequestFactory;
use Psr\Log\LoggerInterface;

use Nora\Routing\RouterInterface;
use Ramsey\Uuid\UuidFactoryInterface;

class Front implements FrontInterface
{
    private $injector;

    /**
     * @var Logger[]
     */
    private $loggers = [];

    private $logger;

    private $serverRequestFactory;

    public function __construct(
        LoggerInterface $logger,
        ServerRequestFactory $serverRequestFactory,
        RouterInterface $router,
        ResponseInterface $response,
        UuidFactoryInterface $uuidFactory
    ) {
        $this->serverRequestFactory = $serverRequestFactory;
        $this->response = $response;
        $this->router = $router;
        $this->uuidFactory = $uuidFactory;
        $this->logger = $logger->context([
            "application" => "front"
        ]);
    }

    /**
     * Globalsを使う
     */
    public function withGlobals($globals, array $servers = [])
    {
        $newInstance = $this;
        $newInstance->request = ($this->serverRequestFactory)($globals, $servers);
        return $newInstance;
    }

    private function pushLogger(LoggerInterface $logger)
    {
        array_push($this->loggers, $this->logger);
        $this->logger = $logger;
    }

    public function run()
    {
        // 実行
        ($this)($this->request, $this->response);
    }

    /**
     * 実行
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        // ルートデータを読み込む
        $this->router->map('get', '/', '/index');

        // リクエストIDを付与
        $this->pushLogger($this->logger->context([
            'request-id' => ($this->uuidFactory)->uuid1()
        ]));

        // ルーティング処理
        $route = $this->router->route($request);
        var_dump($route);

        // $request = (new RequestFactory)($request);
        // $response = (new ResponseFactory)($response);
        // // 初期化
        // $this->startup($request, $response);
        // 受付ログを残す
        $this->logger->debug(
            sprintf(
                'リクエスト %s %s',
                $request->getMethod(),
                $request->getUri()
            )
        );


        //
        //
        // // レスポンスを書き込む
        // $this->response->write('aaa');
        // $this->response->write('bbbb');
        //
        //
        $this->logger->info("完了");
        // $this->logger->info("完了");
        // $this->logger->info("完了");
        // $this->logger->info("完了");
    }
}
