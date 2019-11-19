<?php
declare(strict_types=1);

namespace Nora\App\Provide\Domain;

use Nora\DI\Module;
use Nora\DI\Scope;

use Psr\SimpleCache;
use Nora\App;

// PHPパーサー
use PhpParser;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Stmt;
use PhpParser\Comment;


/**
 * ドメインモジュール
 */
class DomainRepository implements DomainRepositoryInterface
{
    public function __construct(
        App\AppMeta $meta,
        App\Provide\Configure\ConfigInterface $config,
        SimpleCache\CacheInterface $cache
    ) {

        // リソースをビルドする
        $domains = $config['domain'];
        $prefix = $meta->name;
        $compileDir = $meta->tmpDir . "/domain";

        $parser = (new PhpParser\ParserFactory)->create(PhpParser\ParserFactory::PREFER_PHP7);
        $printer = new PhpParser\PrettyPrinter\Standard;

        foreach ($domains as $domain => $domainData) {

            // エンティティをビルドする
            foreach ($domainData['entity'] as $name => $entity)
            {
                var_Dump($entity);
                // ベースクラス
                $ast = $parser->parse(Templates::ENTITY_CLASS_CODE);

                $traverser = new PhpParser\NodeTraverser;
                $traverser->addVisitor(new class($meta, $domain, $name, $entity) extends PhpParser\NodeVisitorAbstract {

                    private $name;
                    private $entity;

                    public function __construct($meta, $domain, $name, $entity) {
                        $this->name = $name;
                        $this->entity = $entity;
                        $this->domain = $domain;
                        $this->meta = $meta;
                    }

                    public function enterNode(Node $node) {
                        if ($node instanceof Stmt\Namespace_) {
                            $node->name = new Node\Name($this->meta->name . "\\Domain\\" . $this->name);
                        }
                        if ($node instanceof Stmt\Class_) {
                            $node->setDocComment(new Comment\Doc(<<<DOC
/**
 * ドメイン: エンティティ
 *
 * {$this->entity['_desc']}
 *
 * @app {$this->meta->name}
 * @domain {$this->domain}
 * @generator Nora\Domain\Compiler
 */
DOC
));
                            $node->name = new Node\Name($this->name.'Entity');

                            array_unshift(
                                $node->stmts,
                                new Stmt\Nop()
                            );

                            foreach (array_reverse($this->entity['values']) as $name => $type) {

                                $fqname = "\\" .  $this->meta->name . "\\Domain\\" . $this->domain . "\\" . $type;

                                $prop = new Stmt\Property(
                                    4,
                                    [
                                        new Stmt\PropertyProperty(
                                            $name . "Factory",
                                            new Expr\ClassConstFetch(new Node\Name(
                                                "\\" .  $this->meta->name . "\\Domain\\" . $this->domain . "\\" . $type . "Factory"
                                            ), 'class')
                                        )
                                    ],
                                );
                                $prop->setDocComment(new Comment\Doc("/** @var {$fqname} **/"));
                                array_unshift(
                                    $node->stmts,
                                    $prop
                                );
                            }
                        }
                    }
                });
                $ast = $traverser->traverse($ast);
                $data = $printer->prettyPrintFile($ast);
                highlight_string($data);
            }
        }


        //
        // $traverser = new PhpParser\NodeTraverser;
        // $traverser->addVisitor(new class extends PhpParser\NodeVisitorAbstract {
        //     public function enterNode(PhpParser\Node $node) {
        //         if ($node instanceof PhpParser\Node\Stmt\Function_) {
        //
        //             $node->stmts[] = new PhpParser\Node\Stmt\Expression(
        //                 new PhpParser\Node\Expr\Assign(
        //                     new PhpParser\Node\Expr\Variable('test'),
        //                     new PhpParser\Node\Expr\Closure([
        //                         'uses' => [
        //                             new PhpParser\Node\Expr\Variable('hoge')
        //                         ],
        //                         'stmts' => [
        //                             new PhpParser\Node\Stmt\Return_(
        //                                 new PhpParser\Node\Expr\Variable('hoge')
        //                             )
        //                         ]
        //                     ])
        //                 )
        //             );
        //             $node->stmts[] = new PhpParser\Node\Stmt\Expression(
        //                 new PhpParser\Node\Expr\Assign(
        //                     new PhpParser\Node\Expr\Variable('ret'),
        //                     new PhpParser\Node\Expr\FuncCall(
        //                         new PhpParser\Node\Expr\Variable('test'),
        //                         [
        //                             new PhpParser\Node\Arg(
        //                                 new PhpParser\Node\Scalar\String_((string) "aaaa")
        //                             )
        //                         ]
        //                     )
        //                 )
        //             );
        //             $node->stmts[] = new PhpParser\Node\Stmt\Return_(
        //                 new PhpParser\Node\Expr\Variable('ret')
        //             );
        //
        //             // $node->stmts[] = new PhpParser\Node\Expr\String_((string) ";");
        //         }
        //     }
        // });
        //     
        // $ast = $traverser->traverse($ast);

        /*eval('?>'.$data);*/
        echo '<pre>';
        echo (new PhpParser\NodeDumper)->dump($ast);

        test('aaaa');

        die();


        foreach ($domain as $name => $data) {
            var_dump($name);
        }


        var_dump($domain);
        die();
    }
}
