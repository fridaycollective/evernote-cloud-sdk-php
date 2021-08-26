<?php

namespace Evernote\Enml\Converter;

class EnmlToHtmlConverter implements HtmlConverterInterface
{
    protected $api_url;

    public function __construct($api_url)
    {
        $this->api_url = $api_url;
    }

    public function convertToHtml($content)
    {
        return $this->xslTransform($content, __DIR__ . '/enml2html.xslt');
    }

    public function xslTransform($enml, $xsl_file)
    {
        $xml = new \DOMDocument();
        @$xml->loadXML($enml);

        $xsl = new \DOMDocument();
        $xsl->load($xsl_file);

        $proc = new \XSLTProcessor();
        $proc->importStyleSheet($xsl); // attach the xsl rules
        $proc->setParameter('', 'API_URL', $this->api_url);

        return $proc->transformToXML($xml);
    }
} 