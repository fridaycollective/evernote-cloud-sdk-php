<?php

namespace Evernote\Enml\HtmlCleaner;

class HtmlPurifier implements HtmlCleanerInterface
{
    protected $htmlPurifier;

    protected $config;

    public function __construct(\HTMLPurifier_Config $config = null)
    {
        $this->htmlPurifier = new \HTMLPurifier();
        if (null === $config) {
            $config = \HTMLPurifier_Config::createDefault();
            $config->set('HTML.DefinitionID', 'crankcrm evernote');
            $config->set('HTML.DefinitionRev', 3);
            if ($def = $config->maybeGetRawHTMLDefinition()) {
                $def->addElement('evernote-resource-vue-component', 'Block', 'Flow', 'Common');
                $def->addAttribute('evernote-resource-vue-component', 'hash', 'CDATA');
                $def->addAttribute('evernote-resource-vue-component', 'type', 'CDATA');
            }
        }
        $this->config = $config;
    }

    public function clean($html)
    {
        return $this->htmlPurifier->purify($html, $this->config);
    }
}