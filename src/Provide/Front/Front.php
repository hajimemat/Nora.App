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

use Nora\App\Front\Exception\{
    MethodNotAllowed,
    NotFound
};

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
        $this->router->map('post', '/', '/');

        // リクエストIDを付与
        $this->pushLogger($this->logger->context([
            'request-id' => ($this->uuidFactory)->uuid1(),
            'request-sig' => sprintf(
                "(%s) %s ",
                $request->getMethod(),
                $request->getUri()->getPath()
            )
        ]));

        // 受付ログを残す
        $this->logger->debug(
            sprintf(
                'リクエスト %s %s',
                $request->getMethod(),
                $request->getUri()
            )
        );

        // ルーティング処理
        $route = $this->router->route($request);

        // ルーティング先が無い
        if ($route[0] === ($this->router)::NOT_FOUND) {
            throw new NotFound("Page Not Found");
        }

        // メソッドが許可されていない
        if ($route[0] === ($this->router)::METHOD_NOT_ALLOWED) {
            throw new MethodNotAllowed("Method Not Allowed");
        }

        $this->logger->info("完了 : ".$response->getStatusCode()." ".$response->getReasonPhrase());

        $response->getBody()->rewind();
        echo $response->getBody()->getContents();

    }
}
