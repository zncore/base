<?php

namespace ZnCore\Base\Encoders;

use ZnCore\Base\Helpers\StringHelper;
use Symfony\Component\Serializer\Encoder\XmlEncoder as SymfonyXmlEncoder;
use Exception;
use InvalidArgumentException;
use DomainException;
use ZnCore\Contract\Encoder\Interfaces\EncoderInterface;
use ZnCore\Contract\Encoder\Interfaces\PrettifyInterface;

class XmlEncoder implements EncoderInterface, PrettifyInterface
{

    private $formatOutput;
    private $encoding;
    private $xml;
    private $isInline;

    public function __construct(bool $formatOutput = true, string $encoding = 'UTF-8', bool $isInline = true)
    {
        $this->formatOutput = $formatOutput;
        $this->encoding = $encoding;
        $this->isInline = $isInline;
        $this->xml = new SymfonyXmlEncoder();
    }

    public function isFormatOutput(): bool
    {
        return $this->formatOutput;
    }

    public function setFormatOutput(bool $formatOutput): void
    {
        $this->formatOutput = $formatOutput;
    }

    public function getEncoding(): string
    {
        return $this->encoding;
    }

    public function setEncoding(string $encoding): void
    {
        $this->encoding = $encoding;
    }

    public function isInline(): bool
    {
        return $this->isInline;
    }

    public function setIsInline(bool $isInline): void
    {
        $this->isInline = $isInline;
    }

    public function encode($data)
    {
        if (empty($data)) {
            throw new InvalidArgumentException('Empty data');
        }
        if (count($data) > 1) {
            throw new DomainException('Empty root name and collection type array');
        }
        $encoded = $this->xml->encode($data, 'xml', $this->getContext());
        $encoded = $this->fixEncode($encoded);
        return trim($encoded);
    }

    public function decode($encoded)
    {
        $decoded = $this->xml->decode($encoded, 'xml', $this->getContext());
        $rootName = $this->getRootName($encoded);
        return [
            $rootName => $decoded,
        ];
    }

    public function c14nify($encoded)
    {
        $d = new \DOMDocument();
        $d->loadXML($encoded);
        return $d->C14N();
    }

    public function prettify($encoded)
    {
        $xmlEncoder = clone $this;
        $xmlEncoder->setIsInline(false);
        $decoded = $xmlEncoder->decode($encoded);
        return $xmlEncoder->encode($decoded);
    }

    private function fixEncode(string $encoded): string
    {
        $encoded = str_replace('<response>', '', $encoded);
        $encoded = str_replace('</response>', '', $encoded);
        $encoded = str_replace("\n  ", "\n", $encoded);
        if($this->isInline) {
            $encoded = preg_replace("#\n+#", "", $encoded);
            $encoded = preg_replace("#\t+#", "", $encoded);
            //$encoded = StringHelper::removeDoubleSpace($encoded, '\n', "\n");
        }
        return $encoded;
    }

    private function getContext()
    {
        return [
            SymfonyXmlEncoder::ENCODING => $this->encoding,
            SymfonyXmlEncoder::FORMAT_OUTPUT => $this->formatOutput,
//            XmlEncoder::STANDALONE => 'xmlStandalone',
        ];
    }

    private function getRootName(string $encoded)
    {
        $xml = simplexml_load_string($encoded);
        $rootName = $xml->getName();
        return $rootName;
    }
}