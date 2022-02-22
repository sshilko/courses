<?php

namespace App\Services;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;

class MarkdownHelper
{
    private $parser;
    private $cache;
    private $isDebug;
    private $logger;

    public function __construct(MarkdownParserInterface $markdownParser, CacheInterface $cache, LoggerInterface $mdLogger, bool $isDebug)
    {
        $this->parser = $markdownParser;
        $this->cache = $cache;
        $this->isDebug = $isDebug;
        $this->logger = $mdLogger;
    }

    public function parse(string $source): string
    {
        $this->logger->info('Meow=' . time());
        #dump($this->isDebug);

        if ($this->isDebug) {
            return $this->parser->transformMarkdown($source);
        }

        return $this->cache->get('markdown_' . md5($source), function() use ($source) {
            return $this->parser->transformMarkdown($source);
        });
    }

}